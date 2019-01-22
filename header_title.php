<?php
// Notif types: 
// 0 = add answer to question
// 1 = like answer to question
// 2 = check answer to question
// 3 = add comment to answer
// 4 = like comment to answer
// 5 = reply to comment answer
# =============== VARS ==============
$page = $_GET['page'];
$blog_id = $_GET['blog'];
$opened_user_profile = $_GET['user'];
$tag = $_GET['tag'];
$profile = $_GET['profile'];
$opened_question = $_GET['question'];
$accaunt = $_GET['password'];
$activate_accaunt = $_GET['activate_code'];
$like_answer = $_GET['like'];
$unlike_answer = $_GET['unlike'];
$check_answer = $_GET['check'];
$uncheck_answer = $_GET['uncheck'];
$remove_answer = $_GET['remove_answer'];
$list_page_number = $_GET['pn'];
$query = $_GET['q'];
# =============== ENDVARS ==============
date_default_timezone_set('Asia/Baku');
if(isset($_COOKIE['language'])){
    if($_COOKIE['language'] != 'az' && $_COOKIE['language'] != 'ru'){
        setcookie('language','ru',time() + 1009152000,'/');
        $defLang = 'ru';
    }
    if($cookie_checked && $user_infos->lang != $_COOKIE['language']){
        $check_cookie->lang = $_COOKIE['language'];
        R::store($check_cookie);
    }
}elseif($cookie_checked){
    if($user_infos->lang != 'az'){
        setcookie('language','ru',time() + 1009152000,'/');
        $defLang = 'ru';
    }else{
        setcookie('language','az',time() + 1009152000,'/');
        $defLang = 'az';
    }
}else{
    setcookie('language','ru',time() + 1009152000,'/');
    $defLang = 'ru';
}
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if($page == 'activation'){
    if(isset($activate_accaunt) && strlen($activate_accaunt) >= 20){
        $activation_accaunt_find = R::findOne('users','verifed = ?',[$activate_accaunt]);
        if(empty($activation_accaunt_find)){
            $error = 'Этот код уже не действителен';
        }else{
            $accaunt_activated = R::load('users',$activation_accaunt_find->id);
            $accaunt_activated->verifed = 1;
            R::store($accaunt_activated);
            $success = 'Аккаунт успешно подтверждена';
        }
    }else{
        header('Location: index.php');
        exit();
    }
}
if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_hash'])){
    $check_cookie = R::load('users', $_COOKIE['user_id']);
    if ($check_cookie->user_hash != $_COOKIE['user_hash']) {
        setcookie('user_id','', time() - 3600,'/');
        setcookie('user_hash','', time() - 3600,'/');
        $cookie_checked = false;
    }else{
        $cookie_checked = true;
        $user_infos = $check_cookie;
    }
}else{
    setcookie('user_hash','', time() - 3600,'/');
    setcookie('user_id','', time() - 3600,'/');
    $cookie_checked = false;
}
if ($page == 'registr') {
    if (isset($_POST['registr_page_submit'])) {
        $searchmail = R::findOne('users','mail = ?',[$_POST['reg_mail']]);
        $searchlogin = R::findOne('users','login = ?',[$_POST['reg_login']]);
        if (empty($searchmail)) {
            if (empty($searchlogin)) {
                if(strlen($_POST['reg_password']) >= 8){
                    $verifed_login = true;
                    for ($i=0; $i < strlen(htmlspecialchars(trim($_POST['reg_login']))); $i++) { 
                        if($_POST['reg_login'][$i] == ' '){
                            $verifed_login = false;
                            break;
                        }
                    }
                    if($verifed_login){
                        if ($_POST['reg_password'] == $_POST['reg_verification_password']) {
                            $registry_verification = generateRandomString(20);
                            $registry = R::dispense('users');
                            $registry->name = htmlspecialchars($_POST['reg_name']);
                            $registry->surname = htmlspecialchars($_POST['reg_lastName']);
                            $registry->login = htmlspecialchars(trim($_POST['reg_login']));
                            $registry->password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
                            $registry->mail = htmlspecialchars($_POST['reg_mail']);
                            $registry->lang = $_COOKIE['language'];
                            $registry->answer_likes = ',';
                            $registry->comments_likes = ',';
                            $registry->small_desc = '';
                            $registry->desc = '';
                            $registry->questions = 0;
                            $registry->answers = 0;
                            $registry->checked_answers = 0;
                            $registry->subscribe_tag = ',';
                            $registry->verifed = $registry_verification;
                            $registry->status = 0;
                            $registry->user_hash;
                            R::store($registry);
                            mkdir('usersfiles/'.htmlspecialchars($_POST['reg_login']));
                            mkdir('usersfiles/'.htmlspecialchars($_POST['reg_login']).'/images');
                            copy('profil images/14.png','usersfiles/'.htmlspecialchars($_POST['reg_login']).'/profil.png');
                            $to = $_POST['reg_mail'];
                            $subject = 'E-mail adresin təsdiqlənməsi';
                            $headers = "From: noreply@hazircavab.org\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            $message = '<html><body>';
                            $message .= '<h1>Salam Dostum!</h1>';
                            $message .= "<p>Əziz ".$_POST['reg_name'].", təbriklər sən Hazırcavab.org saytından qeydiyyatdan keçdin. Son bir etap qaldı, <a href='faiqaliza3.tmweb.ru/index.php?page=activation&activate_code=".$registry_verification."'>buraya keçib</a> e-mail adresi təsdiqlə!"."</p>";
                            $message .= "<p>Uğurlar Dostum</p>";
                            $message .= "<p>Hörmətlə HAZIRCAVAB!</p>";
                            $message .= '</body></html>';
                            mail($to,$subject,$message,$headers);
                            # Buarada Maile mektub atmag lazimdi
                        }else {
                            $error = 'Пароли не совпадают';
                        }
                    }else {
                        $error = 'Пробел в логине не допустим';
                    }
                }else{
                    $error = 'Пароль не должна быть менее 8 символов';
                }
            }else {
                $error = 'Аккаунт с такой логином существует';
            }
        }else{
            $error = 'Аккаунт с такой почтой существует';
        }
    }
}elseif ($page == 'login') {
    if (isset($_POST['login_page_submit'])) {
        $searchlogin = R::findOne('users','login = ?',[$_POST['login']]);
        if (!empty($searchlogin)) {
            if (password_verify($_POST['password'],$searchlogin->password)) {
                $user_hash = generateRandomString(15);
                setcookie('user_id',$searchlogin->id,time() + 86400*365,'/');
                setcookie('user_hash',$user_hash,time() + 86400*365,'/');
                $user_sign = R::load('users',$searchlogin->id);
                $user_sign->user_hash = $user_hash;
                R::store($user_sign);
                header('Location:index.php');
                exit();
            }else {
                $error = 'Неправильно введен логин или пароль';
            }
        }else{
            $error = 'Неправильно введен логин или пароль';
        }
    }
}
if($page == 'myprofile'){
    if(isset($profile)){
        if($cookie_checked){
            if(!empty($_POST['my_profil_selected_img_number'])){
                copy('profil images/'.$_POST['my_profil_selected_img_number'].'.png','usersfiles/'.$user_infos->login.'/profil.png');
        }else{
            copy($_FILES['my_profil_own_image']['tmp_name'],'usersfiles/'.$user_infos->login.'/profil.png');
        }
        if(isset($_POST['my_profile_info_change_submit'])){
            $profil_info_change = R::load('users', $_COOKIE['user_id']);
            $profil_info_change->name = htmlspecialchars($_POST['my_profil_change_name']);
            $profil_info_change->surname = htmlspecialchars($_POST['my_profil_change_surname']);
            $profil_info_change->small_desc = htmlspecialchars($_POST['my_profil_change_small_desc']);
            $profil_info_change->desc = htmlspecialchars($_POST['my_profil_change_desc']);
            if($profil_info_change->verifed != 1){
                $change_mail_verification = generateRandomString(20);
                $profil_info_change->verifed = $change_mail_verification;
                # Buarada Maile mektub atmag lazimdi
            }
            R::store($profil_info_change);
            header("Refresh:0");
            exit();
        }
        }
    }elseif (isset($accaunt)) {
        if ($cookie_checked) {
            if (isset($_POST['my_profile_pass_change_submit'])) {
                $profil_pass_change = R::load('users', $_COOKIE['user_id']);
                if(password_verify($_POST['my_profil_change_pass_old'],$profil_pass_change->password)){
                    if($_POST['my_profil_change_pass_new'] == $_POST['my_profil_change_pass_again_new']){
                        $profil_pass_change->password = $registry->password = password_hash($_POST['my_profil_change_pass_new'], PASSWORD_DEFAULT);
                        $succes = 'Пароль успешно изменен';
                        R::store($profil_pass_change);
                        # Buarada Maile mektub atmag lazimdi
                    }else{
                        $error = 'Пароли не совпадают';
                    }
                }else{
                    $error = 'Неправильно введен старый пароль';
                }
            }
        }
    }
}

if($page == 'addquestion'){
    if($cookie_checked){
        if(isset($_POST['add_question_title'])){
            $add_question = R::dispense('questions');
            $add_question->title = htmlspecialchars($_POST['add_question_title']);
            $add_question->tags = htmlspecialchars($_POST['add_question_tags']);
            $add_question->content = $_POST['HCeditorContent'];
            $add_question->user = $user_infos->login;
            $add_question->views = 0;
            $add_question->answers = 0;
            $add_question->check_answer = ',';
            $add_question->subscribe_tag = ',';
            $add_question->date = date('d.m.Y');
            $add_question->time = date('H:i:s');
            R::store($add_question);
            $add_question_count_user = R::load('users',$user_infos->id);
            $add_question_count_user->questions = $add_question_count_user->questions + 1;
            R::store($add_question_count_user);
            $add_tag_questions_number_array = explode(',',$_POST['add_question_tags']);
            foreach ($add_tag_questions_number_array as $find_tag) {
                $find_tag_to_add = R::findOne('tags','name_ru = ?',[$find_tag]);
                $add_question_numbers = R::dispense('tags');
                $add_question_numbers->id = $find_tag_to_add->id;
                $add_question_numbers->questions = $find_tag_to_add->questions + 1;
                R::store($add_question_numbers);
            }
            $to_location_question = R::find('questions');
            header('Location: index.php?page=question&question='.end($to_location_question)->id);
            exit();
        }
    }
}

if($page == 'edit_question'){
    if ($cookie_checked) {
        if(isset($_POST['add_question_title'])){
            $load_question_edit = R::load('questions',$opened_question);
            if($load_question_edit->user == $user_infos->login || $user_infos->status == 9){
                if(!empty($load_question_edit)){
                    $load_question_edit->title = htmlspecialchars($_POST['add_question_title']);
                    $old_tag_list_arr = explode(',',$load_question_edit->tags);
                    foreach ($old_tag_list_arr as $tag) {
                        $find_tag_to_minus = R::findOne('tags','name_ru = ?',[$tag]);
                        $minus_question_numbers = R::dispense('tags');
                        $minus_question_numbers->id = $find_tag_to_minus->id;
                        $minus_question_numbers->questions = $find_tag_to_minus->questions - 1;
                        R::store($minus_question_numbers);
                    }
                    $load_question_edit->tags = htmlspecialchars($_POST['add_question_tags']);
                    $change_tag_questions_number_array = explode(',',$_POST['add_question_tags']);
                    foreach ($change_tag_questions_number_array as $find_tag) {
                        $find_tag_to_add = R::findOne('tags','name_ru = ?',[$find_tag]);
                        $change_question_numbers = R::dispense('tags');
                        $change_question_numbers->id = $find_tag_to_add->id;
                        $change_question_numbers->questions = $find_tag_to_add->questions + 1;
                        R::store($change_question_numbers);
                    }
                    $load_question_edit->content = $_POST['HCeditorContent'];
                    R::store($load_question_edit);
                    header('Location: index.php?page=question&question='.$opened_question);
                    exit();
                }
            }
        }
    }
}
if($page == 'remove_question'){
    if($check_cookie){
        $load_remove_question = R::load('questions',$opened_question);
        if($load_remove_question->user == $user_infos->login || $user_infos->status == 9){
            $remove_tag_arr = explode(',',$load_remove_question->tags);
            $find_question_answers = R::find('answers','question_id = ?',[$opened_question]);
            R::trashAll($find_question_answers);
            foreach ($remove_tag_arr as $tag) {
                $find_tag_to_minus = R::findOne('tags','name_ru = ?',[$tag]);
                $minus_question_numbers = R::dispense('tags');
                $minus_question_numbers->id = $find_tag_to_minus->id;
                $minus_question_numbers->questions = $find_tag_to_minus->questions - 1;
                R::store($minus_question_numbers);
            }
            R::trash($load_remove_question);
            header('Location: index.php');
            exit();
        }
    }
}
if($page == 'question'){ 
    $opened_question_load = R::load('questions',$opened_question);
    if(!isset($like_answer) && !isset($unlike_answer) && !isset($check_answer) && !isset($uncheck_answer) && !isset($remove_answer)){
        if(!empty($_POST)){
            if(isset($_POST['HCeditorContent'])){
                if($cookie_checked){
                    $change_question_answered = R::load('questions',$opened_question);
                    $change_question_answered->answers = $change_question_answered->answers + 1;
                    R::store($change_question_answered);
                    $change_users_answer_count = R::load('users',$user_infos->id);
                    $change_users_answer_count->answers = $change_users_answer_count->answers + 1;
                    R::store($change_users_answer_count);
                    $add_answer_to_question = R::dispense('answers');
                    $add_answer_to_question->question_id = $opened_question;
                    $add_answer_to_question->answer_content = $_POST['HCeditorContent'];
                    $add_answer_to_question->date = date('d.m.Y');
                    $add_answer_to_question->time = date('H:i:s');
                    $add_answer_to_question->user = $user_infos->login;
                    $add_answer_to_question->likes = 0;
                    $add_answer_to_question->check_answer = 0;
                    R::store($add_answer_to_question);
                    if($user_infos->login != $opened_question_load->user){
                        $add_notif = R::dispense('notifications');
                        $add_notif->from_id = $user_infos->id;
                        $add_notif->from_login = $user_infos->login;
                        $add_notif->to = $opened_question_load->user;
                        $add_notif->type = 0;
                        $add_notif->where = 'index.php?page=question&question='.$opened_question;
                        $add_notif->viewed = 0;
                        $add_notif->date = date('d.m.Y');
                        $add_notif->time = date('H:i:s');
                        R::store($add_notif);
                    }
                    header('Refresh:0');
                    exit();
                }
            }
        }
        $pageTitle = $opened_question_load->title.' - ';
    }else{
        if(isset($like_answer)){
            if($cookie_checked){
                $load_if_not_liked_answer_user = R::find('users','WHERE id = ? AND answer_likes LIKE ?',[$user_infos->id,'%,'.$like_answer.',%']);
                if(empty($load_if_not_liked_answer_user)){
                    $load_liked_answer = R::load('answers',$like_answer);
                    $load_liked_answer->likes = $load_liked_answer->likes + 1;
                    R::store($load_liked_answer);
                    $load_liked_answer_user = R::load('users',$user_infos->id);
                    $load_liked_answer_user->answer_likes = $load_liked_answer_user->answer_likes.$like_answer.',';
                    R::store($load_liked_answer_user);
                    if($user_infos->login != $load_liked_answer->user){
                        $add_notif = R::dispense('notifications');
                        $add_notif->from_id = $user_infos->id;
                        $add_notif->from_login = $user_infos->login;
                        $add_notif->to = $load_liked_answer->user;
                        $add_notif->type = 1;
                        $add_notif->where = 'index.php?page=question&question='.$opened_question;
                        $add_notif->viewed = 0;
                        $add_notif->date = date('d.m.Y');
                        $add_notif->time = date('H:i:s');
                        R::store($add_notif);
                    }
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }elseif (isset($check_answer)) {
            if($cookie_checked){
                $load_clicked_check_answer_question = R::load('questions',$opened_question);
                if($load_clicked_check_answer_question->user == $user_infos->login){
                    if($load_clicked_check_answer_question->check_answer == ','){
                        $load_clicked_check_answer_question->check_answer = ','.$check_answer.',';
                        $load_checked_answer = R::load('answers',$check_answer);
                        $load_checked_answer->check_answer = 1;
                        $add_notif = R::dispense('notifications');
                        $add_notif->from_id = $user_infos->id;
                        $add_notif->from_login = $user_infos->login;
                        $add_notif->to = $load_checked_answer->user;
                        $add_notif->type = 2;
                        $add_notif->where = 'index.php?page=question&question='.$opened_question;
                        $add_notif->viewed = 0;
                        $add_notif->date = date('d.m.Y');
                        $add_notif->time = date('H:i:s');
                        R::store($load_checked_answer);
                        R::store($load_clicked_check_answer_question);
                        R::store($add_notif);
                        header("Location:".$_SERVER['HTTP_REFERER']);
                        exit();
                    }else{
                        $load_if_not_checked_question_answer = R::find('questions','WHERE id = ? AND check_answer LIKE ?',[$opened_question,'%,'.$check_answer.',%']);
                        if(empty($load_if_not_checked_question_answer)){
                            $load_check_answer_to_question = R::load('questions',$opened_question);
                            $load_check_answer_to_question->check_answer = $load_check_answer_to_question->check_answer.$check_answer.',';
                            $load_checked_answer = R::load('answers',$check_answer);
                            $load_checked_answer->check_answer = 1;
                            R::store($load_checked_answer);
                            R::store($load_check_answer_to_question);
                            header("Location:".$_SERVER['HTTP_REFERER']);
                            exit();
                        }             
                    }
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }elseif (isset($unlike_answer)) {
            if($cookie_checked){
                $load_user_answer_likes = R::load('users',$user_infos->id);
                $answer_likes_arr = explode(',',$load_user_answer_likes->answer_likes);
                $new_like_list = [];
                foreach ($answer_likes_arr as $like) {
                    if($like != $unlike_answer){
                        $new_like_list[] = $like;
                    }
                }
                $load_answer_likes = R::load('answers',$unlike_answer);
                $load_answer_likes->likes = $load_answer_likes->likes - 1;
                $load_user_answer_likes->answer_likes = implode(',',$new_like_list);
                R::store($load_user_answer_likes);
                R::store($load_answer_likes);
                header("Location:".$_SERVER['HTTP_REFERER']);
                exit();
            }
        }elseif (isset($uncheck_answer)) {
            if($cookie_checked){
                $find_answer_in_check_answers_to_question = R::find('questions','WHERE id = ? AND check_answer LIKE ?',[$opened_question,'%,'.$uncheck_answer.',%']);
                if(!empty($find_answer_in_check_answers_to_question)){
                    $load_uncheck_answer_question = R::load('questions',$opened_question);
                    $check_answers_arr = explode(',',$load_uncheck_answer_question->check_answer);
                    $new_check_answer = [];
                    foreach ($check_answers_arr as $answer) {
                        if($answer != $uncheck_answer){
                            $new_check_answer[] = $answer;
                        }
                    }
                    $load_uncheck_answer_question->check_answer = implode(',',$new_check_answer);
                    $load_uncheck_answer = R::load('answers',$uncheck_answer);
                    $load_uncheck_answer->check_answer = 0;
                    R::store($load_uncheck_answer);
                    R::store($load_uncheck_answer_question);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }elseif (isset($remove_answer)) {
            if($cookie_checked){
                $load_answer_to_remove = R::load('answers',$remove_answer);
                if($user_infos->status == 9 || $load_answer_to_remove->user == $user_infos->login){
                    if($load_answer_to_remove->check_answer){
                        $load_question_to_change_check_answers_list = R::load('questions',$opened_question);
                        $check_answers_arr = explode(',',$load_question_to_change_check_answers_list->check_answer);
                        $new_check_answers_list = [];
                        foreach ($check_answers_arr as $answer) {
                            if($answer != $remove_answer){
                                $new_check_answers_list[] = $answer;
                            }
                        }
                        $load_question_to_change_check_answers_list->check_answer = implode(',',$new_check_answers_list);
                        R::store($load_question_to_change_check_answers_list);
                    }
                    R::trash($load_answer_to_remove);
                    $load_question_to_minus_answer = R::load('questions',$opened_question);
                    $load_question_to_minus_answer->answers = $load_question_to_minus_answer->answers - 1;
                    R::store($load_question_to_minus_answer);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }else{
                header("Location:".$_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
}
if($page == 'subscribe'){
    if($cookie_checked){
        if(isset($_GET['sub_tag'])){
            $load_tag = R::load('tags',$_GET['sub_tag']);
            if($load_tag->id != 0){
                $find_user_subscribed = R::findOne('users','WHERE id = ? AND subscribe_tag LIKE ?',[$user_infos->id,'%,'.$load_tag->name_ru.',%']);
                if(empty($find_user_subscribed)){
                    $add_subcrirebed_tag = R::load('users',$user_infos->id);
                    $add_subcrirebed_tag->subscribe_tag = $add_subcrirebed_tag->subscribe_tag.$load_tag->name_ru.',';
                    $load_tag->subscribes = $load_tag->subscribes + 1;
                    R::store($load_tag);
                    R::store($add_subcrirebed_tag);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }else{
                header("Location: index.php");
                exit();
            }
        }else{
            header("Location: index.php");
            exit();
        }
    }else{
        header("Location: index.php");
        exit();
    }
}

if($page == 'unsubscribe'){
    if($cookie_checked){
        if(isset($_GET['sub_tag'])){
            $load_unsubscribe_tag = R::load('tags',$_GET['sub_tag']);
            if($load_unsubscribe_tag->id != 0){
                $find_have_tag = R::findOne('users','WHERE id = ? AND subscribe_tag LIKE ?',[$user_infos->id,'%,'.$load_unsubscribe_tag->name_ru.',%']);
                if(!empty($find_have_tag)){
                    $old_subscribed_tag_arr = explode(',',$find_have_tag->subscribe_tag);
                    foreach ($old_subscribed_tag_arr as $tag) {
                        if($tag != $load_unsubscribe_tag->name_ru){
                            $new_subscribed_tag_arr[] = $tag;
                        }
                    }
                    $load_user_to_change_subscribe_tag = R::load('users',$user_infos->id);
                    $load_user_to_change_subscribe_tag->subscribe_tag = implode(',',$new_subscribed_tag_arr);
                    $load_unsubscribe_tag->subscribes = $load_unsubscribe_tag->subscribes - 1;
                    R::store($load_unsubscribe_tag);
                    R::store($load_user_to_change_subscribe_tag);
                    header("Location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }else{
                    header("Location: index.php");
                    exit();
                }
            }else{
                header("Location: index.php");
                exit();
            }
        }else{
            header("Location: index.php");
            exit();
        }
    }
}

if($page == 'blog'){
    if(isset($_POST['blog_comment_add_submit']) && $cookie_checked){
        $change_question_comments = R::load('blog',$blog_id);
        $change_question_comments->comments = $change_question_comments->comments + 1;
        R::store($change_question_comments);
        $addCommentToBlog = R::dispense('commentstoarticle');
        $addCommentToBlog->article_id = $blog_id;
        $addCommentToBlog->content = $_POST['HCeditorContent'];
        $addCommentToBlog->user_id = $user_infos['id'];
        $addCommentToBlog->user_name = $user_infos['name'];
        $addCommentToBlog->user_surname = $user_infos['surname'];
        $addCommentToBlog->user_login = $user_infos['login'];
        $addCommentToBlog->date = date('d.m.Y');
        $addCommentToBlog->time = date('H:i:s');
        R::store($addCommentToBlog);
        header("Location:".$_SERVER['HTTP_REFERER']);
        exit();
    }
}
if(isset($_GET['notif'])){
        $notifEdit = R::load('notifications',$_GET['notif']);
        if($cookie_checked){
            if($notifEdit->to == $user_infos->login){
                if(!$notifEdit->viewed){
                    $notifEdit->viewed = 1;
                    R::store($notifEdit);
                }
            }
        }
}
?>