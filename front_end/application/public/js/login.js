var loginForm = document.getElementById("login_form");

loginForm.addEventListener("submit", function(event) {
    event.preventDefault();
    login();
});

function login() {

    let username_input = document.getElementById("username");
    let password_input = document.getElementById("password");

    let credentials = {
        name: username_input.value,
        password: sha256(password_input.value)
    };

    console.log(credentials.name);
    console.log(credentials.password);

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {

            if (this.status == 200)
                window.location.href = "/public/settings";
            else
                window.location.href = "/public/login"

            // console.log(xhr.response);
        }
    };

    xhr.open("POST", "/public/api/login", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify(credentials));
}