document.querySelector("#colors_container").onmousemove = function(e) {
    document.querySelectorAll(".changeable").forEach(el => el.classList.remove("changeable__hovered"));

    if (e.target.classList.contains("changeable")) {
        e.target.classList.add("changeable__hovered");
    }
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function rgbValues(rgbString) {
    m = rgbString.match(/^rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/i);
    if (m) {
        return [
            parseInt(m[1]),
            parseInt(m[2]),
            parseInt(m[3])
        ];
    }
}

function get_configuration() {

    let configBody = {};

    let colors = {
        chatcolor_top: document.getElementById('chat_colors__header'),
        chatcolor_mid: document.getElementById('chat_colors__content'),
        chatcolor_input: document.getElementById('chat_colors__bottom__input'),
        chatcolor_button: document.getElementById('chat_colors__bottom__send'),
        chatcolor_client: document.getElementById('chat_colors__content__me'),
        chatcolor_stranger: document.getElementById('chat_colors__content__stranger')
    };

    for (const [key, value] of Object.entries(colors)) {
        let values = rgbValues(window.getComputedStyle(value).backgroundColor);
        configBody[key] = rgbToHex(values[0], values[1], values[2]);
    }

    // line and column are temporary hardcoded

    let position = {
        chatposition_line: { value: 3 },
        chatposition_column: { value: 3 }
    };

    for (const [key, value] of Object.entries(position)) {
        configBody[key] = value.value;
    }

    let callbacks = {
        callback_close: document.getElementById('close_cb'),
        callback_hide: document.getElementById("hide_cb")
    }

    for (const [key, value] of Object.entries(callbacks)) {
        if (value.value != "")
            configBody[key] = value.value;
    }

    let names = {
        class_name: document.getElementById('class_name'),
        object_name: document.getElementById("object_name")
    }

    for (const [key, value] of Object.entries(names)) {
        if (value.value != "")
            configBody[key] = value.value;
    }

    console.log(configBody);

    return configBody;
}

function send_configuration(update = true) {
    let configuration = get_configuration();

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            //window.location.href = "/public/settings";
            console.log(xhr.response);
        }
    };

    xhr.open("POST", "/public/api/" + (update ? "update_configuration" : "register_configuration"), true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify(configuration));
}