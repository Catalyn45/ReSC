function sendMsg() {
    var inp = document.getElementById('input_message');
    cont.insertAdjacentHTML('beforeend', '<div class="chat__content__me"><div class="chat__content__me__container"><p>' + inp.value + '</p></div></div>');
    cont.scrollBy(0, 100);
    inp.value = "";
    inp.focus();
    setTimeout(strangerMsg, 1000);
    return false;
}

function strangerMsg() {
    cont.insertAdjacentHTML('beforeend', '<div class="chat__content__stranger"><div class="chat__content__stranger__container"><p>Asa este, aveti dreptate!</p></div></div>');
    cont.scrollBy(0, 100);
}

var cont = document.getElementById('chat_cont');
cont.scrollBy(0, 1000);