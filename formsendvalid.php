<?php
    session_start();
    $d = $_POST;
    $currentPoll = $_SESSION['currentPoll'];
    $names = $_SESSION['u'];
    $nameid = "";
    for ($i=0; $i < count($names); $i++) { 
        if($names[$i]['username'] === $_SESSION['name']){
            $nameid = $names[$i]['id'];
            break;
        }
    }
    $file = file_get_contents('polls.json', true);
    $polls = json_decode($file, true);


    $num = 0;
    for ($i=0; $i < count($polls); $i++) { 
        if($polls[$i]['id'] == $currentPoll['id']){
            $num = $i;
            break;
        }
    }

    $errors = [];

    if($currentPoll['isMultiple'] == 0 && (count($d) > 1 || count($d) === 0)) {
        $errors['checkbox'] = 'You must choose precisely one option!';
    }
    elseif($currentPoll['isMultiple'] == 1 && count($d) === 0) {
        $errors['checkbox'] = 'You must choose at least one option!';
    }


    $success = false;
    if(count($errors) === 0) {
        for ($i=0; $i < count($d)+1; $i++) { 
            if(in_array($nameid,$polls[$num]['voted'])){
                $errors['sentbefore'] = "You have already voted in this poll!";
                break;
            }
            if(isset($d[$i]) && !in_array($nameid,$polls[$num]['voted']) ){
                $currentsum = $polls[$num]['answers'][$i][$currentPoll['options'][$i]] += 1;
                $polls[$num]['answers'][$i][$currentPoll['options'][$i]] = strval($currentsum);
                $success = true;
                
            } 
        }
    } else echo "Error"; 
    if($success){
        array_push($polls[$num]['voted'], $nameid);
        $new_json = json_encode($polls, JSON_PRETTY_PRINT);
        file_put_contents('polls.json', $new_json);
        $_SESSION['p'] = $polls;
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
    <title>Form send validation</title>
    <script type="text/javascript">
        function sendForm() {
            document.querySelector("#f").submit();
        }
    </script>
</head>
<body>
    <?php if(count($errors) > 0): ?>
        <p>Sikertelen beküldés 👎🏻</p>
        <?php if(isset($errors['sentbefore'])): ?>
            <form autocomplete="off" novalidate id="f" action="index.php" method="post" style="display: none;">
            <input type="text" name="user" value="<?=$_SESSION['name']?>">
            <input type="password" name="pw" value="<?=$_SESSION['pw']?>">
            </form>
            <a onclick="sendForm()">Vissza a főoldalra</a>
        <?php else: ?>
            <a href="vote.php?id=<?= $currentPoll['id'] ?>">Új próbálkozás</a>
        <?php endif; ?>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif(count($errors) === 0): ?>
        <p>Sikeres beküldés 👍🏻</p>
        <form autocomplete="off" novalidate id="f" action="index.php" method="post" style="display: none;">
        <input type="text" name="user" value="<?=$_SESSION['name']?>">
        <input type="password" name="pw" value="<?=$_SESSION['pw']?>">
        </form>
        <a onclick="sendForm()">Vissza a főoldalra</a>
    <?php endif; ?>
    
</body>
</html>