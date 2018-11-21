<?php
include_once "Functions/functions.php";
include "header.php";
echo "<div class='col-10'>";
if(isset($_GET['sel']))
{
  $sel=$_GET['sel'];
  $messages = getMessagesWithUser($_SESSION['user_id'], $sel);
  $adressee_name = getUserFIOByID($sel);

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
echo "</div></div></div>";
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
