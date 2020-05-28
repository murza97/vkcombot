<?php
    require 'vendor/autoload.php';

    $owner_id = -195627083;
    $user_id = 154487657;
    $secret_id = 'aaQ13axAPQEcczQ';
    $group_id = 195627083;
    $confirmation_token = '5bfa531c';
    $application_token = '86e8d89114354ce60268a86e01fa0f9e3059f78febd1dc1218a6f3db3778031d3c15f6f8a9109760ba95e';
    $group_token = '921404a217d01772807bea0f244dde019cf3f6bd8de477eecb73da98fb636c7e49fa9a9c6490a61b40adc';

    $data = json_decode(file_get_contents('php://input'));
    
    switch ($data->type) {
        case 'confirmation':
            echo $confirmation_token;
        break;
        
        case 'wall_reply_new':
            $post_id = $data->object->post_id;

            $response = file_get_contents("https://api.vk.com/method/wall.getComments?owner_id={$owner_id}&post_id={$post_id}&access_token={$application_token}&v=5.103");
            $response = print_r($response, true);
            $request_params = array(
                'message' => "{$response}!",
                'user_id' => $user_id,
                'peer_id' => $user_id,
                'access_token' => $group_token,
                'v' => '5.107',
                'random_id' => '0'
            );
            
            $get_params = http_build_query($request_params);
            
            file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
            
            //Возвращаем "ok" серверу Callback API
            echo('ok');
        break;
    }

    file_put_contents("php://stderr", "hello, this is a test!\n");
    
?>