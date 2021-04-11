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
                <p>${this.input.value}</p>
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
                <p>Asa este, aveti dreptate!</p>
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

//3152_insert_here

var chat = new Chat();