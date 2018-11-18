<?php
session_start();
include "Functions/functions.php";
if (empty($_SESSION['auth']) or $_SESSION['auth'] == false)
{
		//Проверяем, не пустые ли нужные нам куки...
		if ( !empty($_COOKIE['sessionid']) and !empty($_COOKIE['hash']))
    {
      $userdata = getSessionHash($_COOKIE['sessionid'], $_COOKIE['hash']);
      if(!empty($userdata) and $userdata['destroyed']='1')
      {
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $userdata['user_id'];

      }
    }
  }
?>
