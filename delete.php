<?php
    session_start();
    $success;
    if($_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
        $success = false;
    } else {
        $polls = $_SESSION['p'];
        for ($i=0; $i < count($polls); $i++) { 
            if($polls[$i]['id'] == $_GET['id']){
                unset($polls[$i]);
            }
        }
        $polls = array_values($polls);
        $new_json = json_encode($polls, JSON_PRETTY_PRINT);
        file_put_contents('polls.json', $new_json);
        $_SESSION['p'] = $polls;
        $success = true;
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
    <title>Delete from</title>
    <script type="text/javascript">
        function sendForm() {
            document.querySelector("#f").submit();
        }
    </script>
</head>
<body>
    <?php if($success): ?>
        <p>Sikeresen törölted az űrlapot 👍🏻</p>
        <form autocomplete="off" novalidate id="f" action="index.php" method="post" style="display: none;">
            <input type="text" name="user" value="<?=$_SESSION['name']?>">
            <input type="password" name="pw" value="<?=$_SESSION['pw']?>">
        </form>
        <a onclick="sendForm()">Vissza a főoldalra</a>
        
    <?php else: ?>
        <p>Nem vagy jogosult erre a műveletre! 👎🏻</p>
    <?php endif; ?>

</body>
</html>