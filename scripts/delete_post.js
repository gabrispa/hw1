function onJsonDeletePost(json){
    console.log(json);
}

function onResponse(response) {
    if (!response.ok) {
        console.log('Reponse Fallita');
        return null};
    return response.json();
}

function deletePost(event){ 
    if(confirm("Sei sicuro di voler cancellare il post?")){
        const id = event.currentTarget.closest('.post_block').id;
        const num_id =  id.substring(id.indexOf('_') + 1, id.length);

        const form = new FormData();
        form.append('post-id', num_id);

        fetch('./php/delete_post.php', {
            method: "POST",
            body: form}).then(onResponse).then(onJsonDeletePost);

        location.reload();
    }else{
        return null;
    }
}