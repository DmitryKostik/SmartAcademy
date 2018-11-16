<?php
 $link=false;
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

function RegisterUser($login, $password, $first_name, $last_name, $patronomic, $birthday, $phone)
{
  global $link;
	openDB();
	$user = mysqli_query($link,"CALL addUser('$login', '$password', '$first_name', '$last_name', '$patronomic', '$birthday', '$phone')");
	closeDB();
	return $user;
}


function getStudentByID($id){
	global $link;
	openDB();
	$res = mysqli_query($link,"SELECT * FROM students WHERE id_student=$id");
	closeDB();
	return mysqli_fetch_assoc($res);
}
function getAllStudents(){
	global $link;
	openDB();
	$res = mysqli_query($link,"");
	closeDB();
	return $res->fetch_all($resultype=MYSQLI_ASSOC);
}
