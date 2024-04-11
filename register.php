<?php
session_start();
require("./class/User.class.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
</head>
<body>
    
    <div class="container">
        <?php if(isset($_REQUEST['submit'])) : ?>
            <?php
            $result = User::Register($_REQUEST['email'], $_REQUEST['password']);            
            ?>
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <h1 class="text-center">
                    <?php 
                        if($result)
                            echo "Udało się założyć konto";
                        else
                            echo "Nastąpił błąd podczas zakładania konta";
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
                <h1 class="text-center">Rejestracja użytkownika</h1>
                <form action="register.php" method="post">
                    <label class="form-label mt-3" for="loginInput">nazwa użytkownika:</label>
                    <input class="form-control mb-1" type="text" id="loginInput" name="login" required>
                    <label class="form-label mt-3" for="passwordInput">Hasło:</label>
                    <input class="form-control mb-1" type="password" id="passwordInput" name="password" required>
                    <label class="form-label mt-3" for="passwordInputRepeat">Powtórz hasło:</label>
                    <input class="form-control mb-1" type="password" id="passwordInputRepeat" name="passwordRepeat" required>
                    <button type="submit" class="btn btn-primary w-100 mt-3" name="submit">Zarejestruj</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>