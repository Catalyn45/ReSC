function sendMsg() {
    const sendMessage = `
        <div class="chat__content__me">
            <div class="chat__content__me__container">
                <p>${input.value}</p>
            </div>
        </div>
    `
    content.insertAdjacentHTML('beforeend', sendMessage);
    content.scrollBy(0, content.scrollHeight);
    input.value = "";
    input.focus();
    setTimeout(strangerMsg, 1000);
    return false;
}

function strangerMsg() {
    const backMessage = `
        <div class="chat__content__stranger">
            <div class="chat__content__stranger__container">
                <p>Buna ziua, numele meu este Diana. cu ce va pot ajuta?</p>
            </div>
        </div>
    `
    content.insertAdjacentHTML('beforeend', backMessage);
    content.scrollBy(0, content.scrollHeight);
}

function hide() {
    if (isHidden) {
        content.style.display = 'block';
        inputbar.style.display = 'block';
        minimize.innerHTML = '➖';
    } else {
        content.style.display = 'none';
        inputbar.style.display = 'none';
        minimize.innerHTML = '🔳';
    }

    isHidden = !isHidden;
}

var script = `
    <div id="chat">
        <div id="chat__menubar">
            <button class="chat__menubar_button" id="hide_button" onclick="hide()">➖</button>
            <button class="chat__menubar_button" id="close_button" onclick="hide()">❌</button>
        </div>

        <div id="chat__content">
        </div>

        <div id="chat__inputbar">
            <form onsubmit="return sendMsg()" autocomplete="off">
                <input type="textarea" name="message" id="input_message" placeholder="Type a message...">
                <input type="submit" id="send_message" value="send">
            </form>
        </div>
    </div>
`;

var script_css = `
#chat {
    width: 20em;
    background-color: rgba(51, 43, 43);
    display: inline-block;
    position: fixed;
    right: 0;
    bottom: 0;
    margin-right: 1em;
    margin-bottom: 1em;
}


/*
Chat menu
*/

#chat__menubar {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    background-color: rgba(240, 107, 74);
}

.chat__menubar_button {
    padding: 1em 2em 1em;
    margin: 0;
    display: inline-block;
    background: none;
    border: none;
    outline: none;
    transition: background-color 1.3s linear;
}

.chat__menubar_button:hover {
    background-color: rgb(51, 49, 46);
    transition: background-color 1.3s linear;
}


/*
Chat content
*/

#chat__content {
    background-color: inherit;
    overflow-y: scroll;
    height: 24em;
}

#chat__content p {
	padding: 1em;
}

.chat__content__stranger {
    margin-top: 1em;
    margin-left: 1em;
    float: left;
}

.chat__content__me {
    margin-top: 1em;
    margin-right: 1em;
    float: right;
}

.chat__content__stranger__container {
    display: inline-block;
    width: 10em;
    background-color: rgb(228, 141, 141);
    border-radius: 5%;
    padding-right: 1em;
    padding-left: 1em;
}

.chat__content__me__container {
    background-color: rgb(115, 194, 247);
    display: inline-block;
    width: 10em;
    border-radius: 5%;
    padding-right: 1em;
    padding-left: 1em;
    overflow-wrap: break-word;
}


/*
Input bar from bellow
*/

#chat__inputbar {
    padding-top: 1em;
    padding-bottom: 1em;
    text-align: center;
    bottom: 0;
    right: 0;
    width: inherit;
}

#input_message {
    font-size: 1em;
    border: none;
    border-radius: 1%;
    box-sizing: border-box;
    width: 15em;
    height: 2.6em;
}

#send_message {
    box-sizing: border-box;
    border: none;
    border-radius: 10%;
    font-size: 1em;
    height: 2.6em;
    width: 3.5em;
}


/*
    Scroll atributes
*/

#chat__content::-webkit-scrollbar {
    width: 10px;
}

#chat__content::-webkit-scrollbar-track {
    background: rgb(51, 49, 46);
}

#chat__content::-webkit-scrollbar-thumb {
    background: #888;
}

#chat__content::-webkit-scrollbar-thumb:hover {
    background: #555;
}
`;

var styleSheet = document.createElement("style");
styleSheet.type = "text/css";
styleSheet.innerText = script_css;

document.head.appendChild(styleSheet);
document.body.insertAdjacentHTML("beforeend", script);

var isHidden = false;
var content = document.getElementById('chat__content');
var inputbar = document.getElementById('chat__inputbar');
var input = document.getElementById('input_message');
var minimize = document.getElementById('hide_button');

content.scrollBy(0, content.scrollHeight);