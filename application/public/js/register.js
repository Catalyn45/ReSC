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


    fetch("/api/create_account", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(credentials)
        })
        .then(response => response.json())
        .then(data => {
            username_input.value = "";
            password_input.value = "";
            r_password_input.value = "";
            email_input.value = "";
            host.value = "";

            if (data.response_type == "ERROR") {
                document.getElementById("message_board").style.background = "red";
            } else {
                document.getElementById("message_board").style.background = "green";
            }

            document.getElementById("message_board").style.display = "block";
            document.getElementById("message_board").innerHTML = data.message;
        })
        .catch(error => {
            console.log(error);
        });
}