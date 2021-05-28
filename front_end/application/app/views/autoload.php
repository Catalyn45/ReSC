var chat = {};

class Chat {
    constructor(initialize = true) {
        if (initialize)
            this.init();
    }

    init() {
        this.isHidden = false;
        this.content = document.getElementById('chat__content');
        this.inputbar = document.getElementById('chat__inputbar');
        this.input = document.getElementById('input_message');
        this.minimize = document.getElementById('hide_button');
        this.chat = document.getElementById('chat');
        this.content.scrollBy(0, this.content.scrollHeight);

        this.socket = new WebSocket('wss://77.81.177.191/wss');
        let stranger_callback = this.strangerMsg.bind(this);
        let me_callback = this.sendMsg.bind(this);

        this.socket.onmessage = function(e) {
            let result = JSON.parse(e.data);
            if (result.response_type == "accepted") {
                document.getElementById("chat__form").addEventListener("submit", function(e) {
                    e.preventDefault();
                    me_callback();
                });
                stranger_callback(`<i>${result.name} s-a conectat. Puteti incepe conversatia </i>`);
            } else if (result.response_type != "success") {
                stranger_callback(result.message);
            }

            console.log(result);
        }

        this.socket.onopen = function(e) {
            let message = {
                method: "Connect",
                authority: "USER",
                token: "1234",
                server_id: 1,
                name: "paul"
            };

            this.send(JSON.stringify(message));
            stranger_callback("<i>Asteptati pana cand se conecteaza un administrator</i>");
        }
    }

    sendMsg() {
        const sendMessage = `
            <div class="chat__content__me">
                <p>${this.input.value}</p>
            </div>
        `;

        this.socket.send(JSON.stringify({
            method: "ClientMessage",
            authority: "USER",
            token: "1234",
            server_id: 1,
            message: this.input.value
        }));

        this.content.insertAdjacentHTML('beforeend', sendMessage);
        this.content.scrollBy(0, this.content.scrollHeight);
        this.input.value = "";
        this.input.focus();
    }

    strangerMsg(message) {
        const backMessage = `
            <div class="chat__content__stranger">
                <p>${message}</p>
            </div>
        `;
        this.content.insertAdjacentHTML('beforeend', backMessage);
        this.content.scrollBy(0, this.content.scrollHeight);
    }

    hideContent() {
        if (this.isHidden) {
            this.content.style.display = 'block';
            this.inputbar.style.display = 'block';
            this.minimize.innerHTML = '➖';
        } else {
            this.content.style.display = 'none';
            this.inputbar.style.display = 'none';
            this.minimize.innerHTML = '🔳';
        }

        this.isHidden = !this.isHidden;
    }

    hide() {
        this.chat.style.display = 'none';
    }

    show() {
        this.chat.style.display = 'inline-block';
    }

    closeCallback() {
        if (typeof onChatClose !== "undefined") {
            onChatClose();
        }
    }
}


var htmlRaw = `
<div id="chat">
        <div id="chat__menubar">
            <div id="chat__menubar__person">
                <p class="menubar__element" id="available"></p>
                <img class="menubar__element" src="https://catalyn45.github.io/ReSC/front_end/experimental/icons/diana.jpg" alt="Person" srcset="">
                <p class="menubar__element">Diana</p>
            </div>

            <div id="chat__menubar__buttons">
                <button id="hide_button" onclick="chat.hideContent()">➖</button>
                <button id="close_button" onclick="chat.closeCallback()">❌</button>
            </div>
        </div>

        <div id="chat__content">
        </div>

        <div id="chat__inputbar">
            <form id="chat__form" autocomplete="off">
                <input type="textarea" name="message" id="input_message" placeholder="Type a message...">
                <input type="submit" id="send_message" value="send">
            </form>
        </div>
    </div>
`
document.head.insertAdjacentHTML('beforeend', '<link rel="stylesheet" type="text/css" href="https://catalyn45.github.io/ReSC/front_end/experimental/assets/css/style.css"/>');
document.body.insertAdjacentHTML("beforeend", htmlRaw);


var chat = new Chat();