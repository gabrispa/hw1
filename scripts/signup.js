function checkName(){
    const errorElement = document.getElementById("error-name");
    const input = document.getElementById('entry-name');
    if(/^ *$/.test(input.value) || !input.value){
        //errorElement.textContent = "Inserisci il tuo nome.";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isNameFilled = false;
    } else {
        //errorElement.textContent = "NULL";
        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
        isNameFilled = true;
    } 
}

function checkSurname(){
    const errorElement = document.getElementById("error-surname");
    const input = document.getElementById('entry-surname');
    if(/^ *$/.test(input.value) || !input.value){
        //errorElement.textContent = "Inserisci il tuo cognome.";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isSurnameFilled = false;
    } else {
        //errorElement.textContent = "NULL";
        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
        isSurnameFilled = true;
    } 
}

function onResponse(response) {
    if (!response.ok) {return null};
    return response.json();
}

function onJsonUsername(json){
    const errorElement = document.getElementById("error-username");
    if(json.exists){
        errorElement.textContent = "Username già in uso con un altro account.";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isUsernameFilled = false;
    }
}

function onJsonEmail(json){
    const errorElement = document.getElementById("error-email");
    if(json.exists){
        errorElement.textContent = "E-mail già in uso con un altro account.";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isEmailFilled = false;
    }
}

function checkUsername() {
    const errorElement = document.getElementById("error-username");
    const input = document.getElementById('entry-username');
    
    if(!/^[a-zA-Z0-9_]{4,15}$/.test(input.value)) {
        errorElement.textContent = "Username non valido (usa solo caratteri, numeri e underscore, min.4 - max.15).";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isUsernameFilled = false;
    } else {
        //errorElement.textContent = "NULL";
        fetch("../php/check_username.php?q="+encodeURIComponent(input.value)).then(onResponse).then(onJsonUsername);

        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
        isUsernameFilled = true;
    }    
}

function checkEmail(){
    const errorElement = document.getElementById("error-email");
    const input = document.getElementById('entry-email');

    if(!/^[A-z0-9\.\+_-]+@[A-z0-9\._-]+\.[A-z]{2,6}$/.test(input.value)){
        errorElement.textContent = "Formato e-mail non valido.";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isEmailFilled = false;
    } else{
        //errorElement.textContent = "NULL";
        fetch("../php/check_email.php?q="+encodeURIComponent(input.value)).then(onResponse).then(onJsonEmail);

        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
        isEmailFilled = true;
    }
}

function checkPassword(){
    const errorElement = document.getElementById("error-password");
    const input = document.getElementById('entry-password');

    if(!/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/.test(input.value)){
        //errorElement.textContent = "Password non valida. Minimo 8 caratteri, tra cui una lettera maiuscola, una minuscola e un numero.";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isPasswordFilled = false;
    } else{
        //errorElement.textContent = "NULL";
        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
        isPasswordFilled = true;
    }
}

function checkConfPassword(){
    const errorElement = document.getElementById("error-confpassword");
    const input = document.getElementById('entry-confpassword');    
    const passwordEntry = document.getElementById("entry-password");

    if(input.value !== passwordEntry.value){
        //errorElement.textContent = "Le due password non coincidono.";
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        isConfPasswordFilled = false;
    } else{
        //errorElement.textContent = "NULL";
        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
        isConfPasswordFilled = true;
    }
}

function checkPropic(){
    const errorElement = document.getElementById("error-propic");
    const fileNameDiv = document.getElementById('file-name');
    const files = document.forms['signup-form']['propic'].files;
    const url = document.getElementById('entry-propic').value;
   
    if(files.length === 0){
        console.log("Nessuna Propic");
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
        fileNameDiv.classList.add('hidden');
        fileNameDiv.textContent='';
        isPropicSet = false;
    }else{
        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
        fileNameDiv.classList.remove('hidden');
        fileNameDiv.textContent = url.substring(url.lastIndexOf("\\") + 1);
        isPropicSet = true;
    }
}

function registerClicked(event){
    if(!isCompleted()){
        //const error = document.getElementById("top-error");
        //error.textContent = "Devi riempire tutti i campi correttamente per proseguire!";
        alert("Devi riempire tutti i campi correttamente per proseguire!");
        event.preventDefault();
    }
}

function isCompleted(){
    checkName();
    checkSurname();
    checkUsername();
    checkEmail();
    checkPassword();
    checkConfPassword();
    checkPropic();
    return isNameFilled && isSurnameFilled && isEmailFilled && isUsernameFilled && isPasswordFilled && isConfPasswordFilled &&isPropicSet;
}

let isNameFilled = false;
let isSurnameFilled = false;
let isUsernameFilled = false;
let isEmailFilled = false;
let isPasswordFilled = false;
let isConfPasswordFilled = false;
let isPropicSet = false;

const registerButton = document.getElementById("signup-button");
registerButton.addEventListener('click', registerClicked);