<?php
include_once "Functions/functions.php";
checkAuth();
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

if(isset($_POST['but_log']))

{
    $data = getUserByLogin($_POST['login']);

    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        $hash = md5(generateCode(10));
        # Записываем в БД новый хеш авторизации и IP
        $session_id = updateSessionHash($hash, $data['user_id']);

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


<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>

<header class="mb-3">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">USERS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php
      if (empty($_SESSION['auth']) or $_SESSION['auth']==false)
      {
        echo "<button type='button' class='btn btn-primary ml-auto mx-2' data-toggle='modal' data-target='#Login'>Войти</button>";
      }
      else {
        $userdata = getUserByID($_SESSION['user_id']);
        echo "<b class='ml-auto'>".$userdata['user_login']."</b>";
        echo "<a href='logout.php' class='btn btn-primary mx-2'>Выйти</a>";
      }
      ?>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Calc">Калькулятор</button>
    </div>
  </nav>
</header>
<!-- Регистрация -->
<div class="modal fade" id="Login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Вход</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class=""  action="" name="login_form" method="post">
      <div class="modal-body">
          <input class="form-control mb-2" type="text" name="login" value="" placeholder="Имя">
          <input class="form-control mb-2" type="password" name="password" value="" placeholder="Пароль">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="remember" id="checkboxRemember">
            <label class="custom-control-label" for="checkboxRemember">Чужой компьютер</label>
          </div>
          <div class="input-group mb-3">
            <div class="input-group mb-3">
        </div>
  </div>
      </div>
      <div class="modal-footer">
        <input class="btn btn-outline-success px-5 w-100" type="submit" name="but_log" value="Войти">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Калькулятор -->

<div class="modal fade" id="Calc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary">Расчитать</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
