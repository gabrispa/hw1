function validate(event){
    if(form.username.value.lentgh == 0 || form.password.value.length == 0 ){
        alert("Compilare tutti i campi!");
        event.preventDefault();
    }
}

function checkUsername(){
    const errorElement = document.getElementById("error-user");
    const input = document.getElementById('entry-user');
    if(/^ *$/.test(input.value) || !input.value){
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
    } else {
        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
    } 
}

function checkPassword(){
    const errorElement = document.getElementById("error-password");
    const input = document.getElementById('entry-password');
    if(/^ *$/.test(input.value) || !input.value){
        errorElement.classList.remove("hidden");
        errorElement.classList.add("show");
    } else {
        errorElement.classList.remove("show");
        errorElement.classList.add("hidden");
    } 
}

const form = document.forms['login-form'];
form.addEventListener('submit', validate);