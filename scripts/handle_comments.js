function onJsonComments(json){
    console.log(json);
    const commentsContainer = document.getElementById('comments');
    for(let block of json){
        const commentBlock = createComment(block);
        commentsContainer.appendChild(commentBlock);
    }
}

function loadComments(id){
    const commentsContainer = document.getElementById('comments');
    commentsContainer.innerHTML = '';
    commentEntry = document.getElementById('comment-entry');
    commentEntry.value = '';

    const form = new FormData()
    num_id = id.substring(id.indexOf('_') + 1, id.length);
    //console.log(num_id);
    form.append('post_id', num_id);
    console.log("post id:" + num_id);

    fetch("./php/load_comments.php",{
        method: "POST",
        body: form
    }).then(onResponse).then(onJsonComments); 
}

function createComment(comment){
    //<div class="text-comment">
    const commentBlock = document.createElement('div');
    commentBlock.classList.add('single-comment');
    commentBlock.id = 'comment_' + comment.commentid;

    //<h4 class="username-comment">
    const usernameComment = document.createElement('h4');
    usernameComment.classList.add('username-comment');
    usernameComment.textContent= '@' + comment.username + ': ';
    commentBlock.appendChild(usernameComment);

    //<p class="text-comment">
    const textComment = document.createElement('p');
    textComment.classList.add('text-comment');
    textComment.textContent= comment.text;
    commentBlock.appendChild(textComment);

    return commentBlock;
}

function onJsonCommentPosted(json){
    console.log(json);
    const id = document.getElementById('post-image').getElementsByClassName('photo-modal')[0].id;
    const num_id =  id.substring(id.indexOf('_') + 1, id.length);
    loadComments(num_id);

    //Aggiorno il numero di commenti nella scroll-view
    //console.log(id);
    const commentButton = document.getElementById('post_' + num_id).getElementsByClassName('num-comments')[0];
    commentButton.textContent = (parseInt(commentButton.textContent) + 1).toString();
}


function postComment(event){
    event.preventDefault();
    const commentEntry = document.getElementById('comment-entry');
    const input = commentEntry.value;
    //console.log(input);
    if(/^ *$/.test(input) || !input){
       
        return null;
    }

    const id = event.currentTarget.closest('#post-modal').getElementsByClassName('photo-modal')[0].id;
    //console.log(id);
    const num_id =  id.substring(id.indexOf('_') + 1, id.length);

    const form = new FormData()
    form.append('post_id', num_id);
    form.append('text', input);

    fetch('./php/post_comment.php', {
        method: "POST",
        body: form}).then(onResponse).then(onJsonCommentPosted);
}
