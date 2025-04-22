<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $file = $_FILES['file'] ?? null;

    $errors = [];

    if(empty($name) && empty($email) && empty($message)) {
        $errors[] = "Ты совсем ничего не ввёл :(";
    }

    if(empty($name)) $errors[] = "Поле обязательно для заполнения!";
    if(empty($email)) {
        $errors[] = "Поле email обязательно!"; 
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введён неккоректный email!";
    }
    if(empty($message)) $errors[] = "Это поле обязательно для заполнения!";

    if(empty($errors)) {

        if(!is_dir('messages')) {
            mkdir('messages', 0777, true);
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message, 
            'date' => date('Y-m-d H:i:s')
        ];

        $messagefileName = 'messages/message_' . uniqid() . '.txt';
        file_put_contents($messagefileName, print_r($data, true));

        if(!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        $filePath = '';
        if($file && $file['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png'];
            if(in_array($file['type'], $allowedTypes)) {
                $imagefileName = uniqid() . '_' . $file['name'];
                move_uploaded_file($file['tmp_name'], 'uploads/' . $imagefileName);
                $filePath = 'uploads/' . $imagefileName;
            } else {
                $errors[] = "Изображение допуcкаются только в JPG и PNG формате";
            }
        }
      
        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'file' => $filePath, 
            'date' => date('Y-m-d H:i:s')
        ];
        $messagefileName = 'messages/messages_' . uniqid() . '.txt';

        file_put_contents($messagefileName, print_r($data, true));



        $success = "Форма была успешно отправлена ! Вы большой молодец!";
    }

}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма обратной связи задание 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
    <h1 class="mb-4">Форма обратной связи</h1>
    <h4 class="mb-5">Тестовое задание номер 1</h4>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($success)): ?>
        <div class="alert alert-success">
            <?= $success ?>
        </div>
    <?php endif; ?>


    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name"class="form-label">Введите имя пользователя *</label>
            <input type="text" class="form-control"id="name"name="name"required>
        </div>
        <div class="mb-3">
           <label for="email"class="form-label">Введите email *</label>
           <input type="email" class="form-control" id="email"name="email"required>
        </div>
        <div class="mb-3">
            <label for="message"class="form-label">Введите сообщнение *</label>
            <textarea class="form-control" id="message" name="message"rows="3"required></textarea>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Прикрепите изображение (не обязательно)</label>
            <input type="file" class="form-control" id="file" name="file" accept=".jpg,.jpeg,.png">
        </div>

        <button type="Submit" class="btn btn-primary">Отправить форму</button>
    </form>
        
    </div>
</body>