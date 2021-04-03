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
    }

    sendMsg() {
        const sendMessage = `
            <div class="chat__content__me">
                <div class="chat__content__me__container">
                    <p>${this.input.value}</p>
                </div>
            </div>
        `
        this.content.insertAdjacentHTML('beforeend', sendMessage);
        this.content.scrollBy(0, this.content.scrollHeight);
        this.input.value = "";
        this.input.focus();
        setTimeout(this.strangerMsg.bind(this), 1000);
        return false;
    }

    strangerMsg() {
        const backMessage = `
            <div class="chat__content__stranger">
                <div class="chat__content__stranger__container">
                    <p>Asa este, aveti dreptate!</p>
                </div>
            </div>
        `
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
            <button class="chat__menubar_button" id="hide_button" onclick="chat.hideContent()">➖</button>
            <button class="chat__menubar_button" id="close_button" onclick="chat.closeCallback()">❌</button>
        </div>

        <div id="chat__content">
        </div>

        <div id="chat__inputbar">
            <form onsubmit="return chat.sendMsg()" autocomplete="off">
                <input type="textarea" name="message" id="input_message" placeholder="Type a message...">
                <input type="submit" id="send_message" value="send">
            </form>
        </div>
    </div>
`
document.head.insertAdjacentHTML('beforeend', '<link rel="stylesheet" type="text/css" href="https://catalyn45.github.io/ReSC/front_end/experimental/assets/css/style.css"/>');
document.body.insertAdjacentHTML("beforeend", htmlRaw);


var chat = new Chat();