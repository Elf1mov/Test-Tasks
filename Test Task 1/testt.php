<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $file = $_FILES['file'] ?? null;

    $errors = [];

    if (empty($name) && empty($email) && empty($message)) {
        $errors[] = 'Ты совсем ничего не ввёл :(';
    }

    if (empty($name)) {
        $errors[] = 'Поле обязательно для заполнения!';
    }

    if (empty($email)) {
        $errors[] = 'Поле email обязательно!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Введён некорректный email!';
    }

    if (empty($message)) {
        $errors[] = 'Это поле обязательно для заполнения!';
    }

    if (empty($errors)) {
        if (!is_dir('messages')) {
            mkdir('messages', 0777, true);
        }

        $data = [
            'name'    => $name,
            'email'   => $email,
            'message' => $message,
            'date'    => date('Y-m-d H:i:s'),
        ];

        $messagefileName = 'messages/message_' . uniqid() . '.txt';
        file_put_contents($messagefileName, print_r($data, true));

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        $filePath = '';

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png'];

            if (in_array($file['type'], $allowedTypes)) {
                $imagefileName = uniqid() . '_' . $file['name'];
                move_uploaded_file($file['tmp_name'], 'uploads/' . $imagefileName);
                $filePath = 'uploads/' . $imagefileName;
            } else {
                $errors[] = 'Изображения допускаются только в JPG и PNG формате.';
            }
        }

        $data = [
            'name'    => $name,
            'email'   => $email,
            'message' => $message,
            'file'    => $filePath,
            'date'    => date('Y-m-d H:i:s'),
        ];

        $messagefileName = 'messages/messages_' . uniqid() . '.txt';
        file_put_contents($messagefileName, print_r($data, true));

        $success = 'Форма была успешно отправлена! Вы большой молодец!';
    }
}
?>
