function onJsonLike(json){
    console.log(json);
    return null;
}

function handleLikes(event){
    const likeButton = event.currentTarget;
    const id = likeButton.parentNode.parentNode.parentNode.id;
    num_id = id.substring(id.indexOf('_') + 1, id.length);
    const numLikes = likeButton.parentNode.getElementsByClassName('num-likes')[0];

    const form = new FormData()
    form.append('post_id', num_id); //ID del post da mandare durante la Fetch con method:POST per aggiornare sul DB il like messo
    
    if(likeButton.classList.contains('like')){
        likeButton.src = './images/not_liked.png';

        fetch('./php/remove_like.php', {
                method: "POST",
                body: form}
        ).then(onResponse).then(onJsonLike);

        likeButton.classList.add('not_like');
        likeButton.classList.remove('like');
        numLikes.textContent = (parseInt(numLikes.textContent) -1).toString();

    }else{

        likeButton.src = './images/liked.png';

        fetch('./php/add_like.php', {
            method: "POST",
            body: form
    }).then(onResponse).then(onJsonLike);

        likeButton.classList.add('like');
        likeButton.classList.remove('not_like');
        numLikes.textContent = (parseInt(numLikes.textContent) + 1).toString();
    }
 
}
