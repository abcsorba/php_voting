<?php
    $_SESSION = [];
    session_start();

    $loggedout = false;
    if(isset($_GET['logged']) && $_GET['logged'] === "false") {
        $loggedout = true;
    }
    if(isset($_SESSION['p'])){
        $p = $_SESSION['p'];
    } else {
        $file = file_get_contents('polls.json', true);
        $p = json_decode($file, true);
        $_SESSION['p'] = $p;
    }
    $id = $_GET['id'];
    $currentPoll = $p[1];
    for ($i=1; $i < count($p)+1; $i++) { 
        if($p[$i]['id'] === $id) {
            $currentPoll = $p[$i];
            $_SESSION['currentPoll'] = $currentPoll;
            break;
        } 
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
    <title>Result</title>
    <script type="text/javascript">
        function sendForm() {
            document.querySelector("#f").submit();
        }
    </script>
</head>
<body>
    <h1>Az űrlap eredménye</h1>
    <h2><?= $currentPoll['question'] ?></h2>
    <ul>
        <?php for ($i=0; $i < count($currentPoll['options']) ; $i++): ?>
            <li><?= $currentPoll['options'][$i]?>: <?= $currentPoll['answers'][$i][$currentPoll['options'][$i]] ?></li>
        <?php endfor; ?>
    </ul>
    <form autocomplete="off" novalidate id="f" action="index.php" method="post" style="display: none;">
    <input type="text" name="user" value="<?= isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>">
    <input type="password" name="pw" value="<?= isset($_SESSION['pw']) ? $_SESSION['pw'] : '' ?>">
    </form>
    <?php if(!$loggedout): ?>
        <a onclick="sendForm()">Vissza a főoldalra</a>
    <?php else: ?>
        <a href="index.php">Vissza a főoldalra</a>
    <?php endif; ?>


</body>
</html>