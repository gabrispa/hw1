function onJsonUserSearched(json){
    console.log(json);
    document.getElementById('posts_container').innerHTML='';
    if(json.response === false){
        document.getElementById('user-not-found').classList.remove('hidden');
        document.getElementById('profile-info').classList.add('hidden');
        
    }else{
        document.getElementById('user-not-found').classList.add('hidden');
        document.getElementById('profile-info').classList.remove('hidden');
        onJsonUserInfo(json);

        const form = new FormData();
        form.append('type','search-user');
        form.append('searched', encodeURIComponent(document.getElementById('user-to-find').value));
        form.append('searched-id', json[0].userid);
        fetch('./php/load_posts.php',{
            method: "POST",
            body: form}).then(onResponse).then(onJsonPosts); 
    }
}

function searchUser(event){
    event.preventDefault();
    
    userToFind = encodeURIComponent(document.getElementById('user-to-find').value);
    const form = new FormData()
    form.append('username', userToFind);

    fetch('./php/load_user_info.php', {
        method: "POST",
        body: form}).then(onResponse).then(onJsonUserSearched);
}

const search = document.getElementById('search');
search.addEventListener('click', searchUser);