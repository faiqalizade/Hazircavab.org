<?php
require '../db.php';
$query = get_magic_quotes_gpc() ?
    stripslashes($_POST) : $_POST;
    $table = $query['table'];
    $id = $query['loadid'];
    $content = R::load($table,$id);
echo json_encode($content);
?>