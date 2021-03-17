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

//3152_insert_here

var isHidden = false;
var content = document.getElementById('chat__content');
var inputbar = document.getElementById('chat__inputbar');
var input = document.getElementById('input_message');
var minimize = document.getElementById('hide_button');

content.scrollBy(0, content.scrollHeight);