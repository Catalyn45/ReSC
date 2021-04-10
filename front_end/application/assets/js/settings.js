document.querySelector(".main_panel__text").onmousemove = function(e) {
    document.querySelectorAll(".changeable").forEach(el => el.classList.remove("changeable__hovered"));

    if (e.target.classList.contains("changeable")) {
        e.target.classList.add("changeable__hovered");
    }
}