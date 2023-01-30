<?php
   session_start();
   if(isset($_SESSION['admin'])) {
    $isadmin = $_SESSION['admin']; 
   } else {
    $isadmin = false;
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
    <title>Make a poll</title>
</head>
<body>
    <?php if ($isadmin === true): ?>
        <h1>Űrlap készítése</h1>
        <form action="makeformvalid.php" method="post" novalidate autocomplete="off" >
            <label for="question">Kérdés</label> <br>
            <textarea name="question" cols="50" rows="5"><?= isset($_GET['question']) ? $_GET['question'] : ''?></textarea> <br>
            <label for="ismultiple">Több választási lehetőség megadható-e?</label> <br>
            <input type="checkbox" name="ismultiple" id="ismultiple"> <br>
            <label >Lehetséges válaszok:</label> <br>
            <input type="text" name="1" id="" value="<?= isset($_GET['1']) ? $_GET['1'] : ''?>"> <br>
            <input type="text" name="2" id="" value="<?= isset($_GET['2']) ? $_GET['2'] : ''?>"> <br>
            <input type="text" name="3" id="" value="<?= isset($_GET['3']) ? $_GET['3'] : ''?>"> <br>
            <input type="text" name="4" id="" value="<?= isset($_GET['4']) ? $_GET['4'] : ''?>"> <br>
            <input type="text" name="5" id="" value="<?= isset($_GET['5']) ? $_GET['5'] : ''?>"> <br>
            <label for="deadline">Határidő</label> <br>
            <input type="date" name="deadline" id="" value="<?= isset($_GET['deadline']) ? $_GET['deadline'] : ''?>"> <br>
            <input type="submit" value="Küldés">



        </form>
    <?php else: ?>
        <h1>Ehhez az oldalhoz csak az adminok férnek hozzá!</h1>
        <a href="index.php">Vissza a főoldara</a>
    <?php endif; ?>
    
</body>
</html>