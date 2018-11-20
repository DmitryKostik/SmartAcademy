<?php
for($i=0; $i<count($messages);$i++){
    $id=$messages[$i]["id_message"];
    $message = $messages[$i]["message"];
    $date = $messages[$i]["message_date"];
    $FIO = getUserFIOByID($messages[$i]["sender_id"]);
    echo "
    <div class='mt-2 ml-2'>
    <b>$FIO</b><span> $date</span><br>$message
    </div>
    ";
    }
?>
<form class="" action="" method="post">
  <div class="input-group my-3">
    <textarea type="text" name="message" class="form-control" placeholder="Введите сообщение" rows="1" aria-label="Recipient's username" aria-describedby="button-addon2"></textarea>
    <div class="input-group-append">
      <input class="btn btn-outline-secondary" name="send_message" type="submit" id="button-addon2"></button>
    </div>
  </div>
</form>
