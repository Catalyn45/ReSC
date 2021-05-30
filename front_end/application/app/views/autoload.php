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
    return processed.replaceAll(/(^| ):([a-z]+):( |$)/g, '$1<img class="emoji" src="/resources/emojis/$2.png" onerror="this.src=\'resources/emojis/fire.png\'">$3');
}

class Chat {
    constructor() {
        this.isHidden = false;
        this.content = document.getElementById('chat__content');
        this.inputbar = document.getElementById('chat__inputbar');
        this.input = document.getElementById('input_message');
        this.minimize = document.getElementById('hide_button');
        this.sendMessage = document.getElementById("send_message");
        this.chat = document.getElementById('chat');
        this.adminPhoto = document.getElementById("admin_photo");
        this.available = document.getElementById("available");
        this.adminName = document.getElementById("admin_name");
        this.input.disabled = true;
        this.sendMessage.disabled = true;

        this.content.scrollBy(0, this.content.scrollHeight);
        this.socket = null;
        this.token = null;
        this.serverId = null;
        this.name = null;
        this.onChatClose = null;
    }

    setToken(token) {
        this.token = token;
    }

    setServerId(serverId) {
        this.serverId = serverId;
    }

    setName(name) {
        this.name = name;
    }

    setConfigs(token, serverId, name) {
        this.token = token;
        this.serverId = serverId;
        this.name = name;
    }

    startConnection() {
        let stranger_callback = this.strangerMsg.bind(this);
        var me_callback = this.sendMsg.bind(this);

        // here needs to be the actual host url
        this.socket = new WebSocket(`wss://${window.location.host}/wss`);
        this.socket.onmessage = function(e) {
            let result = JSON.parse(e.data);
            if (result.response_type == "accepted") {
                document.getElementById("chat__form").addEventListener("submit", function(e) {
                    e.preventDefault();
                    me_callback();
                });
                this.input.disabled = false;
                this.sendMessage.disabled = false;
                this.adminName.innerHTML = result.name;
                this.adminPhoto.src = result.photo;
                this.adminPhoto.style.display = "inline";
                this.available.style.setProperty('--color', "green");
                stranger_callback(`<i>${result.name} s-a conectat. Puteti incepe conversatia </i>`);
            } else if (result.response_type != "success") {
                stranger_callback(result.message);
            }

            console.log(result);
        }.bind(this);

        this.socket.onopen = function(e) {
            let message = {
                method: "Connect",
                authority: "USER",
                token: this.token,
                server_id: this.serverId,
                name: this.name
            };

            console.log(message);

            this.socket.send(JSON.stringify(message));
            stranger_callback("Asteptati pana cand se conecteaza un administrator :danger:");
        }.bind(this);

        this.socket.onclose = function(e) {
            document.getElementById("available").style.setProperty('--color', "red");
            this.socket = null;
        }
    }

    stopConnection() {
        this.socket.close();
        this.socket = null;
    }

    sendMsg() {
        if (this.input.value == "")
            return;

        const sendMessage = `
            <div class="chat__content__me">
                <p>${process_text(this.input.value)}</p>
            </div>
        `;

        this.socket.send(JSON.stringify({
            method: "ClientMessage",
            authority: "USER",
            token: "1234",
            server_id: this.serverId,
            message: this.input.value
        }));

        this.content.insertAdjacentHTML('beforeend', sendMessage);
        this.content.scrollBy(0, this.content.scrollHeight);
        this.input.value = "";
        this.input.focus();
    }

    strangerMsg(message) {
        message = process_text(message);
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
            this.content.style.display = 'flex';
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
        this.content.innerHTML = "";
        this.input.disabled = true;
        this.sendMessage.disabled = true;
        this.adminName.innerHTML = "";
        this.adminPhoto.style.display = "none";
        if (this.onChatClose != null) {
            this.onChatClose();
        }
    }
}

var htmlRaw = `
<div id="chat">
        <div id="chat__menubar">
            <div id="chat__menubar__person">
                <p class="menubar__element" id="available"></p>
                <img class="menubar__element" alt="Person" srcset="" id="admin_photo">
                <p class="menubar__element" id="admin_name"></p>
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
`;
<?php
    echo 'document.head.insertAdjacentHTML("beforeend", \'<link rel="stylesheet" type="text/css" href="/chatloadercss?server_id=' . $_GET["server_id"] . '"/>\');';
?>

document.body.insertAdjacentHTML("beforeend", htmlRaw);

<?php
    echo 'var '. $data->object_name . '= new ' . $data->class_name . '();';
?>