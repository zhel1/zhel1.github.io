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
//Получаем и декодируем уведомление 
$data = json_decode(file_get_contents('php://input')); 

//Проверяем, что находится в поле "type" 
switch ($data->type) { 
  //Если это уведомление для подтверждения адреса... 
  case 'confirmation': 
    //...отправляем строку для подтверждения 
    echo $confirmation_token; 
    break; 

//Если это уведомление о новом сообщении... 
  case 'message_new': 
    //...получаем id его автора 
    $user_id = $data->object->user_id; 
    //затем с помощью users.get получаем данные об авторе 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 

//и извлекаем из ответа его имя 
    $user_name = $user_info->response[0]->first_name; 

//С помощью messages.send отправляем ответное сообщение 
    $request_params = array( 
      'message' => "Hello, {$user_name}!", 
      'user_id' => $user_id, 
      'access_token' => $token, 
      'v' => '5.0' 
    ); 

$get_params = http_build_query($request_params); 

file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 

//Возвращаем "ok" серверу Callback API 

echo('ok'); 

break; 

} 
?> 
