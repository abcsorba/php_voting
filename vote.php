<?php
    session_start();
    $p = $_SESSION['p'];
    $id = $_GET['id'];
    $currentPoll = $p[1];
    for ($i=0; $i < count($p); $i++) { 
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
    <title>Vote!</title>
</head>
<body>
        <h1>Kérdés: <?= $currentPoll['question'] ?></h1>
        <?= $currentPoll['isMultiple'] === '0' ?  '<h2>Válasszon pontosan egyet!</h2>' : ''?>
        <!-- <form method="post" action="formsendvalid.php?id=<?= $id ?>" novalidate> -->
        <form method="post" action="formsendvalid.php" novalidate>
                <?php for ($i=0; $i < count($currentPoll['options']) ; $i++): ?>
                    <!-- <input type="checkbox" name="<?= $currentPoll['options'][$i]?>"> -->
                    <input type="checkbox" name="<?= $i ?>">
                    <label><?= $currentPoll['options'][$i]?></label>
                    <br>
                <?php endfor; ?>
            <input type="submit" value="Küldés">
        </form>
</body>
</html>