<?php
require '../db.php';
$query = get_magic_quotes_gpc() ?
    stripslashes($_POST) : $_POST;
$leftLimit = ($query['page'] - 1) * $query['limit'];
$rightLimit = $query['page'] * $query['limit'];
$table = $query['table'];
if(!empty($query['order'])){
    $order = $query['order'];
    $content = R::find($table, " ORDER $order LIMIT $leftLimit,$rightLimit");
}else{
    $content = R::find($table, " LIMIT $leftLimit,$rightLimit");
}
echo json_encode($content);