var registerForm = document.getElementById("register_form");

registerForm.addEventListener("submit", function(event) {
    event.preventDefault();
    register();
});

function register() {
    let username_input = document.getElementById("username");
    let password_input = document.getElementById("password");
    let r_password_input = document.getElementById("r_password");
    let email_input = document.getElementById("email");
    let host = document.getElementById("host");

    if (password_input.value != r_password_input.value) {
        window.location.href = "/register";
        return;
    }

    let credentials = {
        name: username_input.value,
        password: sha256(password_input.value),
        email: email_input.value,
        host: host.value
    };

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200)
                window.location.href = "/login";
            else
                window.location.href = "/register"
            console.log(xhr.response);
        }
    };

    xhr.open("POST", "/api/create_account", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify(credentials));
}