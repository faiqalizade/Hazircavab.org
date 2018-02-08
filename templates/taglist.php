<div class="main_page_header">
	<p id="main_page_title">Теги</p>
</div>
<div class='tags_list_wrapper'>
<?php
for ($i=0; $i < 21; $i++):
?>
<div class='tag_list_block'>
<a href="index.php?page=tags&tag=0" id="tag_list_tag_image"><img src="images/js.jpg"></a>
<a href="index.php?page=tags&tag=0"><p id="tag_list_tag_name">JavaScript</p></a>
<p id='tag_list_tag_asked'>
<a href="index.php?page=tags&tag=0">123 Вопросов</a>
</p>
<div class='tag_list_tag_subscribe_wrapper'>
<p class='tag_list_tag_subscribe' >Подписаться <span>12</span></p>
</div>
</div>
<?php endfor;?>
</div>