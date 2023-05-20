<?php
declare(strict_types = 1);

class User {
    public int $id;
    public string $username;
    public string $email;
    public string $bio;
    public string $userImage;
    public int $dateJoin;
    public int $department;

    public function __construct(int $id, string $username, string $email, string $bio, string $userImage, int $dateJoin, ?int $department) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->bio = $bio;
        $this->userImage = $userImage;
        $this->dateJoin = $dateJoin;
        if ($department === null)
            $this->department = 0;
        else
            $this->department = $department;
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
            SELECT userId, username, password, email, bio, userImage, dateJoin, departmentId
            FROM user
            LEFT OUTER JOIN agent ON agent.agentId = user.userId
            WHERE lower(username) = ?
        ");
        $stmt->execute(array(strtolower($username)));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return new User(
                $user['userId'],
                $user['username'],
                $user['email'],
                $user['bio'],
                $user['userImage'],
                $user['dateJoin'],
                $user['departmentId']
            );
        } else return null; 
    }

    static function getUser(PDO $db, string $username) : ?User {
        $stmt = $db->prepare('
            SELECT userId, username, email, bio, userImage, dateJoin, departmentId
            FROM user
            LEFT OUTER JOIN agent ON agent.agentId = user.userId
            WHERE username = ?
        ');
        $stmt->execute(array($username));
        $user = $stmt->fetch();

        if ($user) {
            return new User(
                $user['userId'],
                $user['username'],
                $user['email'],
                $user['bio'],
                $user['userImage'],
                $user['dateJoin'],
                $user['departmentId']
            );
        } else return null;
    }

    static function getUserById(PDO $db, int $id) : ?User {
        $stmt = $db->prepare('
            SELECT userId, username, email, bio, userImage, dateJoin, departmentId
            FROM user
            LEFT OUTER JOIN agent ON agent.agentId = user.userId
            WHERE userId = ?
        ');
        $stmt->execute(array($id));
        $user = $stmt->fetch();

        if ($user) {
            return new User(
                $user['userId'],
                $user['username'],
                $user['email'],
                $user['bio'],
                $user['userImage'],
                $user['dateJoin'],
                $user['departmentId']
            );
        } else return null;
    }

    static function register(PDO $db, string $username, string $email, string $password, string $bio) {
        $targetDir = __DIR__ . "/../images/user/" . $username . "/";
        $filename = $_FILES['userImage']['name'];
        $fileTmpPath = $_FILES['userImage']['tmp_name'];
        $targetFilePath = $targetDir . $filename;
        $dbFilePath = "images/" . $username . "/" . $filename;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            $stmt = $db->prepare('
                INSERT into user (username, password, email, bio, userImage, dateJoin) 
                VALUES (?, ?, ?, ?, ?, ?)
            ');
            $options = ['cost' => 12];
            $stmt->execute(array(
                $username,
                password_hash($password, PASSWORD_DEFAULT, $options),
                $email,
                $bio,
                $dbFilePath,
                time()
            ));
        }        
    }

    public function delete(PDO $db) {
        $stmt = $db->prepare("DELETE FROM user WHERE userId = ?");
        $stmt->execute(array($this->id));
    }

    function isAgent(PDO $db) : bool {
        $stmt = $db->prepare('
            SELECT *
            FROM agent
            WHERE agentId = ?
        ');
        $stmt->execute(array($this->id));
        return $stmt->fetch() !== false;
    }

    public function isAdmin(PDO $db) : bool {
        $stmt = $db->prepare('
            SELECT *
            FROM admin
            WHERE adminId = ?
        ');
        $stmt->execute(array($this->id));
        return $stmt->fetch() !== false;
    }

    public function makeAdmin(PDO $db) {
        $stmt = $db->prepare('INSERT INTO admin (adminId) VALUES (?)');
        $stmt->execute(array($this->id));
    }

    public function makeAgent(PDO $db, int $departmentId) {
        $stmt = $db->prepare('INSERT INTO agent (agentId, departmentId) VALUES (?, ?)');
        $stmt->execute(array($this->id, $departmentId));
    }

    public function getDepartment(PDO $db) : string {
        $stmt = $db->prepare('
            SELECT name
            FROM department
            WHERE departmentId = ?
        ');
        $stmt->execute(array($this->department));
        return $stmt->fetch()['name'];
    }

    static function getNewUsersWeek(PDO $db) : int {
        $now = time();
        $weekAgo = time() - 604800;
        $stmt = $db->prepare('
            SELECT *
            FROM user
            WHERE dateJoin
            BETWEEN ? AND ?
        ');
        $stmt->execute(array($weekAgo, $now));
        return count($stmt->fetchAll());
    }

    static function getNewUsersMonth(PDO $db) : int {
        $now = time();
        $monthAgo = time() - 2592000;
        $stmt = $db->prepare('
            SELECT *
            FROM user
            WHERE dateJoin
            BETWEEN ? AND ?
        ');
        $stmt->execute(array($monthAgo, $now));
        return count($stmt->fetchAll());
    }
} ?>