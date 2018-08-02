<?php

    $response = ""; // сообщения формы
    $errors = array(); // контейнер для ошибок

    // проверяем корректность полей
    if($_POST['name'] == "")    $errors[] = "Поле 'Ваше имя' не заполнено!";
    if($_POST['email'] == "")   $errors[] = "Поле 'Ваш e-mail' не заполнено!";
    if($_POST['phone'] == "")   $errors[] = "Поле 'Ваш телефон' не заполнено!";
    if($_POST['message'] == "") $errors[] = "Поле 'Текст пиьсма' не заполнено!";

    // проверяем валидность e-mail
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Поле 'Ваш e-mail' заполнено не верно!";
    }

    // проверяем валидность телефона
    $re = '~^(?:\+7|8)\d{10}$~';
    if (!preg_match($re, $_POST['phone'])) {
        $errors[] = "Поле 'Ваш телефон' заполнено не верно!";
    }
 
    // если форма без ошибок
    if(empty($errors)){

        // собираем данные из формы
        $message  = "Имя пользователя: " . $_POST['name'] . "<br/>";
        $message .= "E-mail пользователя: " . $_POST['email'] . "<br/>";
        $message .= "Телефон пользователя: " . $_POST['phone'] . "<br/>";
        $message .= "Текст письма: " . $_POST['message'];    

        send_mail($message); // отправим письмо

        // выведем сообщение об успехе
        $response = "<span style='color: green;'>Мы приняли Ваше сообщение и скоро перезвоним!</span>";

    }else{

        // если были ошибки, то выводим их
        $response = "";

        foreach($errors as $one_error){
            $response .= "<span style='color: red;'>$one_error</span><br/>";
        }
    }
 
    // делаем ответ на клиентскую часть в формате JSON
    echo json_encode(array(
        'result' => $response
    ));
     
     
    // функция отправки письма
    function send_mail($message){

        // почта, на которую придет письмо
        $mail_to = "mail@gmail.com"; 
        // тема письма
        $subject = "Mail from site";
         
        // заголовок письма
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
        $headers .= "From: New message <mail@site.ru>\r\n"; // от кого письмо
         
        // отправляем письмо 
        mail($mail_to, $subject, $message, $headers);
    }
     
?>