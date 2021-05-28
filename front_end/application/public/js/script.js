function onChatClose() {
    chat.hide();
    document.getElementById("try_demo").style.display = 'inline-block';
}

var loaded = false;

var start_chat = null;

function load_chat() {

    if (loaded) {
        if (start_chat != null)
            start_chat();

        chat.show();
        return;
    }

    document.getElementById("try_demo").style.display = 'none';
    let script = document.createElement("script");
    var htmlRaw = '/chatloader';
    script.src = htmlRaw;
    document.body.appendChild(script);
    loaded = true;
}