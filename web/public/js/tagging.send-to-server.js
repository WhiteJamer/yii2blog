var tags;
var data = [];
var form = $('form');
var tagBox = $('#tagBox'); 
var sended = true; 


tagBox.tagging(); // Инициализируем Tagging.
tagBox.tagging('add', currentTags); // Добавляем в поле теги если они указаны
	
	// Захватываем событие submit у формы
	form.submit(function(e){
		// Останавливаем отправку формы
		e.preventDefault();
	    // решает проверку с двойным submit
	    e.stopImmediatePropagation();

	    // Защита от многократного Ajax-запроса.
		if(sended !== false)
		{
			tags = $('input[name=tagItem]');
			/*	
				Добавляем заданные пользователем теги
				в массив data, который потом отправим на сервер.
			*/ 
			tags.each(function(){
				data.push($(this).val());
			});

			console.log('Теги которые были отправлены на обработку');
			console.log(data);
			/*	Отправляем данные из скрытого поля 'select'
				данные о выбранных тегах.
				В ответе получаем массив из ID категорий.
			*/
			$.ajax({
			   type: "POST",
			   url: "/admin/article/send-tags",
			   data: {'data': data},
			   success: function(response){
			     console.log( "Данные успешно сохранены: " + response );

			     var tagsSelect = $('select[name="tags[]"]');
			     // Очищаем скрытое поле селект, на всякий случай.
				 tagsSelect.find('option').remove(); 
				 /*
				 	Заполняем скрытое поле 'select'
				 	полученными ID тегов.
				 */
				 for(var key in response){
				 	tagsSelect.append(`<option value=${response[key]} selected>${response[key]}</option>`);
				 }

				 console.log('ID тегов');
				 console.log(response);

				 sended = false; // Отключаем возможность отправить ajax запрос снова.
				 /* 
				 	Если все прошло успешно отправляем форму
				 	с заполненными данными
				 */
			   	 form.off('submit').submit();


			   },
			   error: function(msg){
			   	console.log( "Данные не отправлены, сохраняем без тегов: " + msg );
			    form.off('submit').submit();
			   },
			});

		}

	});