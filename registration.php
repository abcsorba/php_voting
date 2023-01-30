<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/elte-fi/www-assets@19.10.16/styles/mdss.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Registration</title>
</head>
<body>
    <h1>Regisztráció</h1>
    <form method='post' action='registrationvalid.php' novalidate autocomplete="off"> 
        <label>Név (username)</label> <br> 
        <input type="text" name="user" value="<?= isset($_GET['user']) ? $_GET['user'] : ''?>"> <br><br>
        <label>Email</label> <br> 
        <input type="email" name="email" value="<?= isset($_GET['email']) ? $_GET['email'] : '' ?>"> <br><br>
        <label>Jelszó</label><br> 
        <input type="password" name="pw"> <br><br>
        <label>Jelszó újra</label><br> 
        <input type="password" name="pw2"> <br><br>
        <input type="submit" value="Küldés">
    </form>
</body>
</html>