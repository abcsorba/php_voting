<?php
    $d = $_POST;
    session_start();
    if(isset($_SESSION['u'])){
        $id = "userid".count($_SESSION['u'])+1;
    } else {
        $file = file_get_contents('users.json', true);
        $users = json_decode($file, true);
        $_SESSION['u'] = $users;
        $id = "userid".count($users)+1;
    }
    
    $errors = [];
    $names = $_SESSION['u'];
    for ($i=0; $i < count($names); $i++) { 
        if($names[$i]['username'] === $d['user'] || $names[$i]['email'] === $d['email']){
            $errors['registered'] = 'You are already registered!';
            break;
        }
    }
    
    $correctdata = "?";
    if(!isset($d['user']) || $d['user'] === '') {
        $errors['user'] = 'Username is required';
    } else $correctdata.="user=".$d['user']."&";
    if(!isset($d['email']) || $d['email'] === '' || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'A valid email address is required';
    } else $correctdata.="email=".$d['email'];
    if(!isset($d['pw']) || $d['pw'] === '' || !isset($d['pw2']) || $d['pw2'] === '' || $d['pw'] !== $d['pw2']) {
        $errors['pw'] = 'Valid passwords that match are required';
    }


    if(count($errors) === 0){
        $file = file_get_contents('users.json', true);
        $users = json_decode($file, true);

        $new = [
            'id' => $id,
            'username' => $d['user'],
            'email' => $d['email'],
            'password' => $d['pw'],
            'isAdmin' => "0",
        ];

        array_push($users, $new);
        $new_json = json_encode($users, JSON_PRETTY_PRINT);
        file_put_contents('users.json', $new_json);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/elte-fi/www-assets@19.10.16/styles/mdss.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Registration validation</title>
</head>
<body>
    <?php if(count($errors) > 0): ?>
        <p>Sikertelen regisztráció 👎🏻</p>
        <a href="registration.php<?= strlen($correctdata) !== 1 ? $correctdata : '' ?>">Új próbálkozás</a>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif(count($errors) === 0): ?>
        <p>Sikeres regisztráció 👍🏻</p>
        <a href="index.php">Vissza a főoldalra</a>
    <?php endif; ?>
</body>
</html>