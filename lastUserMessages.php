<?php
echo "<div class='list-group'>";
for($i=0; $i<count($messages);$i++){
    $id=$messages[$i]["id_message"];
    $message = $messages[$i]["message"];
    $date = $messages[$i]["message_date"];
    if($messages[$i]["sender_id"]==$_SESSION['user_id'])
    {
      $user_id = $messages[$i]["adressee_id"];
      $FIO = getUserFIOByID($messages[$i]["adressee_id"]);
    }
    else
    {
      $user_id = $messages[$i]["sender_id"];
      $FIO = getUserFIOByID($messages[$i]["sender_id"]);
    }
    echo "<a href='messages.php?sel=$user_id' id='$id' class='list-group-item list-group-item-action flex-column align-items-start msg'>
      <div class='d-flex w-100 justify-content-between'>
        <h6 class='mb-1'>$FIO</h6>
        <small>$date</small>
      </div>
      <p class='mb-1 lastusermsg'>$message</p>
    </a>
    ";
    }
echo "</div>";
 ?>
