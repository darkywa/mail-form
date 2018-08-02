/* author Darkywa https://github.com/darkywa/ */
$(document).ready(function(){

	// отправляем форму
	$("#write-us-form").submit(function(e) {
		e.preventDefault();

        let str = $(this).serialize(),
        	fieldset = $(this).find('fieldset'),
        	responseBox = $('#response');


		$.ajax({
	        method: "POST",
	        url: 'php/contact.php',
	        dataType: "json",
	        data: str,
	        beforeSend: function() {
	            fieldset.attr('disabled', 'disabled');
	            responseBox.html('Обработка запроса...');
	        },
	        success: function(response) {
	            fieldset.removeAttr('disabled');
	            responseBox.html(response.result);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            if (jqXHR.status == 500) {
	                alert('Ошибка сервера: ' + jqXHR.responseText);
	                responseBox.empty();
	                fieldset.removeAttr('disabled');
	            } else {
	                alert('Неизвестная ошибка.');
	                responseBox.empty();
	                fieldset.removeAttr('disabled');
	            }
	        }
	    })
	    return false;

	});
});