    #chat * {
        font-family: sans-serif;
    }
    /*
Chat
*/
    
    #chat {
        width: 20em;
        background-color: <?php echo '#' . $data->chatcolor_mid?>;
        display: none;
        position: fixed;
        <?php $vertical_pos="top";
        $vertical_value="0";
        if($data->chatposition_line==1) {
            $vertical_value="25%";
        }
        else if($data->chatposition_line > 1) {
            $vertical_pos="bottom";
        }
        $orisontal_pos="left";
        $orisontal_value="0";
        if($data->chatposition_column==1) {
            $orisontal_value="40%";
        }
        else if($data->chatposition_column > 1) {
            $orisontal_pos="right";
        }
        echo $vertical_pos . ' : ' . $vertical_value . ';';
        echo $orisontal_pos . ' : ' . $orisontal_value . ';';
        ?>margin-right: 1.5em;
        margin-bottom: 1em;
        border-radius: 5%;
        overflow: hidden;
    }
    /*
Chat menu
*/
    
    #chat__menubar {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        font-family: sans-serif;
        background-color: <?php echo '#' . $data->chatcolor_top?>;
    }
    
    #chat__menubar__person {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
    }
    
    #chat__menubar__person img {
        display: none;
        width: 2em;
        height: 2em;
        border-radius: 50%;
    }
    
    #chat__menubar__person p {
        color: white;
    }
    
    #chat__menubar__buttons {
        display: flex;
        flex-direction: row;
    }
    
    .menubar__element {
        padding: 0;
        margin: 0;
        margin-left: 0.7em;
    }
    
     :root {
        --color: red;
    }
    
    #available:before {
        content: "\2022";
        font-size: 2em;
        color: var(--color);
    }
    
    #chat__menubar__buttons button {
        padding: 1em 2em 1em;
        margin: 0;
        display: inline-block;
        background: none;
        border: none;
        outline: none;
        transition: background-color 1.3s linear;
    }
    
    #chat__menubar__buttons button:hover {
        background-color: rgb(232, 236, 164);
        transition: background-color 1.3s linear;
    }
    
    #chat__menubar__buttons button p {
        padding: 0;
        margin: 0;
    }
    /*
Chat content
*/
    
    #chat__content {
        background-color: inherit;
        overflow-y: scroll;
        height: 22em;
        display: flex;
        flex-direction: column;
    }
    
    .chat__content__stranger {
        align-self: flex-start;
        background-color: <?php echo '#' . $data->chatcolor_stranger?>;
        display: inline-block;
        width: 10em;
        border-radius: 5%;
        padding: 1em;
        overflow-wrap: break-word;
        margin-top: 1em;
        margin-left: 1em;
    }
    
    .chat__content__me {
        align-self: flex-end;
        background-color: <?php echo '#' . $data->chatcolor_client?>;
        display: inline-block;
        width: 10em;
        border-radius: 5%;
        padding: 1em;
        overflow-wrap: break-word;
        margin-top: 1em;
        margin-right: 1em;
    }
    /*
Input bar from bellow
*/
    
    #chat__inputbar {
        padding-top: 1em;
        padding-bottom: 1em;
        text-align: center;
        bottom: 0;
        right: 0;
        width: inherit;
    }
    
    #input_message {
        font-size: 1em;
        border: none;
        border-radius: 1%;
        box-sizing: border-box;
        width: 15em;
        height: 2.6em;
        padding-left: 1em;
        background-color: <?php echo '#' . $data->chatcolor_input?>;
        color: black;
    }
    
    #send_message {
        color: black;
        box-sizing: border-box;
        border: none;
        border-radius: 40%;
        font-size: 1em;
        height: 2.6em;
        width: 3.5em;
        font-weight: bold;
        background-color: <?php echo '#' . $data->chatcolor_button?>;
    }
    /*
    Scroll atributes
*/
    
    #chat__content::-webkit-scrollbar {
        width: 10px;
    }
    
    #chat__content::-webkit-scrollbar-track {
        background: rgb(204, 200, 193);
    }
    
    #chat__content::-webkit-scrollbar-thumb {
        background: #888;
    }
    
    #chat__content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .emoji {
        width: 20px;
        height: 20px;
    }