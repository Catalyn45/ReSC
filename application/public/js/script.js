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

chat.stopConnection();
chat.hide();

var nume = names[Math.round(Math.random() * 100) % names.length];

chat.setName(nume);

function load_chat() {
    document.getElementById("try_demo").style.display = 'none';
    chat.show();
    chat.startConnection();
}

chat.onChatClose = function() {
    document.getElementById("try_demo").style.display = 'inline-block';
    this.stopConnection();
    this.hide();
}