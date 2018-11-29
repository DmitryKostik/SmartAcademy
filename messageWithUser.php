<?php
echo "<h6 class='text-center'>$adressee_name</h6><div class='messages-container mt-2 ml-2'>";
for($i=0; $i<count($messages);$i++){
    $id=$messages[$i]["id_message"];
    $message = $messages[$i]["message"];
    $date = $messages[$i]["message_date"];
    if ($messages[$i]["unread"]==true) {
      $unread="<div class='msg unread'>";
    }
    else {
      $unread = "<div class='msg'>";
    }
    $FIO = getUserFIOByID($messages[$i]["sender_id"]);
    echo $unread."<div class='info'><div class='sender-name'><b>$FIO<span> $date</span></b></div><div class='msgtext mb-2'>$message</div></div></div>";
    }
    echo "</div>";
    updateUnreadStatus($_SESSION['user_id'], $sel);
?>

<form id="form-send" action="" method="post">
  <div class="input-group my-3">
      <textarea class="form-control" id="input" name="textarea" placeholder="Введите сообщение.." rows="3" cols="54"></textarea>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" name="btn_send" id="btn-send">Отправить</button>
      </div>
  </div>
</form>


<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script type="text/javascript">

function tpl(t) {
	html = ' <div class="msg unread ' + t.class +'">';
	html += '<div class="info">';
	html += '         <div class="name"><b>' + t.name + '<span> ' + t.time + '</span></b></div>';
	html += '        <div class="msgtext mb-2">'+t.text+'</div>';
	html += '</div>';
	html += '</div>';

	return html;
}

function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var year = a.getFullYear();
  var month = a.getMonth()+1;
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = year + '-' + month + '-' + date + ' ' + hour + ':' + min + ':' + sec ;
  return time;
}



$(window).load(function() {
  var div = $(".messages-container");
  div.scrollTop(div.prop('scrollHeight'));
    var socket = io.connect('http://dmitrykostik.tk:8880');

    socket.on('connect', function () {
		  var id = '<?=$sel;?>'; // ID друга


  		socket.id = id;
  		socket.emit('adduser', '<?=$_SESSION['auth'];?>', '<?=$_SESSION['user_id'];?>',id, '<?=getUserFIOByID($_SESSION['user_id']);?>');


		// Получаем сообщения
        socket.on('incMsg', function (msg) {
			// Проверка на принятия сообщения именно от того пользователя, с которым мы разговариваем в данный момент
					if(msg.userSend == id) {
						msg.text = msg.text.replace(/(\n(\r)?)/g, ' <br/>'); // Обрабатываем теккст
				// Получаем аватарку
				// Получаем сообщения
				// Шаблончик
				html = tpl(msg);

				$.when($('.messages-container').append(html))
        .done(function(){
          $('.messages-container').mousemove(function(){
            if($('.msg').hasClass('unread incoming')){
            socket.emit('readmessage',);
            $(".msg").removeClass('unread incoming');


          };
          });
        });
        var div = $(".messages-container");
        div.scrollTop(div.prop('scrollHeight'));
			}
        });

        socket.on('readAll', function(userSend) {
      // Проверка на принятия сообщения именно от того пользователя, с которым мы разговариваем в данный момент
          if(userSend == id)
          {
            $(".msg").removeClass('unread sending');
          }
        });

        // При нажатии <Enter>
				$('#input').keydown(function(event) {
			event = event || window.event;
            if(event.keyCode == 13 && !(event.shiftKey) ) {
                // Отправляем содержимое input'а, закодированное в escape-последовательность
				input = $('#input').val();

				// дата
				var newUnixDate = parseInt(new Date().getTime()/1000);
				var newDate = timeConverter(newUnixDate);

				// Шаблон
				var msg = {
				  name:  '<?=getUserFIOByID($_SESSION['user_id'])?>', // Выводим логин пользователя
				  text: input.replace(/(\n(\r)?)/g, ' <br/>'), // Текст сообщения
				  time: newDate,
          class: "sending"
				};

				// Загружаем "шаблончик" нашего сообщения
				html = tpl(msg);
				// Добавляем его
				$('.messages-container').append(html);
        var div = $(".messages-container");
        div.scrollTop(div.prop('scrollHeight'));

				// Отправляем
                socket.emit('msg', input);
                $('#input').val('');
								event.preventDefault();
							}
        });


        //При нажатии на кнопку
        $('#form-send').submit( function() {

        input = $('#input').val();

        // дата
        var newUnixDate = parseInt(new Date().getTime()/1000);
        var newDate = timeConverter(newUnixDate);

        // Шаблон
        var msg = {
          name:  '<?=getUserFIOByID($_SESSION['user_id'])?>', // Выводим логин пользователя
          text: input.replace(/(\n(\r)?)/g, ' <br/>'), // Текст сообщения
          time: newDate,
          class: "sending"
        };

        // Загружаем "шаблончик" нашего сообщения
        html = tpl(msg);
        // Добавляем его
        $('.messages-container').append(html);
        var div = $(".messages-container");
        div.scrollTop(div.prop('scrollHeight'));

        // Отправляем
                socket.emit('msg', input);
                $('#input').val('');
                return false;
        });
    });
});
</script>
