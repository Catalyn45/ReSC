function sendMsg() {
    var inp = document.getElementById('input_message');
    cont.insertAdjacentHTML('beforeend', '<div class="chat__content__me"><div class="chat__content__me__container"><p>' + inp.value + '</p></div></div>');
    cont.scrollBy(0, 100);
    inp.value = "";
    inp.focus();
    return false;
}

var cont = document.getElementById('chat_cont');
cont.scrollBy(0, 1000);