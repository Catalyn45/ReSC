var socket;
var client_id;

var token = document.cookie.substring(10);

function get_client() {
    let message = {
        method: "AcceptClient",
        authority: "ADMIN",
        token: token,
        server_id: 1
    };

    socket.send(JSON.stringify(message));
};

socket = new WebSocket('ws://localhost:8081');

socket.onmessage = function(e) {
    let response = JSON.parse(e.data);

    if (response.response_type == "got_client") {
        client_id = response["client_id"];
        document.getElementById("input_form").addEventListener("submit", function(e) {
            e.preventDefault();
            sendMsg();
        });
        strangerMsg("Clientul este conectat");
    } else if (response.response_type != "success") {
        strangerMsg(response.message);
    }

    console.log(response);
}


function strangerMsg(message) {
    const backMessage = `
    <div class="message message_stranger">
        <p>${message}</p>
    </div>
    `;
    let content = document.getElementById('chat_container__conversation__content');
    content.insertAdjacentHTML('beforeend', backMessage);
    content.scrollBy(0, content.scrollHeight);
}

function sendMsg() {
    let content = document.getElementById('chat_container__conversation__content');
    let input_text = document.getElementById('input_message');

    const sendMessage = `
    <div class="message message_me">
        <p>${input_text.value}</p>
    </div>
    `;

    socket.send(JSON.stringify({
        method: "AdminMessage",
        authority: "ADMIN",
        token: token,
        server_id: 1,
        client_id: client_id,
        message: input_text.value
    }));

    content.insertAdjacentHTML('beforeend', sendMessage);
    content.scrollBy(0, content.scrollHeight);
    input_text.value = "";
    input_text.focus();
}

socket.onopen = function(e) {
    get_client();
}