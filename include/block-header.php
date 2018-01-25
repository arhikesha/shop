<?php
	defined('myeshop') or die ('Доступ запрещён!');
?>
<div id="block-header"> 
	
	<div id= "header-top-block">
		<ul id ="header-top-menu">
			<li>Ваш город-<span>Днепр</span></li>
			<li><a href="o_nas.php">О нас</a></li>
			<li><a href="#">Магазины</a></li>
			<li><a href="feedback.php">Контакты</a></li>
		</ul>
		
<?php
		if($_SESSION['auth'] == 'yes_auth'){
			echo '<p id = "auth-user-info" align = "right"><img src ="image/eye.png" />Здравствуйте,'.$_SESSION['auth_name'].'! </p>';	
		}else {
			echo '<p id="reg-auth-title" align="right"><a class="top-auth">Вход</a><a href="register.php">Регистрация</a></p>';
		}
		
?>
		
		
	
			<div id="block-top-auth">
			<div class="corner"></div>
			
			<form method="POST">
			
				<ul id="input-email-pass">
				
				<h3 id="botton_load" >Вход</h3>
				
				<p id="massege-auth">Неверный Логин или пароль</p>
				
				<li><center><input type="text" id ="auth_login" placeholder="Логин или E-mail"/></center></li>
				<li><center><input type="password"  id ="auth_pass" placeholder="Пароль"/></center></li>
				
					<ul id ="list-auth">
						<li><input type="checkbox" name="rememberme" id="rememberme"/><label for ="rememberme">Запомнить меня</label></li>
						<li><a id="remindpass" href="#"/>Забыли пароль</a></li>
					</ul>
					
					<p align="right" id="botton_auth"><a>Вход</a></p>
					
					<!-- <p align="right" class="auth-loading"><img src=""/></p> -->
					
				</ul>
			</form>
			<div id = "block-remind">
			<h3>Востановление <br /> пароля</h3>
			<p id = "massege-remind" class ="massege-remind-success"></p>
			<center><input type="text" id ="remind-email" placeholder="Ваш email"/></center>
			<p align ="right" id= "button-remind"><a>Готово</a></p>
			<p id = "prev-auth">Назад</p>
			</div>
				
			</div>
	</div><hr>
	<div id="top-line"></div>
		<div id = "block-user">
			<!-- <div class = "corner2"></div> -->
			<ul>
				<li><img src = "image/eye.png" /> <a href = "profile.php">Профиль</a></li>
				<li><img src = "image/bubble.png" /> <a id ="logout">Выход</a></li>
			</ul>
		</div>
	
	
		<img id ="img-logo" src = "image/logo4.jpeg"/>
		<div id = "personal-info">
		<p align="right"> Звонок бесплатный:</p>
		<h3 align="right">8(099)468-40-53</h3>
		<p align="right">Режим роботы:</p>
		<p align="right">Будни дни : c 9:00 до 18:00 </p>
		<p align="right">Суббота, Воскресенье - выходные </p>
	</div>
		
		<div id="block-search">
			<form method="GET"action="search.php?">
			<input type="text" id="input-search"name="q" placeholder="Поиск среди 100 000 товаров" value ="<?  echo $search; ?>"/>
			<input type="submit" id="botton-search" value="поиск" />
			</form>
			<ul id ="result-search">
			
			
			
			
			</ul>
		</div>
</div>
	
<div id="top-menu">
	<ul>
		<li><a href ="index.php">Главная</a></li>
		<li><a href ="view_aystopper.php?go=news">Новинки</a></li>
		<li><a href ="view_aystopper.php?go=leaders">Лидеры продаж</a></li>
		<li><a href ="view_aystopper.php?go=sale">Распродажа</a></li>
	</ul>
	<p align="right" id="block-basket"><img src="image/shoping.png"><a href="cart.php?action=oneclick"> Корзина пуста</a></p>
</div><hr>
			
