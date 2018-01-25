<?php
	defined('myeshop') or die ('Доступ запрещён!');
?>
<script>
$(document).ready(function() {
	var slideElement = $('#blocktracbar')
		$('#blocktracbar').slider({
			range:true,
			min:<?php 
				if((int)$_GET["start_price"] <1000 AND (int)$_GET["start_price"]> 50000){
					echo (int)$_GET["start_price"];
				}else{
					echo "1000";
				}
			?>,
			max:<?php 
				if((int)$_GET["end_price"] <1000 AND (int)$_GET["end_price"] > 50000){
					echo (int)$_GET["end_price"];
				}else{
					echo "50000";
				}
			?>,
			values : [5000,30000],
			slider : function (event,ui){	},
			stop:function (event,ui){
				$('#start-price').val(ui.values[0]);
				$('#end-price').val(ui.values[1]);
			},
		});
 $('#start-price').val(slideElement.slider('values',0));
 $('#end-price').val(slideElement.slider('values',1));
  $.cookie('start-price', 'start', { expires: 7 });
 });
</script>
<div id="block-parametr">
	<p class="header-title">Поиск по параметрам</p>
	<p class="title-filter">Стоимость</p>
	
	<form method="GET" action="search_filter.php">
	
		<div id="block-input-price">
			<ul>
				<li><p>от</p></li>
				<li><input type="text" id = "start-price" name="start_price"  value="5000 " /> </li>
				<li><p>до</p></li>
				<li><input type="text" id = "end-price" name="end_price"  value="30 000 " /> </li>
				<li><p>грн</p></li>
			</ul>
		</div>
		<div  id="blocktracbar"></div>
		
		<p class="title-filter">Производитель</p>
		
		<ul class= "checkbox-brand">
<?php
			$result = mysqli_query($link,"SELECT * FROM category WHERE type = 'mobile'");
	
			if(mysqli_num_rows($result)>0)
			{
				$row = mysqli_fetch_array($result);
			do
			{
				$checked_brend = "";
				if($_GET["brend"]){
					if(in_array($row["id"],$_GET["brend"])){
						$checked_brend ="checked";
					}
				}
			
				echo '
			<li><input '.$checked_brend.' type="checkbox" name ="brend[]" value = "' .$row["id"].'" id="checkbrand'.$row["id"].'" /><label for="'.$row["id"].'">'.$row["brend"].'</label></li>
						';
			}
			while($row = mysqli_fetch_array($result));
	}
		
?>
		
	
		
		</ul>
		
		<center><input type="submit" name="submit" id="button-param-search"value="Найти" /></center>
		
	</form>
	
	
</div>