<?php
include "Functions/functions.php";
if(isset($_POST['submit']))
{
    $err = array();
    # проверям логин
    if(!preg_match("/^[a-zA-Z0-9_]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    # проверяем, не сущестует ли пользователя с таким именем
    $count = ifExistUser($_POST['login']);
    if($count > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }
    # Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        $login = $_POST['login'];
        # Убераем лишние пробелы и делаем двойное шифрование
        $password = md5(md5(trim($_POST['password'])));
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $patronomic = $_POST['patronomic'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        registerUser($login, $password, $first_name, $last_name, $patronomic, $birthday, $phone);
        //header("Location: login.php"); exit();

    }

    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>
<input type="date" name="dates" id="date">
<form method="POST">
Логин <input name="login" type="text"><br>
Пароль <input name="password" type="password"><br>
Имя <input name="firstname" type="text"><br>
Фамилия <input name="lastname" type="text"><br>
Отчество <input name="patronomic" type="text"><br>
Дата рождения <input name="birthday" type="text">
Телефон <input name="phone" type="text">

<input name="submit" type="submit" value="Зарегистрироваться">

</form>
