function onResponse(response) {
    if (!response.ok) {
        console.log('Reponse Fallita');
        return null};
    return response.json();
}

function onJsonPosts(json){
    const posts = document.getElementById('posts_container');
    console.log(json);
    for(let block of json){
        const postBlock = createPost(block);
        posts.appendChild(postBlock);
    }
}

function createPost(post){
    //<div class="post_block">
    const postBlock = document.createElement('div');
    postBlock.classList.add('post_block');
    postBlock.id = "post_" + post.postid;

    //<div class="post-header">
    const postHeader = document.createElement('div');
    postHeader.classList.add('post-header');
    
    //<div class="post-content">
    const postContent = document.createElement('div');
    postContent.classList.add('post-content');

    //<div class="post-buttons">
    const postButtons = document.createElement('div');
    postButtons.classList.add('post-buttons');

    //<div class="user-info-cont">
    const userInfoCont = document.createElement('div');
    userInfoCont.classList.add('user-info-cont');

    //<img class="profile-photo">
    const profilePhoto = document.createElement('img');
    profilePhoto.classList.add('profile-photo');
    profilePhoto.src = "data:image/jpg;charset=utf8;base64," + post.userphoto;
    userInfoCont.appendChild(profilePhoto);

    //<div class="user-info">
    const userInfo = document.createElement('div');
    userInfo.classList.add('user-info');

    //<h4 class="name">
    const nameHeader = document.createElement('h4');

    nameHeader.classList.add('name');
    nameHeader.textContent = post.name + " " + post.surname;
    userInfo.appendChild(nameHeader);

    //<h4 class="username">
    const userHeader = document.createElement('h4');
    userHeader.classList.add('username');
    userHeader.textContent = "@" + post.username;
    userInfo.appendChild(userHeader);
    userInfoCont.appendChild(userInfo);

    //<div class="post-time-cont">
    const postTimeCont = document.createElement('div');
    postTimeCont.classList.add('post-time-cont');


    //<h4 class="time">
    const postTime = document.createElement('h4');
    postTime.classList.add('post-time');
    postTime.textContent = post.time;
    postTimeCont.appendChild(postTime);

    if(myProfileButton.classList.contains('current-page')){
        //<img class="dots">
        const dots = document.createElement('img');
        dots.classList.add('dots');
        dots.src =  './images/dots.png';
        dots.addEventListener('click', function(event){
                    button = event.currentTarget.parentNode.getElementsByClassName('delete-button')[0];
                    if(button.classList.contains('hidden')){
                        button.classList.remove('hidden');
                    }else{
                        button.classList.add('hidden');
                    }
                });
        postTimeCont.appendChild(dots);

        //Delete button
        const deleteButton = document.createElement('input');
        deleteButton.classList.add('button');
        deleteButton.classList.add('delete-button');
        deleteButton.setAttribute('type', 'submit');
        deleteButton.setAttribute('value', 'Delete');
        deleteButton.classList.add('hidden');
        deleteButton.addEventListener('click', deletePost);
        postTimeCont.appendChild(deleteButton);
    }


    postHeader.appendChild(userInfoCont);
    postHeader.appendChild(postTimeCont);


    //<p class="post-text">
    const postText = document.createElement('p');
    postText.classList.add("post-text");
    postText.textContent = post.posttext;
    postContent.appendChild(postText);

    //<img class="photo">
    const postPhoto = document.createElement('img');
    postPhoto.classList.add("photo");
    if(post.posttype == 0){
        postPhoto.src = "data:image/jpg;charset=utf8;base64," + post.postphoto;
    }else if(post.posttype == 1){
        
        postPhoto.src = post.postgif;
       
    }
    postPhoto.addEventListener('click', openModalView);
    postContent.appendChild(postPhoto);

    //<div class="post-likes">"
    const postLikes = document.createElement('div');
    postLikes.classList.add("post-likes");
    postButtons.appendChild(postLikes);

    //<div class="post-comments">
    const postComments = document.createElement('div');
    postComments.classList.add("post-comments");
    postButtons.appendChild(postComments);


    //<img class="like">
    const like = document.createElement('img');
    if(post.liked === "1"){
        like.src = './images/liked.png';
        like.classList.add('like');
    }else{
        like.src = './images/not_liked.png';
        like.classList.add('not_like');
    }
    postLikes.appendChild(like);
    like.addEventListener('click', handleLikes);

     //<h4 class="num-likes">
    const numLikes = document.createElement('h4');
    numLikes.classList.add("num-likes");
    numLikes.textContent = post.nlikes;
    postLikes.appendChild(numLikes);

    //<img class="comment">
    const comment = document.createElement('img');
    comment.classList.add('comment');
    comment.src = './images/comment.png';
    comment.addEventListener('click', openModalView);
    postComments.appendChild(comment);   

    //<h4 class="num-comments">
    const numComments = document.createElement('h4');
    numComments.classList.add("num-comments");
    numComments.textContent = post.ncomments;
    postComments.appendChild(numComments);


    //Aggiungi gli elementi al postBlock
    postBlock.appendChild(postHeader);
    postBlock.appendChild(postContent);
    postBlock.appendChild(postButtons);

    return postBlock;
}



function openModalView(event){ 
    const photo = document.createElement('img');
    photo.classList.add('photo-modal');
    if(event.currentTarget.classList.contains('comment')){
        photo.src = event.currentTarget.closest('.post_block').getElementsByClassName('photo')[0].src;
    }else{
        photo.src = event.currentTarget.src;
    }


    document.body.classList.add('no-scroll');
    modalView.style.top = window.pageYOffset +'px';
    modalPhotoContainer.appendChild(photo);
    modalView.classList.remove('hidden');

    postID = event.currentTarget.closest('.post_block').id;
    num_id = postID.substring(postID.indexOf('_') + 1, postID.length);
    photo.id = 'photo_' + num_id;
    loadComments(postID);
}

function onModalClick(event){
    document.body.classList.remove('no-scroll');
    modalView.classList.add('hidden');
    modalPhotoContainer.innerHTML = '';
    commentsContainer.innerHTML = '';
}


const modalView = document.getElementById('modal-view');
const modalPost = document.getElementById('post-modal');
modalPost.addEventListener('click', function(event){event.stopPropagation();})
modalView.addEventListener('click', onModalClick);

const modalPhotoContainer = document.getElementById('post-image');
const commentsContainer = document.getElementById('comments');
const postCommentButton = document.getElementById('post-comment');
postCommentButton.addEventListener('click', postComment);



const homeButton = document.getElementById('home-button');
const myProfileButton = document.getElementById('my-profile-button');
//const searchButton = document.getElementById('search-button');



//A seconda della pagina in cui siamo chiamiamo lo script load_posts.php con un parametro diverso

if(homeButton.classList.contains('current-page')){
    const form = new FormData();
    form.append('type','home');
    fetch('./php/load_posts.php',{
        method: "POST",
        body: form}).then(onResponse).then(onJsonPosts);
          
}else if(myProfileButton.classList.contains('current-page')){
    const form = new FormData();
    form.append('type','my-profile');
    fetch('./php/load_posts.php',{
        method: "POST",
        body: form}).then(onResponse).then(onJsonPosts);  
}

