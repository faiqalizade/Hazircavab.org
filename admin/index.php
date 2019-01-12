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
        copy($_FILES['article-img']['tmp_name'],'../images/blog/'.date('d-m-Y').date('H-i-s').'.png');
        $addArticle = R::dispense('blog');
        $addArticle->title = $_POST['article-title'];
        $addArticle->image = 'images/blog/'.date('d-m-Y').date('H-i-s').'.png';
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
        $addArticle->date = date('d.m.Y');
        $addArticle->time = date('H:i:s');
        R::store($addArticle);
}
if(isset($_POST['add-tag-submit']) && $cookie_checked){
        copy($_FILES['article-img']['tmp_name'],'../tagimages/'.$_POST['tag-name-ru'].'.png');
        $addTag = R::dispense('tags');
        $addTag->name_ru = $_POST['tag-name-ru'];
        $addTag->name_az = $_POST['tag-name-az'];
        $addTag->subscribes = 0;
        $addTag->questions = 0;
        R::store($addTag);
}
?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Hazir Cavab - Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<script>
var lastPage = <?=$rightPage?>;
</script>
<body>
        <div class="wrapper" id='container'>
                <v-header></v-header>
                <div class="content">
                        <div class='sidebar-wrapper'>
                                <v-sidebar v-on:changer="tab = $event" ></v-sidebar>
                        </div>
                        <div class="main-content">
                                <v-content-questions v-if="tab == 'questions'"></v-content-questions>
                                <v-content-blog v-else-if="tab == 'blog'"></v-content-blog>
                                <v-add-blog v-else-if="tab == 'addBlog'" ></v-add-blog>
                                <v-add-tag v-else-if="tab == 'addTag'" ></v-add-tag>
                        </div>
                </div>
        </div>
</body>
</html>
<link rel="stylesheet" href="css/all.css">
<script src="../js/jquery-3.2.1.js"></script>
<script src="../js/vue.js"></script>
<script src="../../HCeditor/HCeditorjs.js"></script>
<script src="js/vueComponents.js"></script>
<script src="js/main.js"></script>