<?php
include "Functions/functions.php";
function generateCode($length=6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length)
    {
      $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

if(isset($_POST['submit']))

{
    $data = getUserByLogin($_POST['login']);

    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        $hash = md5(generateCode(10));
        # Записываем в БД новый хеш авторизации и IP
        $session_id = updateSessionHash($hash, $data['user_id']);

        #Запускаем сессию
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $data['user_id'];
        # Ставим куки
        if (empty($_POST['remember'])) {
          setcookie("sessionid", $session_id, time()+60*60*24*30);
          setcookie("hash", $hash, time()+60*60*24*30);
        }
        # Переадресовываем браузер на страницу проверки нашего скрипта
        //header("Location: check.php"); exit();
    }

    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}

?>

<form method="POST">

Логин <input name="login" type="text"><br>

Пароль <input name="password" type="password"><br>

Не запоминать <input type="checkbox" name="remember"><br>

<input name="submit" type="submit" value="Войти">

</form>
