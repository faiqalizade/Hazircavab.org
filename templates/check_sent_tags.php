<?php
require '../db.php';
$checkedTagsArr = [];
foreach ($_POST['checkTag'] as $tagname) {
    $check_sent_tag = R::findOne('tags','tagname = ?',[mb_strtolower($tagname)]);
    if(!empty($check_sent_tag)){
        $checkedTagsArr[] = $tagname;
    }  
}
?>
<?= implode(',',$checkedTagsArr)?>