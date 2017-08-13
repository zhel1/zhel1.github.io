<?php
if (!isset($_REQUEST)) {
    return;
}
//Строка для подтверждения адреса сервера из настроек Callback API 
$confirmation_token = '4ac6eb71'; 
//Ключ доступа сообщества 
$token = 'fa951c328f76c1d0f6076f34284b428a8a64b84438758c4cbaa9c17f46250905632a0abaf0bd60adc4b92'; 
// Secret key
$secretKey = '551373455bobr';
//Получаем и декодируем уведомление
$data = json_decode(file_get_contents('php://input'));
// проверяем secretKey
if (strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
    return;
//Проверяем, что находится в поле "type"
switch ($data->type) {
    //Если это уведомление для подтверждения адреса сервера...
    case 'confirmation':
        //...отправляем строку для подтверждения адреса
        echo $confirmationToken;
        break;
    
 
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        //Возвращаем "ok" серверу Callback API
        echo('ok');
        break;
}
