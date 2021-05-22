var logout_button = document.getElementById("logout");

logout_button.addEventListener("click", function(event) {
    event.preventDefault();
    logout();
});

function logout() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            window.location.href = "/public/home";
        }
    };

    xhr.open("POST", "/public/api/logout", true);
    xhr.send();
}