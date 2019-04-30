<html>
<head>
<title>Простая форма передачи AJAX JQUERY</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
</head>
<body>

<script type="text/javascript" language="javascript">
	function call() {
	var msg   = $('#formx').serialize();
		$.ajax({
			// Метод передачи
			type: 'POST',
			 // Файл которому передаем запрос и получаем ответ
			url: '/ajax_test/time.php',
			 // Кеширование
			cache: false,
			 // Верямя ожидания ответа, в мили секундах 1000 мс = 1 сек
			timeout:3000,
			data: msg,
			// Функция сработает при успешном получении данных
			success: function(data) {
				// Отображаем данные в форме
				$('#results').html(data);
			},
			// Функция срабатывает в период ожидания данных
			beforeSend: function(data) { 
				$('#results').html('<p>Ожидание данных...</p>');
			},
			 // Тип данных
			dataType:"html",
			 // Функция сработает в случае ошибки
			error:  function(data){
				$('#results').html('<p>Возникла неизвестная ошибка. Пожалуйста, попробуйте чуть позже...</p>');
				}
			});
		}
		</script>
    	
	<form method="POST" id="formx" action="javascript:void(null);" onsubmit="call()">
	<input id="url" name="url" value="" type="text">
	<input value="Проверить" type="submit">
	</form>

	<div id="results">Тут будет выведен результат</div>
</body>
</html>