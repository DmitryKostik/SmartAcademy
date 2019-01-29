var http = require('http');
var mysql = require('mysql');

var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '0000',
  database : 'smartacademy',
});

// Прописываем порт для сервера
var io = require('socket.io').listen(8880);

// Функия, если все ок и мы прдключились
io.on('connection', function (socket) {
	// Символы => html
	function escapeHtml(str) {
	  return String(str)
		  .replace(/&/g, "&")
		  .replace(/</g, "<")
		  .replace(/>/g, ">")
		   .replace(/\//g, "⁄");
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

	// Что делать, если пользователь подключился, узнаем он или нет и т.д
	socket.on('adduser', function(auth,sender_id, adressee_id, adressee_name){
		if(auth==true)
    {
				socket.userGet = adressee_id;
				socket.userSend = sender_id;

				// Лог, чисто для себя, чтобы примерно понимать что происходить
				console.log('Пользователь подключен id: '+socket.userSend);
				socket.join(socket.userSend);

				// Мое имя.
				socket.user = adressee_name;
			}
	});

	// Функция отправки сообщений
	// msg - текст сообщения
	socket.on('msg', function(msg) {
		// htmlencode
		msg = escapeHtml(msg);

		// Unixtime
		unix_time = parseInt(new Date().getTime()/1000);
		var post  = {sender_id: socket.userSend, adressee_id: socket.userGet, message: msg};
		query = connection.query('INSERT INTO messages SET ?', post, function(err, result) {
		});

    console.log("---------Отправка сообщения---------");
		console.log('Отправитель:  ' +socket.userSend +'  Получатель:  ' + socket.userGet);
    console.log("Текст сообщения: " + msg);
    console.log("------------------------------------")
		 socket.broadcast.to(socket.userGet).json.emit('incMsg',{'userSend': socket.userSend, 'name': socket.user, 'text': msg, 'time': timeConverter(unix_time), 'class': "incoming" })
    });

    socket.on('readmessage', function(){
      query = connection.query('UPDATE messages SET unread=0 WHERE adressee_id=' + socket.userSend + ' AND sender_id='+ socket.userGet, function (error, results, fields) {
        if (error) throw error;
        console.log("Пользователь id="+socket.userSend+" прочитал сообщения пользователя id="+socket.userGet);
        console.log('Затронуто ' + results.changedRows + ' строк: adressee_id=' + socket.userGet + ' AND sender_id='+ socket.userSend);
        socket.broadcast.to(socket.userGet).emit('readAll', socket.userSend);
      });
    });
});
