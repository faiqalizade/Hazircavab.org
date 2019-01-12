<?php
require '../db.php';
$checkedTagsArr = [];
foreach ($_POST['checkTag'] as $tagname) {
    $check_sent_tag = R::findOne('tags','name_ru = ?',[mb_strtolower($tagname)]);
    if(!empty($check_sent_tag)){
        $checkedTagsArr[] = $check_sent_tag->name_ru;
    }  
}
?>
<?= implode(',',$checkedTagsArr)?>