<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <?php echo '<link rel="stylesheet" type="text/css" href="https://localhost/chatloadercss?server_id=' . $_GET["server_id"] . '"/>';?>

</head>
<body>
<div id="chat">
        <div id="chat__menubar">
            <div id="chat__menubar__person">
                <p class="menubar__element" id="available"></p>
                <img class="menubar__element" alt="Person" srcset="" id="admin_photo">
                <p class="menubar__element" id="admin_name"></p>
            </div>

            <div id="chat__menubar__buttons">
                <button id="hide_button" onclick="chat.hideContent()">➖</button>
                <button id="close_button" onclick="chat.closeCallback()">❌</button>
            </div>
        </div>

        <div id="chat__content">
        <input id="add_name" type="text">
        <button id="button_add" onclick="addName()">OK
        </button>
        </div>

        <div id="chat__inputbar">
            <form id="chat__form" autocomplete="off">
                <input type="textarea" name="message" id="input_message" placeholder="Type a message...">
                <input type="submit" id="send_message" value="send">
            </form>
        </div>
    </div>
    <?php echo '<script src="https://localhost/chatloader?server_id=' . $_GET["server_id"] . '"></script>';?> 
</body>
</html>