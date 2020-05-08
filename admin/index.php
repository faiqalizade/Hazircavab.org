<?php
require 'templates/header.php';
?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Hazir Cavab - Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<script>
var 
lastPage        = <?=$rightPage?>,
userLogin       = '<?=$check_cookie->login?>',
userName        = '<?=$check_cookie->name?>',
userSurname     = '<?=$check_cookie->surname?>';
</script>
<body>
        <div class="wrapper" id='container'>
                <v-header ></v-header>
                <div class="content">
                        <div class='sidebar-wrapper'>
                                <v-sidebar v-on:changer="tab = $event" ></v-sidebar>
                        </div>
                        <div class="main-content">
                                <v-content-questions v-if="tab == 'questions'"></v-content-questions>
                                <v-blogs v-else-if="tab == 'blog'"></v-blogs>
                                <v-add-blog v-else-if="tab == 'addBlog'" ></v-add-blog>
                                <v-add-tag v-else-if="tab == 'addTag'" ></v-add-tag>
                                <v-users v-else-if="tab == 'users'" ></v-users>
                                <v-tags v-else-if="tab == 'tags'" ></v-tags>
                        </div>
                </div>
        </div>
</body>
</html>
<link rel="stylesheet" href="css/all.css">
<script src="../js/jquery-3.2.1.js"></script>
<script src="../js/vue.js"></script>
<script src="../../HCeditor/HCeditorjs.js"></script>
<script src="js/vueComponents.js"></script>
<script src="js/main.js"></script>