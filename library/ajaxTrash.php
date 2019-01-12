<?php 
require '../db.php';
$trash_request = R::load($_POST['table'],$_POST['trash_id']);
R::trash($trash_request);
?>