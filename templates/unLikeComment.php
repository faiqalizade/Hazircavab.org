<?php
require '../db.php';
$comment = R::load('commentstoanswer',$_POST['comment']);
$comment->likes = $comment->likes - 1;
R::store($comment);
$user = R::load('users',$_POST['user']);
$likesArr = explode(',',$user->comments_likes);
$removed = true;
$newLikesArr = [];
foreach ($likesArr as $like) {
    if($like != $_POST['comment']){
            $newLikesArr[] = $like;
    }
}
$user->comments_likes = implode(',',$newLikesArr);
R::store($user);
?>