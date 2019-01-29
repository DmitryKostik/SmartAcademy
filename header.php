<?php
include_once "Functions/functions.php";
checkAuth();
?>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>
<header class="mb-3">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-1024">

    <a class="navbar-brand" href="#"><i class="fab fa-phoenix-squadron"> SMART ACADEMY</i></a>
      <?php
      if (empty($_SESSION['auth']) or $_SESSION['auth']==false)
      {
      }
      else {
        $username = getUserFIOByID($_SESSION['user_id']);
        echo "<div class='dropdown ml-auto'>
        <button type='button' class='btn user-button dropdown-toggle' id='dropdownMenuOffset' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-offset='100,20'>
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
  </nav>
</header>


<div class="container">
  <div class="row">
    <div class="col-2">
      <div class="leftnav">
        <a href="messages.php" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">Сообщения<span class="badge badge-primary badge-pill"><?=getCountUnreadDialogs($_SESSION['user_id'])?></span></a>
        <a href="#" class="list-group-item list-group-item-action">Мероприятия</a>
        <a href="#" class="list-group-item list-group-item-action">Документы</a>
        <a href="#" class="list-group-item list-group-item-action">Приложения</a>
      </div>
    </div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
