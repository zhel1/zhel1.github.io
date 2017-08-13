$confirmation_token = "4ac6eb71"; // Строка, которую должен вернуть сервер.
$data = json_decode(file_get_contents('php://input'));
$conf = $data->{'type'};
if($conf == "confirmation")
{
echo "$confirmation_token"; 
}
