<?php
include_once "Functions/functions.php";
	session_start();
	if (!empty($_SESSION['auth']) and $_SESSION['auth']) {
		session_destroy(); //разрушаем сессию для пользователя
		//Удаляем куки авторизации путем установления времени их жизни на текущий момент:
    destroySessionByID($_COOKIE['sessionid']); //Меняем значение сессии в БД
		setcookie('sessionid', '', time()); //удаляем логин
		setcookie('hash', '', time()); //удаляем ключ
		header("Location: header.php"); exit();
	}
?>
