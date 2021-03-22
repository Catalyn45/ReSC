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
                <p>Asa este, aveti dreptate!</p>
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


var htmlRaw = `
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
`
document.head.insertAdjacentHTML('beforeend', '<link rel="stylesheet" type="text/css" href="https://catalyn45.github.io/ReSC/front_end/experimental/assets/css/style.css"/>');
document.body.insertAdjacentHTML("beforeend", htmlRaw);


var isHidden = false;
var content = document.getElementById('chat__content');
var inputbar = document.getElementById('chat__inputbar');
var input = document.getElementById('input_message');
var minimize = document.getElementById('hide_button');

content.scrollBy(0, content.scrollHeight);