<?php
include "Functions/functions.php";
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
        header("Location: messages.php"); exit();
    }

    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="CSS/style.css">

<header class="mb-3">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-1024">
<a class="navbar-brand" href="#"><i class="fab fa-phoenix-squadron"> SMART ACADEMY</i></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <?php
  if (empty($_SESSION['auth']) or $_SESSION['auth']==false)
  {
  }
  else {
    $username = getUserFIOByID($_SESSION['user_id']);
    echo "<div class='dropdown ml-auto'>
    <button type='button' class='btn btn-outline-light dropdown-toggle' id='dropdownMenuOffset' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-offset='100,20'>
    ".$username."
    </button>

    <div class='dropdown-menu' aria-labelledby='dropdownMenuOffset'>
      <a class='dropdown-item' href='#'>Моя страница</a>
      <div class='dropdown-divider'></div>
      <a class='dropdown-item' href='#'>Another action</a>
      <div class='dropdown-divider'></div>
      <a class='dropdown-item' href='logout.php'>Выйти</a>
    </div>
  </div>";
  }
  ?>
</div>
</div>
</nav>
</header>


  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" method="post">
      <div class="modal-body">
        <div class="form-group">
          <input type="login" name="login" class="form-control" placeholder="Введите логин">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Введите пароль">
        </div>
        <div class="form-group form-check">
          <input type="checkbox" name="remember"  class="form-check-input" id="checkRemember">
          <label class="form-check-label" for="checkRemember">Запомнить</label>
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" name="submit" class="btn btn-outline-primary mx-auto" value="Войти">
      </div>
      </form>
      </div>
    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
