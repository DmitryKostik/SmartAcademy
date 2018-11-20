<?php
include_once "Functions/functions.php";
include "header.php";

if(isset($_GET['sel']))
{
  $sel=$_GET['sel'];
  $messages = getMessagesWithUser($_SESSION['user_id'], $sel);

  if (!empty($_POST["send_message"]))
  {
    addMessagesWithUser($_SESSION['user_id'], $sel, $_POST['message']);
    header("Location: messages.php?sel=$sel");
  }
  include "messageWithUser.php";
}

else
{
  $messages = getLastUserMessages($_SESSION['user_id']);
  include "lastUserMessages.php";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
