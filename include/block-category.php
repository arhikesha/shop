<?php
	defined('myeshop') or die ('Доступ запрещён!');
?>
<div id="block-category">
	<p class="header-title">Категории товаров</p>
	
	<ul>
		<li><a id="index1"><img src = "image/phone.png" id="mobile-image" />Мобильные телефоны</a>
			<ul class="category-section">
				<li><a href="view_cat.php?type=mobile"><b>Все модели</b></a></li>
				
<?php
	$result = mysqli_query($link,"SELECT * FROM category WHERE type='mobile'");
	
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_array($result);
		do
		{
			echo ' 
			<li><a href="view_cat.php?cat='.strtolower($row["brend"]).'&type='.$row["type"].'">'.$row["brend"].'</a></li>
			';//strtolower -функция делает текст с маленькой буквы
		}
		while($row = mysqli_fetch_array($result));
	}
?>
		
			</ul>
		</li>
		
		<li><a id="index2"><img src = "image/book.png" id="book-image" />Ноутбуки</a>
			<ul class="category-section">
				<li><a href="view_cat.php?type=notebook"><b>Все модели</b></a></li>
				
<?php
	$result = mysqli_query($link,"SELECT * FROM category WHERE type='notebook'");
	
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_array($result);
		do
		{
			echo ' 
			<li><a href="view_cat.php?cat='.strtolower($row["brend"]).'&type='.$row["type"].'">'.$row["brend"].'</a></li>
			';//strtolower -функция делает текст с маленькой буквы
		}
		while($row = mysqli_fetch_array($result));
	}
?>
			</ul>
		</li>
		
		<li><a id="index3"><img src = "image/table.png" id="table-image" />Планшеты</a>
			<ul class="category-section">
			<li><a href="view_cat.php?type=notepad"><b>Все модели</b></a></li>
			
<?php
	$result = mysqli_query($link,"SELECT * FROM category WHERE type='notepad'");
	
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_array($result);
		do
		{
			echo ' 
			<li><a href="view_cat.php?cat='.strtolower($row["brend"]).'&type='.$row["type"].'">'.$row["brend"].'</a></li>
			';//strtolower -функция делает текст с маленькой буквы
		}
		while($row = mysqli_fetch_array($result));
	}
?>
			</ul>
		</li>
	
	
	</ul>
	
</div>
