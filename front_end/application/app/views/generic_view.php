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
        <img id="logo" src="/public/resources/images/banner.png" alt="logo">
        <p id="slogan"></p>
        <nav id="menu">
            <a href="/public/home"><img src="/public/resources/images/home.png" alt="home">Acasa</a>
            <a href="/public/register"><img src="/public/resources/images/register.png" alt="register">Register</a>
            <a href="/public/login"><img src="/public/resources/images/login.png" alt="login">Login</a>
        </nav>
    </header>

    <?php
    require_once __DIR__ . '/' . $data['view'] . '.php';
    ?>

    <footer>
        <ul>
            <li> ceva</li>
            <li>buna</li>
        </ul>
        <ul>
            <li>test1 aaaaa aaaa</li>
            <li>alceva</li>
        </ul>
        <ul>
            <li>cevaaa aaaaaa aaaaaaa aaaaaaa aaaaaaa aaaaaa aaaaaaaa aaa aaaa</li>
            <li>alceva</li>
        </ul>
    </footer>
    <script src="/public/js/sha.js"></script>
<?php
    if(isset($data['scripts'])) {
        foreach($data['scripts'] as $script_data) {
            echo '<script src="/public/js/' . $script_data . '.js"></script>';
        }
    }
?>
</body>

</html>