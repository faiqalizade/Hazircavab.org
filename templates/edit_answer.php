<?php 
require '../db.php';
$edit_answer_load = R::load('answers',$_POST['answerId']);
$edit_answer_load->answer_content = $_POST['editAnswerContent'];
R::store($edit_answer_load);
?>