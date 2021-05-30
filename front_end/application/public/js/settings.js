let colors = document.getElementsByClassName("changeable");
var lastclicked = null;

for (i = 0; i < colors.length; i++) {
    colors[i].addEventListener("mouseover", function(e) {
        e.stopPropagation();
        document.querySelectorAll(".changeable").forEach(el => el.classList.remove("changeable__hovered"));
        if (e.target.classList.contains("changeable")) {
            e.target.classList.add("changeable__hovered");
        }

    });

    colors[i].addEventListener("mouseleave", function(e) {
        e.stopPropagation();
        document.querySelectorAll(".changeable").forEach(el => el.classList.remove("changeable__hovered"));
    });

    colors[i].addEventListener("click", function(e) {
        e.stopPropagation();
        lastclicked = e.target;
        document.getElementById("color_picker").click();
    });
}

function change_func(t) {
    if (lastclicked == null)
        return;
    lastclicked.style.background = t.value;
}

function get_saved_configuration() {
    fetch("/api/get_configuration", { credentials: "same-origin" })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            let config = data.response;
            document.getElementById("chat_colors__header").style.background = `#${config.chatcolor_top}`;
            document.getElementById("chat_colors__content").style.background = `#${config.chatcolor_mid}`;
            document.getElementById("chat_colors__bottom__input").style.background = `#${config.chatcolor_input}`;
            document.getElementById("chat_colors__bottom__send").style.background = `#${config.chatcolor_button}`;
            document.getElementById("chat_colors__content__me").style.background = `#${config.chatcolor_client}`;
            document.getElementById("chat_colors__content__stranger").style.background = `#${config.chatcolor_stranger}`;

            let positions = document.getElementsByClassName("position__div");

            positions[config.chatposition_line * 3 + config.chatposition_column].id = "position__selected";

            document.getElementById("class_name").value = config.class_name;
            document.getElementById("object_name").value = config.object_name;

        });
}

let positions = document.getElementsByClassName("position__div");

for (i = 0; i < positions.length; i++) {
    positions[i].addEventListener("click", function(e) {
        let positions_to_clear = document.getElementsByClassName("position__div");

        for (j = 0; j < positions_to_clear.length; j++) {
            positions_to_clear[j].removeAttribute("id");
        }

        e.target.id = "position__selected";
        get_configuration();
    });
};

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

    console.log(colors);

    for (const [key, value] of Object.entries(colors)) {
        let values = rgbValues(window.getComputedStyle(value).backgroundColor);
        configBody[key] = rgbToHex(values[0], values[1], values[2]);
    }

    let columnIndex = document.getElementById("position__selected").closest("td").cellIndex;
    let rowIndex = document.getElementById("position__selected").closest("tr").rowIndex;

    console.log(columnIndex);
    console.log(rowIndex);

    let position = {
        chatposition_line: { value: rowIndex },
        chatposition_column: { value: columnIndex }
    };

    for (const [key, value] of Object.entries(position)) {
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

function send_configuration() {
    let configuration = get_configuration();

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            //window.location.href = "/public/settings";
            console.log(xhr.response);
        }
    };

    xhr.open("PATCH", "/api/update_configuration", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify(configuration));
}

get_saved_configuration();