    <main>
        <div id="chat_container__chats">
            <div class="chat_container__chats__element">
                <p>Daniel</p>
                <button>❌</button>
            </div>
            <div class="chat_container__chats__element">
                <p>Ana</p>
                <button>❌</button>
            </div>
            <div class="chat_container__chats__element">
                <p>Abel</p>
                <button>❌</button>
            </div>
        </div>
        <div id="chat_container__conversation">
            <div id="chat_container__conversation__header">
                <button> <img src="./resources/images/save.png">Save conversation</button>
                <p><img src="/resources/images/user.png">Daniel</p>
                <p id="dot"></p>

                <button><img src="/resources/images/close.png">Close</button>
            </div>
            <hr>
            <div id="chat_container__conversation__content">
            </div>
            <hr>
            <div id="chat_container__conversation__bottom">
                <form id = "input_form" autocomplete="off">
                    <input type="textarea" name="message" id="input_message" placeholder="Type a message...">
                    <input type="submit" id="send_message" value="send">
                </form>
            </div>
        </div>
    </main>
