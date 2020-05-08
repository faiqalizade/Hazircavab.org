<?php
require '../db.php';
$checkedTagsArr = [];
foreach ($_POST['checkTag'] as $tagId) {
    $check_sent_tag = R::findOne('tags','id = ?',[$tagId]);
    if(!empty($check_sent_tag)){
    if($_POST['lang'] == 'ru'){
        $checkedTagsArr[] = [$check_sent_tag->name_ru,$check_sent_tag->id];
    }else{
        $checkedTagsArr[] = [$check_sent_tag->name_az,$check_sent_tag->id];
    }
}
}
echo json_encode($checkedTagsArr);
?>