function onJsonUserInfo(json){

    const userPhoto = document.getElementById('profile-photo');
    userPhoto.src = "data:image/jpg;charset=utf8;base64," +  json[0].photo;

    const nameSurname = document.getElementById('name-surname');
    nameSurname.textContent = json[0].name + " " + json[0].surname;

    const username = document.getElementById('username');
    username.textContent = "@" + json[0].username;

    const nposts = document.getElementById('nposts');
    const nlikes = document.getElementById('nlikes');
    const ncomments = document.getElementById('ncomments');

    nposts.textContent = json[0].nposts;
    nlikes.textContent = json[0].nlikes;
    ncomments.textContent = json[0].ncomments;
}

fetch('./php/load_user_info.php').then(onResponse).then(onJsonUserInfo);