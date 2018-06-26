<?php
require '../db.php';
$user = R::load('users',$_POST['user']);
$comment = R::load('commentstoanswer',$_POST['comment']);
$comment->likes = $comment->likes + 1;
R::store($comment);
$likesArr = explode(',',$user->comments_likes);
$likesArr[count($likesArr)-1] = $_POST['comment'];
$likesArr[] = '';
$user->comments_likes = implode(',',$likesArr);
R::store($user);
?>