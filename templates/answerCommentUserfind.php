<?php
require '../db.php';
$user = R::findOne('users','login = ?',[$_POST['user']]);
if(!empty($user)){
    echo "true,$user->id";
}else{
    echo "false";
}
?>