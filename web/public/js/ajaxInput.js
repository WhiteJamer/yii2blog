var input = $('#categoryAjaxInput'); // поле поиска
var resultsDropDown = $('#categoryAjaxResults'); // Хранилище результатов запроса
var li; // Элементы списка
var liSelected = null; // Активный элемент в списке
var form = $(input).closest('form');

// Отменяет сабмит формы при нажатии Enter
// Чтобы можно было выбрать из результатов.
input.keypress(function(e){
	if(e.keyCode == 13)
	{
		e.preventDefault();
		$(input).val($(liSelected).text());
		hideDropDown();
	}
});

// Обработка нажатия мышкой на элемент списка
resultsDropDown.on('mousedown', 'li', function(e){
	liSelected = e.target; // Элемент на который нажали
	$(input).val($(liSelected).text());
	hideDropDown();
});

// Сокрытие меню при клике в сторону.
input.focusout(function(){
	hideDropDown();
});

resultsDropDown.on('mouseover', 'li', function(e){
	if (liSelected){ $(liSelected).removeClass('selected');}
	$(e).addClass('selected');
	liSelected = e.target; // Элемент на который наведен курсор
	$(liSelected).addClass('selected'); 
});

input.on('keyup', function(e){
	li = resultsDropDown.children('li');
	
	if(e.keyCode == 38){ // upArrow
		console.log('Вверх');
		selectPrev(); // выбираем предыдущий элемент в списке
	}
	else if(e.which == 40){ // downArrow
		console.log('Вниз');
		selectNext(); // выбираем следующий элемент в списке
	}

	else if(e.which == 13){return}

	else{
		if($(this).val().length > 0)
		{
			// Подгружаем подходящие категории.
			getCategories();
			
		}
	}
});


// скрывает DropDown меню
function hideDropDown(){
	resultsDropDown.hide();
}

// показывает DropDown меню
function showDropDown(){
	resultsDropDown.empty();
	resultsDropDown.show();
}

function getCategories(){
	$.ajax({
	   type: "GET",
	   url: "/admin/article/get-categories",
	   data: {'query': input.val()},
	   success: function(items){
	   	console.log(items);
	   	resultsDropDown.empty(); // Очищаем меню
	   	showDropDown() // Показываем меню
	   	$.each(items, function(key, val){
	   		resultsDropDown.append(`<li>${val}</li>`);
	   	});
	   },
	   error: function(msg){
	   		resultsDropDown.append(`Категорий не найдено`);
	   },
	});
}

// Выбор следующего элемента в меню.
function selectNext(){
	if(!liSelected){
		liSelected = $(li).filter(':first');;
		$(liSelected).addClass('selected');
	}
	else if($(liSelected).is(':last-child')){
		$(liSelected).removeClass('selected');
		liSelected = null;
	}
	else{
		$(liSelected).removeClass('selected');
		liSelected = $(liSelected).next();
		$(liSelected).addClass('selected');
		if(liSelected == $(liSelected).is(':last')){
			liSelected.removeClass('selected');
			liSelected = null;
		}
	}
}

// Выбор предыдущего элемента в меню.
function selectPrev(){
	if(!liSelected){
		liSelected = $(li).filter(':last'); //Первый элемент в массиве из li
	}
	else if($(liSelected).is(':first-child')){
		$(liSelected).removeClass('selected');
		liSelected = null;
	}

	else{
		$(liSelected).removeClass('selected');
		liSelected = liSelected.prev();
		$(liSelected).addClass('selected');
	}
}
