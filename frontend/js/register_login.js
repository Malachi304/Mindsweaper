const login_BTN = document.getElementById('LogInButton')
const signup_BTN = document.getElementById('SignUpButton')
const register_section = document.getElementById('register-form')
const login_section = document.getElementById('login-form')

signup_BTN.addEventListener('click', function(){
    login_section.style.display="none";
    register_section.style.display="block";

})

login_BTN.addEventListener('click', function(){
    register_section.style.display="none";
    login_section.style.display="block";
})