<?php
    $file = file_get_contents('polls.json', true);
    $polls = json_decode($file, true);

    //sorting polls by date
    function datesort($first,$second){
        if(strtolower($first['createdAt']) < strtolower($second['createdAt'])) return 1;
        else if (strtolower($first['createdAt']) == strtolower($second['createdAt'])) return 0;
        else return -1;
    };
    usort($polls, "datesort");

    $file2 = file_get_contents('users.json', true);
    $users = json_decode($file2, true);


    $logged = false;
    if(isset($_GET['logout']) && $_GET['logout'] === "true"){
        $_SESSION = [];
        $logged = false;
    } 

    //checking if user is registered
    function checkIfUserIsRegistered($username, $password){
        global $users;
        foreach($users as $user){
            if($user['username'] === $username && $user['password'] === $password) return true;
        }
        return false;
    }
    //checking if user is admin
    function checkIfAdmin($username){
        global $users;
        foreach($users as $user){
            if($user['username'] === $username && $user['isAdmin'] == 1) return true;
        }
        return false;
    }
    
    $admin = false;
    
    //logging in user
    $success = true;
    $nameid = "";
    if(isset($_POST['user']) && isset($_POST['pw']) && checkIfUserIsRegistered($_POST['user'], $_POST['pw'])){
        session_start();
        $_SESSION['name'] = $_POST['user'];
        $_SESSION['pw'] = $_POST['pw'];
        $_SESSION['p'] = $polls;
        $_SESSION['u'] = $users;$names = $_SESSION['u'];
        for ($i=0; $i < count($names); $i++) { 
            if($names[$i]['username'] === $_SESSION['name']){
                $nameid = $names[$i]['id'];
                break;
            }
        }
        $logged = true;
    } else {
        if(isset($_POST['user']) && strlen($_POST['user']) != 0 )
        $success = false;
    }

    //turning on admin privileges
    if(isset($_SESSION['name']) && checkIfAdmin($_SESSION['name'])) {
        $admin = true;
        $_SESSION['admin'] = true;
    } else {
        $_SESSION['admin'] = false;
        $admin = false;
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
    <title>Szavazz!</title>
</head>
<body>
    
    <?php if($logged): ?> 
        <h1>Szavazz, <?php echo $_SESSION['name']; ?>!</h1>
    <?php else: ?>
        <h1>Szavazz!</h1>
        <?= !$success ? '<h1>Sikertelen bejelentkezes</h1>' : '' ?>
    <?php endif; ?>
    <h2>Ezen az oldalon különböző kérdőívekre adhatod le a szavazataidat. Lentebb láthatod a még aktív, illetve lejárt szavazólapokat. Nézz körül! A szavazáshoz viszont, ne felejts el bejelentkezni!</h2>
    <div>
        <?php if($logged): ?>
            <a href="index.php?logout=true">Kijelentkezés</a>
        <?php else: ?>
            <a href="login.php">Bejelentkezés</a>
            <a href="registration.php">Regisztráció</a>
        <?php endif; ?>
        <?php if($admin): ?>
            <a href="makeform.php">Űrlap készítése</a>
        <?php endif; ?>
    </div>
    <h3>Szavazólapok</h3>
    
    <h4>Aktív</h4>
    <?php foreach($polls as $p): ?>
        <?php if($p['deadline'] >= date('Y-m-d')): ?>
            <div class="votediv">
                <div class="data">ID: <?= $p['id'] ?></div>
                <div class="data">Created at: <?= $p['createdAt'] ?></div>
                <div class="data">Deadline: <?= $p['deadline'] ?></div>
                <?php if($logged): ?>
                    <?php if($admin): ?>
                        <a href="delete.php?id=<?= $p['id'] ?>" id="<?= $p['id'] ?>" >Töröl</a>
                    <?php endif; ?>
                    <?php if(in_array($nameid, $p['voted'])): ?>
                        <a style="cursor: default; color: green;">Szavazat leadva</a>
                    <?php else: ?>
                        <a href="vote.php?id=<?= $p['id'] ?>" id="<?= $p['id'] ?>" >Szavaz</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="login.php" >Szavaz</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <h4>Lejárt</h4>
    <?php foreach($polls as $p): ?>
        <?php if($p['deadline'] < date('Y-m-d')): ?>
            <div class="votediv">
                <div class="data">ID: <?= $p['id'] ?></div>
                <div class="data">Created at: <?= $p['createdAt'] ?></div>
                <div class="data">Deadline: <?= $p['deadline'] ?></div>
                <?php if($logged): ?>
                    <?php if($admin): ?>
                        <a href="delete.php?id=<?= $p['id'] ?>" id="<?= $p['id'] ?>" >Töröl</a>
                    <?php endif; ?>
                    <!-- <a href="vote.php?id=<?= $p['id'] ?>" id="<?= $p['id'] ?>" >Szavaz</a> -->
                <?php else: ?>
                    <!-- <a href="login.php" >Szavaz</a> -->
                <?php endif; ?>
                <a href="result.php?id=<?= $p['id'] ?><?= $logged ? '' : "&logged=false" ?>">Eredmény megtekintése</a>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</body> 
</html>