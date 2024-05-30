function checkLogin() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    let formData = {
        email: email,
        password: password
    };

    console.log(formData);
}