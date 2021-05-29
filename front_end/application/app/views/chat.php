    <main>
        <div id="chat_container__chats">
            <button id ="getclient" class="chat_container__chats__element" onclick="get_client()">
                <p>Get client</p>
            </button>
        </div>
        <div id="chat_container__conversation">
            <div id="chat_container__conversation__header">
                <button> <img src="./resources/images/save.png">Save conversation</button>
                <p id="client_name"><img src="/resources/images/user.png">nume</p>
                <p id="dot"></p>
                <button onclick="close_client()"><img src="/resources/images/close.png">Close</button>
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
