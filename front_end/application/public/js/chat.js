var socket;
var current_connection = {
    client_id: -1,
    conversation_id: -1
};

var token = document.cookie.substring(10);

var tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};

function replaceTag(tag) {
    return tagsToReplace[tag] || tag;
}

function safe_tags_replace(str) {
    return str.replace(/[&<>]/g, replaceTag);
}

function process_text(str) {
    let processed = safe_tags_replace(str);
    return processed.replaceAll(/(^| ):([a-z]+):( |$)/g, '$1<img class="emoji" src="resources/emojis/$2.png" onerror="(emoji_on_error.bind(this))()">$3');
}

function emoji_on_error() {
    let fallbacks = [
        "https://cdn.emojidex.com/emoji/seal/",
        "/resources/emojis/not_found.png"
    ];

    let index = fallbacks.findIndex(element => {
        return this.src.includes(element);
    });

    if (index > fallbacks.length)
        return;

    index++;

    console.log(index);

    if (index != fallbacks.length - 1) {
        let fileName = this.src.substring(this.src.lastIndexOf('/') + 1);
        fallbacks[index] += fileName;
    }

    this.src = fallbacks[index]
}

var blob = new Blob(["Welcome to Websparrow.org."], { type: "text/plain;charset=utf-8" });

function get_client() {
    let message = {
        method: "AcceptClient",
        authority: "ADMIN",
        token: token
    };

    socket.send(JSON.stringify(message));
};

function get_waiting_count() {
    fetch(`/api/get_waiting_clients`, { credentials: "same-origin" })
        .then(response => response.json())
        .then(data => {
            let nr = data.response;

            if (nr > 0) {
                let notif = document.getElementById('clients_waiting');
                notif.style.visibility = "visible";
                notif.innerHTML = nr;
            }
        });
}

function save_conv() {
    fetch(`/api/get_messages?conversation_id=${current_connection.conversation_id}`, { credentials: "same-origin" })
        .then(response => response.json())
        .then(data => {
            let messages = data.response;
            let textToSave = "";
            for (i = 0; i < messages.length; i++) {
                let messageSender = "";

                if (messages[i].sender == "client") {
                    messageSender = document.getElementById("client_name").innerHTML;
                } else {
                    messageSender = "Admin";
                }

                textToSave += `${messageSender} : ${messages[i].message}\n`;
            }

            let blob = new Blob([textToSave], { type: "text/plain;charset=utf-8" });
            saveAs(blob, "conversation.txt");
        });
}

function close_client() {
    let message = {
        method: "CloseClient",
        authority: "ADMIN",
        token: token,
        client_id: current_connection.client_id
    };

    let client_to_close = document.getElementById(`chat_conversation_${current_connection.conversation_id}`);

    if (!client_to_close.classList.contains("chat__disconnected")) {
        socket.send(JSON.stringify(message));
    }

    client_to_close.remove();

    let containers = document.getElementsByClassName("chat_container__chats__element");

    if (containers.length > 1) {
        containers[1].click();
    } else {
        document.getElementById("chat_container__conversation").style.display = "none";
        current_connection.conversation_id = -1;
        current_connection.client_id = -1;
    }
}

function addClientBar(client_id, clientName, conversation_id) {
    let id = `chat_conversation_${conversation_id}`;
    let clientBar = `
<div class="chat_container__chats__element" id="${id}">
    <p>${clientName}</p>
    <span class="notification" id="chat_notification_${conversation_id}">0</span>
</div>
    `;

    document.getElementById("chat_container__chats").insertAdjacentHTML("beforeend", clientBar);

    document.getElementById(id).addEventListener("click", function(e) {

        let elems = document.getElementsByClassName("chat_container__chats__element");

        for (i = 0; i < elems.length; i++) {
            if (elems[i].classList.contains("chat__current")) {
                elems[i].classList.remove("chat__current");
            }
        }

        this.classList.add("chat__current");

        if (this.classList.contains("chat__disconnected")) {
            document.getElementById("dot").style.setProperty('--color', "red");
            document.getElementById("dot").style.setProperty('--text', '"\u2022 \u0020 disconnected"');
            document.getElementById("input_message").disabled = true;
            document.getElementById("send_message").disabled = true;
        } else {
            document.getElementById("dot").style.setProperty('--color', "green");
            document.getElementById("dot").style.setProperty('--text', '"\u2022 \u0020 connected"');
            document.getElementById("input_message").disabled = false;
            document.getElementById("send_message").disabled = false;
        }

        document.getElementById(`chat_notification_${conversation_id}`).innerHTML = "0";
        document.getElementById(`chat_notification_${conversation_id}`).style.visibility = "hidden";

        current_connection.client_id = client_id;
        current_connection.conversation_id = conversation_id;

        fetch(`/api/get_messages?conversation_id=${conversation_id}`, { credentials: "same-origin" })
            .then(response => response.json())
            .then(data => {
                document.getElementById("chat_container__conversation__content").innerHTML = "";
                document.getElementById("chat_container__conversation").style.display = "flex";
                document.getElementById("client_name").innerHTML = clientName;
                let messages = data.response;
                console.log(messages);
                for (i = 0; i < messages.length; i++) {
                    if (messages[i].sender == "admin") {
                        meMsg(messages[i].message);
                    } else {
                        strangerMsg(messages[i].message);
                    }
                }
            });
    });
}

socket = new WebSocket(`wss://${window.location.host}/wss`);

socket.onopen = function(e) {
    get_waiting_count();
    socket.send(JSON.stringify({
        method: "ConnectAdmin",
        authority: "ADMIN",
        token: token
    }));
}

socket.onmessage = function(e) {
    console.log(e.data);
    let response = JSON.parse(e.data);
    console.log(response.response_type);
    if (response.response_type == "got_client") {
        let notif = document.getElementById('clients_waiting');
        let nr = parseInt(notif.innerHTML);

        if (nr > 0) {
            notif.innerHTML = nr - 1;
            if (nr - 1 == 0) {
                notif.style.visibility = "hidden";
            }
        }

        addClientBar(response.client_id, response.client_name, response.conversation_id);
    } else if (response.response_type == "message") {
        console.log("message");
        if (current_connection.client_id == response.client_id) {
            strangerMsg(response.message);
        } else {
            console.log(response.conversation_id);
            let notif = document.getElementById(`chat_notification_${response.conversation_id}`);
            notif.style.visibility = "visible";
            let nr = parseInt(notif.innerHTML);
            notif.innerHTML = nr + 1;
        }
    } else if (response.response_type == "disconnected") {
        if (current_connection.client_id == response.client_id) {
            document.getElementById("dot").style.setProperty('--color', "red");
            document.getElementById("dot").style.setProperty('--text', '"\u2022 \u0020 disconnected"');
            document.getElementById("input_message").disabled = true;
            document.getElementById("send_message").disabled = true;
        }

        let client_container = document.getElementById(`chat_conversation_${response.conversation_id}`);
        client_container.classList.add("chat__disconnected");
        console.log(client_container);
    } else if (response.response_type == "client_start_waiting") {
        let notif = document.getElementById('clients_waiting');
        notif.style.visibility = "visible";
        let nr = parseInt(notif.innerHTML);
        notif.innerHTML = nr + 1;
    } else if (response.response_type == "client_stop_waiting") {
        let notif = document.getElementById('clients_waiting');
        let nr = parseInt(notif.innerHTML);
        notif.innerHTML = nr - 1;

        if (nr - 1 == 0) {
            notif.style.visibility = "hidden";
        }
    }

    console.log(response);
}

function strangerMsg(message) {
    message = process_text(message);
    const backMessage = `
    <div class="message message_stranger">
        <p>${message}</p>
    </div>
    `;
    let content = document.getElementById('chat_container__conversation__content');
    content.insertAdjacentHTML('beforeend', backMessage);
    content.scrollBy(0, content.scrollHeight);
}

function meMsg(message) {
    message = process_text(message);
    let content = document.getElementById('chat_container__conversation__content');
    const sendMessage = `
    <div class="message message_me">
        <p>${message}</p>
    </div>
    `;

    content.insertAdjacentHTML('beforeend', sendMessage);
    content.scrollBy(0, content.scrollHeight);
}

function sendMsg() {
    let input_text = document.getElementById('input_message');

    socket.send(JSON.stringify({
        method: "AdminMessage",
        authority: "ADMIN",
        token: token,
        client_id: current_connection.client_id,
        message: input_text.value
    }));

    meMsg(input_text.value);

    input_text.value = "";
    input_text.focus();
}

document.getElementById("input_form").addEventListener("submit", function(e) {
    e.preventDefault();
    sendMsg();
});