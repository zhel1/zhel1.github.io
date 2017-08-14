<?php

if (!isset($_REQUEST)) {
    return;
}

//������ ��� ������������� ������ ������� �� �������� Callback API
$confirmationToken = '4ac6eb71';

//���� ������� ����������
$token = 'fa951c328f76c1d0f6076f34284b428a8a64b84438758c4cbaa9c17f46250905632a0abaf0bd60adc4b92';

// Secret key
$secretKey = 'g3H37Lgf53g7ebkdq3';

//�������� � ���������� �����������
$data = json_decode(file_get_contents('php://input'));

// ��������� secretKey
if (strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
    return;

//���������, ��� ��������� � ���� "type"
switch ($data->type) {
    //���� ��� ����������� ��� ������������� ������ �������...
    case 'confirmation':
        //...���������� ������ ��� ������������� ������
        echo $confirmationToken;
        break;

    //���� ��� ����������� � ����� ���������...
    case 'message_new':
        //...�������� id ��� ������
        $userId = $data->object->user_id;
        //����� � ������� users.get �������� ������ �� ������
        $userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&v=5.0"));

        //� ��������� �� ������ ��� ���
        $user_name = $userInfo->response[0]->first_name;

        //� ������� messages.send � ������ ���������� ���������� �������� ���������
        $request_params = array(
            'message' => "{$user_name}, ���� ��������� ����������������!<br>" .
                "�� ����������� �������� � ��������� �����.",
            'user_id' => $userId,
            'access_token' => $token,
            'v' => '5.0'
        );

        $get_params = http_build_query($request_params);

        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);

        //���������� "ok" ������� Callback API
        echo('ok');

        break;

    // ���� ��� ����������� � ���������� � ������
    case 'group_join':
        //...�������� id ������ ���������
        $userId = $data->object->user_id;

        //����� � ������� users.get �������� ������ �� ������
        $userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&v=5.0"));

        //� ��������� �� ������ ��� ���
        $user_name = $userInfo->response[0]->first_name;

        //� ������� messages.send � ������ ���������� ���������� �������� ���������
        $request_params = array(
            'message' => "����� ���������� � ���� ���������� ���� ��. ������� ��5 2016, {$user_name}!<br>" .
                "���� � ��� ��������� �������, �� �� ������ ������ ���������� � ��������������� ����������.<br>" .
                "�� �������� ����� ����� � �������������� ������� ������.<br>" .
                "������� � �����!",
            'user_id' => $userId,
            'access_token' => $token,
            'v' => '5.0'
        );

        $get_params = http_build_query($request_params);

        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);

        //���������� "ok" ������� Callback API
        echo('ok');

        break;

    // ���� ��� ����������� � ������ �� ������
    case 'group_leave':
        //...�������� id �������� ���������
        $userId = $data->object->user_id;

        //����� � ������� users.get �������� ������ �� ������
        $userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&v=5.0"));

        //� ��������� �� ������ ��� ���
        $user_name = $userInfo->response[0]->first_name;

        //� ������� messages.send � ������ ���������� ���������� �������� ���������
        $request_params = array(
            'message' => "{$user_name}, ��� ����� ���� ��������� � ���� ??<br>" .
                "�� ������ ����� ����� ��� � ����� ������ ��������.<br>" .
                "���� �������� ������� - ��������� � ��������������� ����������<br>" .
                "���������� - https://vk.com/kulakovkostya",
            'user_id' => $userId,
            'access_token' => $token,
            'v' => '5.0'
        );

        $get_params = http_build_query($request_params);

        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);

        //���������� "ok" ������� Callback API
        echo('ok');

        break;
}
?>