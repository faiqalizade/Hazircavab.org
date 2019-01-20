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
$answer = R::load('answers',$_POST['answer']);
$user = R::findOne('users','WHERE login = ?',[$_POST['user']]);
if($answer->user != $_POST['user']){
    $add_notif = R::dispense('notifications');
    $add_notif->from_id = $user->id;
    $add_notif->from_login = $_POST['user'];
    $add_notif->to = $answer->user;
    $add_notif->type = 3;
    $add_notif->where = 'index.php?page=question&question='.$answer->question_id;
    $add_notif->viewed = 0;
    $add_notif->date = date('d.m.Y');
    $add_notif->time = date('H:i:s');
    R::store($add_notif);
}
if(!empty($_POST['replyto'])){
    if($_POST['user'] != $_POST['replyto']){
        $add_notif = R::dispense('notifications');
        $add_notif->from_id = $user->id;
        $add_notif->from_login = $_POST['user'];
        $add_notif->to = $_POST['replyto'];
        $add_notif->type = 5;
        $add_notif->where = 'index.php?page=question&question='.$answer->question_id;
        $add_notif->viewed = 0;
        $add_notif->date = date('d.m.Y');
        $add_notif->time = date('H:i:s');
        R::store($add_notif); 
    }
}
$id = R::store($addComment);
echo $id;
?>