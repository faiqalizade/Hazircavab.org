<?php
date_default_timezone_set('Asia/Baku');
require '../db.php';
$questionsCount = R::count('questions');
//Деление без остатка в большую сторону
$rightPage = ceil($questionsCount / 40);
if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_hash'])){
        $check_cookie = R::load('users', $_COOKIE['user_id']);
        if ($check_cookie->user_hash != $_COOKIE['user_hash'] || $check_cookie['status'] != 9) {
            setcookie('user_id','', time() - 3600,'/');
            setcookie('user_hash','', time() - 3600,'/');
            header('Location: ../');
            $cookie_checked = false;
        }else{
            $cookie_checked = true;
            $user_infos = $check_cookie;
        }
    }else{
        header('Location: ../');
        setcookie('user_hash','', time() - 3600,'/');
        setcookie('user_id','', time() - 3600,'/');
        $cookie_checked = false;
}

if(isset($_POST['add-article-submit']) && $cookie_checked){
        copy($_FILES['article-img']['tmp_name'],'../images/blog/'.date('d-m-Y').date('H-i-s').'.jpg');
        $addArticle = R::dispense('blog');
        $addArticle->title = $_POST['article-title'];
        $addArticle->image = 'images/blog/'.date('d-m-Y').date('H-i-s').'.jpg';
        $addArticle->lang = $_POST['article-lang'];
        $addArticle->content = $_POST['HCeditorContent_article-content'];
        $addArticle->desc = substr($_POST['HCeditorContent_article-content'],0,230).'...';
        $addArticle->user_id = $user_infos['id'];
        $addArticle->user_name = $user_infos['name'];
        $addArticle->user_surname = $user_infos['surname'];
        $addArticle->user_login = $user_infos['login'];
        $addArticle->likes = 0;
        $addArticle->views = 0;
        $addArticle->comments = 0;
        $addArticle->date = date('Y-m-d');
        $addArticle->time = date('H:i:s');
        R::store($addArticle);
}
if(isset($_POST['add-tag-submit']) && $cookie_checked){
        if (isset($_GET['edit_tag'])) {
            $editTag = R::load('tags',$_GET['edit_tag']);
            if($editTag->id != 0){
                $editTag->name_ru = $_POST['tag-name-ru'];
                $editTag->name_az = $_POST['tag-name-az'];
                R::store($editTag);
                copy($_FILES['article-img']['tmp_name'],'../tagimages/'.$_GET['edit_tag'].'.png');
            }
        }else{
            $addTag = R::dispense('tags');
            $addTag->name_ru = $_POST['tag-name-ru'];
            $addTag->name_az = $_POST['tag-name-az'];
            $addTag->subscribes = 0;
            $addTag->questions = 0;
            $lastId = R::store($addTag);
            copy($_FILES['article-img']['tmp_name'],'../tagimages/'.$lastId.'.png');
        }
}
if($_GET['p'] == 'removeTag'){
    // TO DO REMOVE TAG
}
if($_GET['p'] == 'remove_blog'){
    $removeBlog = R::load('blog',$_GET['blog']);
    R::trash($removeBlog);
    header("Location:".$_SERVER['HTTP_REFERER']);
    exit();
}
?>