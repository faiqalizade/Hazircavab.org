<?php
$lastThreeArticles = R::find('blog', 'ORDER BY date DESC,time DESC LIMIT 3');
?>
<div class="blog_page">
	<p class="blog_page_header">Блог - Новые статьи <a href="index.php?page=blog" class="blog_page_header_link">Все статьи</a>
	</p>
	<div class="blog_page_newblogs">
		<?php foreach($lastThreeArticles as $article): ?>
		<a href="index.php?page=blog&blog=<?=$article->id?>" class="blog_article">
			<img class="blog_article_image" src="<?=$article->image?>">
			<div class="blog_article_info">
				<p id="blog_article_info_header"><?=$article->title?></p>
				<p><?=$article->views?> - Просмотров &#8226; <?=$article->comments?> - Коментарий</p>
			</div>
		</a>
		<?php endforeach; ?>
	</div>
</div>