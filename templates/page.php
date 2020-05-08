<?php
if ($page == '' || $page == 'questions') {
	require 'templates/main.php';
}elseif ($page == 'blog') {
	if (!isset($blog_id)) {
		require 'templates/blog.php';
	}elseif (isset($blog_id)) {
		require 'templates/opened_blog.php';
	}
}elseif ($page == 'question') {
	require 'templates/opened_question.php';
}elseif ($page == 'users') {
	require 'templates/users_list.php';
}elseif ($page == 'user') {
	require 'templates/opened_user_profile.php';
}elseif ($page == 'tags') {
	if (!isset($tag)) {
		require 'templates/taglist.php';
	}else{
		require 'templates/opened_tag.php';
	}
}elseif ($page == 'login') {
	require 'templates/login.php';
}elseif ($page == 'registr') {
	require 'templates/registr.php';
}elseif ($page == 'myprofile') {
	require 'templates/myprofil.php';
}elseif ($page == 'adminKabinet') {
	require 'templates/adminpanel.php';
}elseif($page == 'activation') {
	require 'templates/accaunt_activation.php';
}elseif ($page == 'addquestion') {
	require 'templates/addquestion.php';
}elseif ($page == 'edit_question') {
	require 'templates/edit_question.php';
}elseif ($page == 'AFgroup') {
	require "templates/AFgroup.php";
}elseif ($page == 'aboutsite') {
	require "templates/aboutsite.php";
}elseif ($page == 'feedback') {
	require "templates/contacts.php";
}elseif($page == 'q'){
	require 'templates/findPage.php';
}elseif ($page == 'het') {
	require 'templates/het.php';
}elseif ($page == 'notifications'){
	require 'templates/notifications.php';
}elseif ($page == 'forgot') {
	require 'templates/forgotPassword.php';
}
 ?>
