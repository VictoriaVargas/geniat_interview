<?php
    require_once '../classes/token.class.php';
    $_token = new token;
    $date = date('Y-m-d H:i');
    echo $_token->updateTokens($date);
?>