<?php
include_once "Functions/functions.php";
include "header.php";
echo "<div class='col-lg-10 col-sm-12'>";
if(isset($_GET['sel']))
{
  $sel=$_GET['sel'];
  if(isset($_POST['btn_send']))
  {
    addMessagesWithUser($_SESSION['user_id'], $sel, $_POST['textarea']);
    header("location: messages.php?sel=$sel");
  }
  $messages = getMessagesWithUser($_SESSION['user_id'], $sel);
  $adressee_name = getUserFIOByID($sel);

  include "messageWithUser.php";
}

else
{
  $messages = getLastUserMessages($_SESSION['user_id']);
  include "lastUserMessages.php";
}
echo "</div></div></div>";
?>
