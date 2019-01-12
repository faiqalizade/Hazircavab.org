<?php 
require '../db.php';
$edit_request = R::load($_POST['table'],$_POST['edit_id']);
foreach ($_POST as $key => $val) {
    if($key != 'edit_id' && $key != 'table'){
        $edit_request->$key = $val;
    }
}
$id = R::store($edit_request);
echo $id;
?>