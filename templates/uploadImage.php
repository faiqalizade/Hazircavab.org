<?php
copy($_FILES['file']['tmp_name'],'../usersfiles/'.$_POST['profil'].'/images'.'/'.$_POST['imgName'].'.png');
?>