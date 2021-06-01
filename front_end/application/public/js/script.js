var names = [
    "ana",
    "adrian",
    "bogdana",
    "maria",
    "elena",
    "anastasia",
    "corina",
    "paul",
    "alberto",
    "sorin",
    "adrian",
    "marian",
    "alex",
    "eusebiu",
    "stefan",
    "stefania"
];

var nume = names[Math.round(Math.random() * 100) % names.length];

chat.setName(nume);

let isShowing = false;

function load_chat() {
    if (!isShowing) {
        document.getElementById("try_demo").style.display = 'none';
        isShowing = true;
    }
}

chat.onChatClose = function() {
    document.getElementById("try_demo").style.display = 'inline-block';
    this.stopConnection();
    this.hide();
    isShowing = false;
}