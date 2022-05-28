function onResponse(response) {
    if (!response.ok) {
        console.log('Reponse Fallita');
        return null};
    return response.json();
}

function displayImage(event){
    const file = document.forms['upload-form']['upload-image'].files[0];
    console.log(file);

    uploadFile.classList.add('button-after-display');
    
    image.classList.add('image-displayed');
    console.log(URL.createObjectURL(file));
    image.src = URL.createObjectURL(file);
    container.appendChild(image);
}

function submitForm(event){
    const textEntry = document.getElementById("text-entry");
    const files = document.forms['upload-form']['upload-image'].files;

    if(!textEntry.value || /^ *$/.test(textEntry.value) || ((files.length === 0) && (!document.getElementById("id-gif").value)) ){
        event.preventDefault();
        alert("Devi riempire tutti i campi correttamente per proseguire!");
        return null;
    }

}

function radioChanged(event){
    if(document.getElementsByClassName('image-displayed').length > 0) 
            document.getElementsByClassName('image-displayed')[0].remove();
    if(document.getElementsByClassName('gif-displayed').length > 0) 
            document.getElementsByClassName('gif-displayed')[0].remove();

    if(uploadChoice.checked === true){
       uploadFile.classList.remove('hidden');
       searchGifDiv.classList.add('hidden');
       document.getElementById("id-gif").value = null;
    }else if(searchChoice.checked === true){
        uploadFile.classList.add('hidden');
        searchGifDiv.classList.remove('hidden');
        
    }
}

function onJsonGifSearched(json){
    console.log(json);
    image.classList.add('gif-displayed');
    
    image.src = json[0].preview;
    container.appendChild(image);

    document.getElementById("id-gif").value = json[0].preview;
}


function searchGif(event){
    event.preventDefault();
    searchGifDiv.classList.add('searchbar-after-display');
    
    const form = new FormData()
    form.append('q', searchGifEntry.value);

    fetch("../php/search_giphy.php",{
        method: "POST",
        body: form
    }).then(onResponse).then(onJsonGifSearched);
}




const uploadFile = document.getElementById('upload-image');
uploadFile.addEventListener('input', displayImage);
const container = document.getElementById('add-photo');
const image = document.createElement('img');

const sendButton = document.getElementById('send-post');
sendButton.addEventListener('click', submitForm);


const uploadChoice = document.getElementById('upload-choice');
const searchChoice = document.getElementById('search-choice');
uploadChoice.addEventListener('change', radioChanged);
searchChoice.addEventListener('change', radioChanged);

const searchGifButton = document.getElementById('search-gif-button');
searchGifButton.addEventListener('click', searchGif);
const searchGifEntry = document.getElementById('search-gif-entry');

const searchGifDiv = document.getElementById('search-gif');


