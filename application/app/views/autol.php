<?php
    echo 'document.head.insertAdjacentHTML("beforeend", `<link rel="stylesheet" type="text/css" href="https://localhost/autoloader_css?server_id=' . $_GET["server_id"] . '"/>`);';
?>

document.body.insertAdjacentHTML('beforeend', '<?php echo '<iframe id="chat_iframe" frameborder="0" src="https://localhost/iframe?server_id=' . $_GET['server_id'] . '" title="description"></iframe>'; ?>');