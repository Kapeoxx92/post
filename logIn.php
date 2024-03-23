<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == "login") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $db = new mysqli("localhost", "root", "", "post");

        $q = $db->prepare("SELECT * FROM user WHERE login = ? LIMIT 1");
        $q->bind_param("s", $email);
        $q->execute();
        $result = $q->get_result();

        $userRow = $result->fetch_assoc();
        if ($userRow == null) {
            echo "Nieprawidłowy login lub hasło <br>";
        } else {
            if (password_verify($password, $userRow['password'])) {
                echo "Zalogowano poprawnie <br>";
            } else {
                echo "Nieprawidłowy login lub hasło <br>";
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == "register") {
        $db = new mysqli("localhost", "root", "", "post");
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $password = $_POST['password'];
        $passwordRepeat = $_POST['repeatPassword'];

        if ($password == $passwordRepeat) {
            $passwordHash = password_hash($password, PASSWORD_ARGON2I);
            $q = $db->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
            $q->bind_param("ss", $email, $passwordHash);
            $result = $q->execute();
            if ($result) {
                echo "Konto utworzono poprawnie"; 
            } else {
                echo "Coś poszło nie tak!";
            }
        } else {
            echo "Hasła nie są zgodne - spróbuj ponownie!";
        }
    }
}
?>

<h1>Zaloguj się</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput"><br>
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="Inputpassword"><br>
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Zaloguj">
</form>
<h1>Zarejestruj się</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput"><br>
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="Inputpassword"><br>
    <label for="repeatPasswordInput">Powtórz hasło:</label>
    <input type="password" name="repeatPassword" id="repeatPasswordInput"><br>
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Zarejestruj">
</form>