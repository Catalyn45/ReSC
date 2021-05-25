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

    fetch("/api/login", {
        method: "POST",
        credentials: "include",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(credentials)
    }).then(function(response) {
        console.log(response);
        if (response.status == 200)
            window.location.href = "/settings";
        else
            window.location.href = "/login";
    });
}