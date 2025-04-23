<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сумма чисел</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .result-container {
            min-height: calc(100vh - 200px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mt-5 mb-4">Сумма чисел кратных трём или пяти</h1>
    
    <div class="result-container">
        <?php
        $summa = 0;
        
        for($i = 1; $i < 1000; $i++) {
            if($i % 3 === 0 || $i % 5 === 0) {
                $summa += $i;
            }
        }
        
        echo '<div class="alert alert-primary text-center fs-4" style="width: 100%; max-width: 600px;">';
        echo "Сумма чисел меньше 1000, кратных 3 или 5: <strong>$summa</strong>";
        echo '</div>';
        ?>
    </div>
</div>
</body>
</html>