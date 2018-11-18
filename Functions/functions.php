<?php
 $link=false;
 include "Browser.php";

function openDB()
{
	global $link;
	$link = mysqli_connect("localhost","root", "0000","smartacademy");
	mysqli_query($link, "SET NAMES UTF8");
}

function closeDB()
{
	global $link;
	mysqli_close($link);
}

function ifExistUser($login){
  global $link;
	openDB();
	$user = mysqli_query($link,"SELECT COUNT(user_id) FROM users WHERE user_login='".mysqli_real_escape_string($link,  $login)."'");
	closeDB();
	$row =  mysqli_fetch_array($user);
  $count = $row[0];
  return $count;
}

function registerUser($login, $password, $first_name, $last_name, $patronomic, $birthday, $phone)
{
  global $link;
	openDB();
	$user = mysqli_query($link,"CALL addUser('$login', '$password', '$first_name', '$last_name', '$patronomic', '$birthday', '$phone')");
	closeDB();
	return $user;
}

function getUserByID($id)
{
	global $link;
	openDB();
	$userlogin = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE user_id=$id "));
	closeDB();
	return $userlogin;
}

function getUserByLogin($login)
{
  global $link;
	openDB();
  $data = mysqli_query($link, "SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link, $login)."' LIMIT 1");
  closeDB();
  return mysqli_fetch_assoc($data);
}

function updateSessionHash($hash, $id)
{
  global $link;
  openDB();
  $ip = "INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
  $browserObject = new Browser();
  $browser = $browserObject->getBrowser();
  $session = mysqli_query($link, "INSERT INTO sessions SET user_hash='".$hash."', user_ip=$ip, user_agent='$browser', user_id=$id");
  $sessionid = mysqli_fetch_array(mysqli_query($link, "SELECT session_id FROM sessions WHERE user_hash='".$hash."' and user_ip=$ip and user_id=$id"));
  closeDB();
  return $sessionid[0];
}

function getSessionHash($session_id, $session_hash)
{
  global $link;
  openDB();
  $hash = mysqli_query($link, "SELECT * FROM sessions WHERE session_id = '".intval($session_id)."' AND user_hash='$session_hash'  LIMIT 1");
  closeDB();
  return mysqli_fetch_assoc($hash);
}

function destroySessionByID($session_id)
{
  global $link;
  openDB();
  $hash = mysqli_query($link, "UPDATE sessions SET destroyed=0 WHERE session_id = $session_id");
  echo "UPDATE sessions SET destroyed=0 WHERE session_id = $session_id";
  closeDB();
}

function getAllStudents(){
	global $link;
	openDB();
	$res = mysqli_query($link,"");
	closeDB();
	return $res->fetch_all($resultype=MYSQLI_ASSOC);
}

function checkAuth()
{
  session_start();
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
}
