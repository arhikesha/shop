<?php
	defined('myeshop') or die ('Доступ запрещён!');
?>
<div id="block-news"> 
<center>	<img id="news-prev" src = "image/top.png"/> </center>

	<div id="newsticker">
		
		<ul>
<?php
			$result = mysqli_query($link,"SELECT * FROM news ORDER BY id DESC");
	
			if(mysqli_num_rows($result)>0)
			{
				$row = mysqli_fetch_array($result);
			do
			{
				
			
				echo '
						<li>
							<span>'.$row["date"].'</span>
							<a href=""> '.$row["title"].'</a>
							<p> '.$row["text"].'</p>
						</li>
						
						';
			}
			while($row = mysqli_fetch_array($result));
	}
		
?>
		
			
		
		</ul>
	
	
	
	
	</div>
	<center>	<img id="news-next" src = "image/bot.png"/> </center>
	

</div>