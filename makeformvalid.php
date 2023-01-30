<?php 
    session_start();
    
    $file = file_get_contents('polls.json', true);
    $polls = json_decode($file, true);
    
    //with regex find maximum number after poll and add 1 to it
    $id = 0;
    foreach($polls as $poll){
        if(preg_match('/\d+/', $poll['id'], $matches)){
            if($matches[0] > $id){
                $id = $matches[0];
            }
        }
    }
    $id = "poll".($id+1);

    $data = $_POST;

    $errors = [];
    $correctdata = "?";
    $options = [];
    $answersObj = [];
    if(!isset($data['question']) || empty($data['question'])){
        $errors['question'] = 'A question is required';
    } else {
        $correctdata .= "question=" . $data['question'] . "&";
    }
    $numofoptions = 0;
    if(isset($data['1']) && !empty($data['1'])){
        $numofoptions++;
        $correctdata .= "1=" . $data['1'] . "&";
        array_push($options, strval($data['1'])) ;
        $obj = [
            strval($data['1']) => "0"
        ];
        array_push($answersObj, $obj);
    }
    if(isset($data['2']) && !empty($data['2'])){
        $numofoptions++;
        $correctdata .= "2=" . $data['2'] . "&";
        array_push($options, strval($data['2'])) ;
        $obj = [
            strval($data['2']) => "0"
        ];
        array_push($answersObj, $obj);
    }
    if(isset($data['3']) && !empty($data['3'])){
        $numofoptions++;
        $correctdata .= "3=" . $data['3'] . "&";
        array_push($options, strval($data['3'])) ;
        $obj = [
            strval($data['3']) => "0"
        ];
        array_push($answersObj, $obj);
    }
    if(isset($data['4']) && !empty($data['4'])){
        $numofoptions++;
        $correctdata .= "4=" . $data['4'] . "&";
        array_push($options, strval($data['4'])) ;
        $obj = [
            strval($data['4']) => "0"
        ];
        array_push($answersObj, $obj);
    }
    if(isset($data['5']) && !empty($data['5'])){
        $numofoptions++;
        $correctdata .= "5=" . $data['5'] . "&";
        array_push($options, strval($data['5'])) ;
        $obj = [
            strval($data['5']) => "0"
        ];
        array_push($answersObj, $obj);
    }
    if(!isset($data['ismultiple']) && $numofoptions != 2 ){
        $errors['ismultiple'] = 'You must provide precisely 2 answers';
    }
    if(isset($data['ismultiple']) && $numofoptions < 2){
        $errors['ismultiple'] = 'You must provide 2 or more answers';
    }
    if(!isset($data['deadline']) || empty($data['deadline']) || $data['deadline'] < date('Y-m-d')){
        $errors['deadline'] = 'A correct deadline is required';
    } else {
        $correctdata .= "deadline=" . $data['deadline'] . "&";
    }

    if(count($errors) === 0){
        $new = [
            'id' => $id,
            'question' => $data['question'],
            'options' => $options,
            'isMultiple' => isset($data['ismultiple']) ? "1" : "0",
            'createdAt' => date('Y-m-d'),
            'deadline' => $data['deadline'],
            'answers' => $answersObj,
            'voted' => []

        ];

        array_push($polls, $new);
        $new_json = json_encode($polls, JSON_PRETTY_PRINT);
        file_put_contents('polls.json', $new_json);
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
    <title>Poll making validation</title>
    <script type="text/javascript">
        function sendForm() {
            document.querySelector("#f").submit();
        }
    </script>
</head>
<body>
<?php if(count($errors) > 0): ?>
        <p>Az űrlap hibákat tartalmaz 👎🏻</p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="makeform.php<?= strlen($correctdata) !== 1 ? $correctdata : '' ?>">Vissza az űrlaphoz</a>
    <?php elseif(count($errors) === 0): ?>
        <p>Sikeresen létrehoztad az űrlapot 👍🏻</p>
        <form autocomplete="off" novalidate id="f" action="index.php" method="post" style="display: none;">
        <input type="text" name="user" value="<?=$_SESSION['name']?>">
        <input type="password" name="pw" value="<?=$_SESSION['pw']?>">
        </form>
        <a onclick="sendForm()">Vissza a főoldalra</a>
    <?php endif; ?>
</body>
</html>