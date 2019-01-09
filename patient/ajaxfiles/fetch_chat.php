<?php
require_once "../../includes/chat.php";

echo  Chat::fetch_chat_history($_POST['from_user_id'],$_POST['to_user_id']);
?>