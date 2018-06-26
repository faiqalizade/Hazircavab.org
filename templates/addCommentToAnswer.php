<?php
date_default_timezone_set('Asia/Baku');
require '../db.php';
$addComment = R::dispense('commentstoanswer');
$addComment->answer_id = $_POST['answer'];
$addComment->user = $_POST['user'];
$addComment->content = $_POST['comment'];
$addComment->date = date('d.m.Y');
$addComment->time = date('H:i:s');
$addComment->likes = 0;
$id = R::store($addComment);
echo $id;
?>