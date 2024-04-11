<?php
class User {
    private $id;
    private $login;
    private $password;

    public function __construct(int $id, string $login)
    {
        $this->id = $id;
        $this->login = $login;
    }


    public static function Register(string $login, string $password) : bool {
        $db = new mysqli('localhost', 'root', '', 'post');
        $sql = "INSERT INTO user (login, password) VALUES (?, ?)";
        $q = $db->prepare($sql);
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $q->bind_param("ss", $login, $passwordHash);
        $result = $q->execute();
        return $result;
    }

    public static function Login(string $login, string $password) : bool {
        $db = new mysqli('localhost', 'root', '', 'post');
        $sql = "SELECT * FROM user WHERE email = ? LIMIT 1";
        $q = $db->prepare($sql);
        $q->bind_param("s", $login);
        $q->execute();
        $result = $q->get_result();
        $row = $result->fetch_assoc();
        $id = $row['ID'];
        $passwordHash = $row['password'];
        if(password_verify($password, $passwordHash)) {
            $user = new User($id, $login);
            $_SESSION['user'] = $user;
            return true;
        } else {
            return false;
        }
    }
    public function Logout() {

    }
}
?>