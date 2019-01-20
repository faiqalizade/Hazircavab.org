<?php
date_default_timezone_set('Asia/Baku');
require '../db.php';
$user = R::load('users',$_POST['user']);
$comment = R::load('commentstoanswer',$_POST['comment']);
$comment->likes = $comment->likes + 1;
$likesArr = explode(',',$user->comments_likes);
$is_liked = in_array($_POST['comment'],$user->comments_likes);
if(!$is_liked){
    $likesArr[count($likesArr)-1] = $_POST['comment'];
    $likesArr[] = '';
    $user->comments_likes = implode(',',$likesArr);
    if($comment->user != $user->login){
        $answer = R::load('answers',$comment->answer_id);
        $add_notif = R::dispense('notifications');
        $add_notif->from_id = $user->id;
        $add_notif->from_login = $user->login;
        $add_notif->to = $comment->user;
        $add_notif->type = 4;
        $add_notif->where = 'index.php?page=question&question='.$answer->question_id;
        $add_notif->viewed = 0;
        $add_notif->date = date('d.m.Y');
        $add_notif->time = date('H:i:s');
        R::store($add_notif);
    }
    R::store($user);
    R::store($comment);
}
?>