<?php
$requestedPath = explode('?', $_SERVER['REQUEST_URI'])[0];
$filePath = __DIR__ . '/mess.json';
$login = $_GET['login'];
$password = $_GET['password'];
$message = $_GET['message'];

    if (!empty($login) && !empty($password) && !empty($message))
    {
        $users = json_decode(file_get_contents(__DIR__ . "/users.json"), true);
        $input_password = $users[$login];

         if ($input_password === $password && $input_password === $login )
        {
            $json_message =
                [
                    "date" => date("Y-m-d h:i",time()),
                    "login" => $login,
                    "message" => $message
                ];
            LoadMessageToFile($json_message, $filePath);
        }
        else
        {
            echo("Ошибка ввода логина или пароля");
        }

    }

function LoadMessageToFile($json_message, $filePath)
{
    $messages_file = json_decode(file_get_contents($filePath));
    $messages_file->messages[] = $json_message;
    file_put_contents($filePath, json_encode($messages_file));
    header('Location: /'); 

}

    $messages_file = json_decode(file_get_contents($filePath));
    foreach($messages_file->messages as $message)
    {
        echo "<p>$message->date $message->login: $message->message</p>";
    }

?>



<form action="/messenger/" method="GET">
    <input name="login", placeholder="Логин">
    <input name="password", placeholder="Пароль">
    <input name="message", placeholder="Сообщение">
    <button>Отправить сообщение</button>
</form>
