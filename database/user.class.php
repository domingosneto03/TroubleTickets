<?php
declare(strict_types = 1);

class User {
    public int $id;
    public string $username;
    public string $email;

    public function __construct(int $id, string $username, string $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    function save(PDO $db) {
        $stmt = $db->prepare('
            UPDATE user SET username = ?, email = ?
            WHERE userId = ?'
        );

        $stmt->execute(array($this->username, $this->email, $this->id));
    }

    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {
        $stmt = $db->prepare("
            SELECT userId, username, password, email
            FROM user
            WHERE lower(username) = ?
        ");
        $stmt->execute(array(strtolower($username)));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return new User(
                $user['userId'],
                $user['username'],
                $user['email']
            );
        } else return null; 
    }

    static function getUser(PDO $db, string $username) : ?User {
        $stmt = $db->prepare('
            SELECT userId, username, email
            FROM user
            WHERE username = ?
        ');
        $stmt->execute(array($username));
        $user = $stmt->fetch();

        if ($user) {
            return new User(
                $user['userId'],
                $user['username'],
                $user['email']
            );
        } else return null;
    }

    static function register(PDO $db, string $username, string $email, string $password) {
        $stmt = $db->prepare("INSERT into user (username, password, email) VALUES (?, ?, ?)");
        $options = ['cost' => 12];
        $stmt->execute(array(
            $username,
            password_hash($password, PASSWORD_DEFAULT, $options),
            $email
        ));
    }

    function delete(PDO $db) {
        $stmt = $db->prepare("DELETE FROM user WHERE userId = ?");
        $stmt->execute(array($this->id));
    }
}
?>