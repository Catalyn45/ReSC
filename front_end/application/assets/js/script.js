function onChatClose() {
    chat.hide();
    document.getElementById("try_demo").style.display = 'inline-block';
}

var loaded = false;

function load_chat() {

    if (loaded) {
        chat.show();
        return;
    }

    document.getElementById("try_demo").style.display = 'none';
    let script = document.createElement("script");
    //var htmlRaw = 'https://catalyn45.github.io/ReSC/front_end/experimental/assets/js/autoload.js';
    htmlRaw = '../../../experimental/assets/js/autoload.js'
    script.src = htmlRaw;
    document.body.appendChild(script);
    loaded = true;
}