<?php
require '../db.php';
$comment = R::load('commentstoanswer',$_POST['comment']);
R::trash($comment);
?>