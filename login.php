<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/elte-fi/www-assets@19.10.16/styles/mdss.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Login/Registration</title>
</head>
  <body>
    <h1>Bejelentkezés</h1>
    <form method='post' action='index.php' novalidate autocomplete="off"> 
      <label>Név</label> <br> 
      <input type="text" name="user"> <br><br>
      <label>Jelszó</label><br> 
      <input type="password" name="pw"> <br><br>
      
      <input type="submit" value="Küldés">
    <form>
  </body>
</html>