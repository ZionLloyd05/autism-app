<?php
    require_once "../../includes/chat.php";

    $chat = new Chat();

    $chat->to_user_id = $_POST['to_user_id'];
    $chat->from_user_id = $_POST['from_user_id'];
    $chat->chat_message = $_POST['chat_message'];

    if($chat->save()){
        echo $chat->fetch_chat_history($_POST['from_user_id'], $_POST['to_user_id']);
    }

?>