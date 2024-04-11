<?php
session_start();
require("./class/User.class.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <div class="container">
    <?php if(isset($_REQUEST['submit'])) : ?>
        <?php
        $result = User::Login($_REQUEST['login'], $_REQUEST['password']);
        ?>
     <div class="row mt-5">
        <div class="col-6 offset-3">
                <h1 class="text-center">
                    <?php 
                        if($result)
                            echo "Udało się zalogować";
                        else
                            echo "Nie udało się zalogować";
                    ?>
                </h1>
                <div class="text-center">
                <a href="index.php">Powrót do strony</a>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <h1>Zaloguj się</h1>
                <form action="login.php" method="post">
                    <label for="loginInput">Login:</label>
                    <input type="text" id="loginInput" name="login" required>
                    <label for="passwordInput">Hasło:</label>
                    <input type="password" id="passwordInput" name="password" required>
                    <button type="submit" name="submit">Zaloguj</button>
                </form>
            </div>
        </div>
    <?php endif; ?>    
    </div>
</body>
</html>