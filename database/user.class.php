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

    function save($db) {
        $stmt = $db->prepare('
            UPDATE user SET username = ?, email = ?
            WHERE userId = ?'
        );

        $stmt->execute(array($this->username, $this->email, $this->id));
    }

    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {
        $stmt = $db->prepare('
            SELECT id, username, email
            FROM user
            WHERE lower(username) = ?
        ');
        $stmt->execute(array($username));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return new User(
                $user['id'],
                $user['username'],
                $user['email']
            );
        } else return null; 
    }

    static function getUser(PDO $db, int $id) : User {
        $stmt = $db->prepare('
            SELECT userId, username, email
            FROM user
            WHERE userId = ?
        ');
        $stmt->execute(array($id));
        $user = $stmt->fetch();

        return new User(
            $user['userId'],
            $user['username'],
            $user['email']
        );
    }

    static function register($db, $username, $email, $password) {
        $stmt = $db->prepare("INSERT into user VALUES (?, ?, ?)");
        $options = ['cost' => 12];
        $stmt->execute(array(
            $username,
            password_hash($password, PASSWORD_DEFAULT, $options),
            $email
        ));
    }

    function delete($db) {
        $stmt = $db->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute(array($this->id));
    }
}

function edit_user($new_username, $new_email, $new_password) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("UPDATE user SET username = ?, password = ?, email = ?");
    $options = ['cost' => 12];
    $stmt->execute(array(
        $new_username,
        password_hash($new_password, PASSWORD_DEFAULT, $options),
        $new_email
    ));
}



?>