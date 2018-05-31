	<div class="blog_page">
		<p class="blog_page_header">Блог - Новые статьи <a href="index.php?page=blog" class="blog_page_header_link">Все статьи</a> </p>
		<div class="blog_page_newblogs">
			<?php for($i=0;$i < 3; $i++): ?>
				<div class="blog_article">
					<img class="blog_article_image" src="images/blog1.png">
					<div class="blog_article_info">
						<p id="blog_article_info_header"> <a href="#">Sual</a> </p>
						<p>1213 Просмотров &#8226; 12 Коментарий</p>
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
