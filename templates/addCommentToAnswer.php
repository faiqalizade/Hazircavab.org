<?php
date_default_timezone_set('Asia/Baku');
require '../db.php';
$answer = R::load('answers',$_POST['answer']);
$addComment = R::dispense('commentstoanswer');
$addComment->answer_id = $_POST['answer'];
$addComment->user = $_POST['user'];
$addComment->comment_userid = $answer->userid;
$addComment->content = $_POST['comment'];
$addComment->date = date('Y-m-d');
$addComment->time = date('H:i:s');
$addComment->likes = 0;
$user = R::findOne('users','WHERE login = ?',[$_POST['user']]);
if($answer->user != $_POST['user']){
    $add_notif = R::dispense('notifications');
    $add_notif->from_id = $user->id;
    $add_notif->from_login = $_POST['user'];
    $add_notif->to = $answer->user;
    $add_notif->to_user_id = $answer->userid;
    $add_notif->type = 3;
    $add_notif->where = 'index.php?page=question&question='.$answer->question_id;
    $add_notif->whereid = $answer->question_id;
    $add_notif->viewed = 0;
    $add_notif->date = date('Y-m-d');
    $add_notif->time = date('H:i:s');
    R::store($add_notif);
    $load_add_comment_answer_user = R::load('users',$answer->userid);
    $to = $answer->usermail;
    $headers = "From: noreply@hazircavab.org\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message = '<html><body>';
    if($load_add_comment_answer_user->lang == 'az'){
        $subject = "Cavabiniza serh elave edildi";
        $message .= '<h1>Salam Dostum!</h1>';
        $message .= "<p> @".$_POST['user']." cavabiniza serh yazdi</p>";
        $message .= "<p> Baxmaq ucun bu <a href='index.php?page=question&question=$answer->question_id' > linke </a> daxil olun </p>";
        $message .= "<p>Uğurlar Dostum</p>";
        $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
    }else{
        $subject = "Добавлен комментарий к ответу";
        $message .= '<h1>Здравствуй друг(подруга)!</h1>';
        $message .= "<p> @".$_POST['user']." прокомментировал ваш ответ</p>";
        $message .= "<p> Чтобы посмотреть перейдите по этой <a href='index.php?page=question&question=$answer->question_id' >ссылке</a></p>";
        $message .= "<p>Удачи друг(подруга)</p>";
        $message .= "<p>С уважением HAZIRCAVAB!</p>";
    }
    $message .= '</body></html>';
    mail($to,$subject,$message,$headers);
}
if(!empty($_POST['replyto'])){
    if($_POST['user'] != $_POST['replyto']){
        $add_notif = R::dispense('notifications');
        $add_notif->from_id = $user->id;
        $add_notif->from_login = $_POST['user'];
        $add_notif->to = $_POST['replyto'];
        $add_notif->to_user_id = $_POST['user_id'];
        $add_notif->type = 5;
        $add_notif->where = 'index.php?page=question&question='.$answer->question_id;
        $add_notif->whereid = $answer->question_id;
        $add_notif->viewed = 0;
        $add_notif->date = date('Y-m-d');
        $add_notif->time = date('H:i:s');
        R::store($add_notif); 
        $load_reply_comment_to_user = R::load('users',$_POST['user_id']);
        $to = $load_reply_comment_to_user->mail;
        $headers = "From: noreply@hazircavab.org\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = '<html><body>';
        if($load_reply_comment_to_user->lang == 'az'){
            $subject = "Cavabiniza serh elave edildi";
            $message .= '<h1>Salam Dostum!</h1>';
            $message .= "<p> @".$_POST['user']." cavabiniza serh yazdi</p>";
            $message .= "<p> Baxmaq ucun bu <a href='index.php?page=question&question=$answer->question_id' > linke </a> daxil olun </p>";
            $message .= "<p>Uğurlar Dostum</p>";
            $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
        }else{
            $subject = "Добавлен комментарий к ответу";
            $message .= '<h1>Здравствуй друг(подруга)!</h1>';
            $message .= "<p> @".$_POST['user']." прокомментировал ваш ответ</p>";
            $message .= "<p> Чтобы посмотреть перейдите по этой <a href='index.php?page=question&question=$answer->question_id' >ссылке</a></p>";
            $message .= "<p>Удачи друг(подруга)</p>";
            $message .= "<p>С уважением HAZIRCAVAB!</p>";
        }
        $message .= '</body></html>';
        mail($to,$subject,$message,$headers);
    }
}
$id = R::store($addComment);
echo $id;
?>