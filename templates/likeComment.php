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
        $add_notif->to_user_id = $comment->userid;
        $add_notif->type = 4;
        $add_notif->where = 'index.php?page=question&question='.$answer->question_id;
        $add_notif->whereid = $answer->question_id;
        $add_notif->viewed = 0;
        $add_notif->date = date('Y-m-d');
        $add_notif->time = date('H:i:s');
        R::store($add_notif);
        $load_like_comment_to_answer_user = R::load('users',$comment->comment_userid);
        $to = $load_like_comment_to_answer_user->mail;
        $headers = "From: noreply@hazircavab.org\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = '<html><body>';
        if($load_like_comment_to_answer_user->lang == 'az'){
            $subject = "Serhiniz beyenildi";
            $message .= '<h1>Salam Dostum!</h1>';
            $message .= "<p> @$user->login serhinizi beyendi </p>";
            $message .= "<p> Baxmaq ucun bu <a href='index.php?page=question&question=$answer->question_id' > linke </a> daxil olun </p>";
            $message .= "<p>Uğurlar Dostum</p>";
            $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
        }else{
            $subject = "Понравился комментарий";
            $message .= '<h1>Здравствуй друг(подруга)!</h1>';
            $message .= "<p> @$user->login понравился ваш комментарий к ответу </p>";
            $message .= "<p> Чтобы посмотреть перейдите по этой <a href='index.php?page=question&question=$answer->question_id' >ссылке</a></p>";
            $message .= "<p>Удачи друг(подруга)</p>";
            $message .= "<p>С уважением HAZIRCAVAB!</p>";
        }
        $message .= '</body></html>';
        mail($to,$subject,$message,$headers);
    }
    R::store($user);
    R::store($comment);
}
?>