<<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
     <?php

    if(isset($data['css'])) {
        foreach($data['css'] as $css_data) {
            echo '<link rel="stylesheet" href="/public/css/' . $css_data . '.css" type="text/css" >';
        }
    }

    ?>
</head>

<body>
    <header>
        <img id="logo" src="./resources/images/banner.png" alt="logo">
        <p id="slogan"></p>
        <nav id="menu">
            <a href="/public/chat"><img src="/public/resources/images/chat.png" alt="chat">Chat</a>
            <a href="/public/settings"><img src="/public/resources/images/settings.png" alt="Settings">Settings</a>
            <a id="logout" href=""><img src="/public/resources/images/logout.png" alt="logout">Logout</a>
        </nav>
        </header>
    <?php
    require_once __DIR__ . '/' . $data['view'] . '.php';
    echo '<script src="/public/js/logout.js"></script>';
    if(isset($data['scripts'])) {
        foreach($data['scripts'] as $script_data) {
            echo '<script src="/public/js/' . $script_data . '.js"></script>';
        }
    }
    ?>

</body>
</html>
