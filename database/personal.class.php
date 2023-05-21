<?php
    declare(strict_types = 1);

    class Personal {
        public int $id;
        public string $name;
        public int $date;
        public string $gender;
        public int $userId;

        public function __construct(int $id, string $name, int $date, string $gender, int $userId) {
            $this->id = $id;
            $this->name = $name;
            $this->idate = $date;
            $this->gender = $gender;
            $this->userId = $userId;
        }
    
        static function getPersonal(PDO $db, int $id) {
            $stmt = $db->prepare('
                SELECT *
                FROM personal
                JOIN user
                ON user.userId = personal.userId 
                WHERE commentId = ?
                ');
            $stmt->execute(array($id));
            $hashtag = $stmt->fetch();
            return new Personal(
                $personal['personalId'],
                $personal['name'],
                $personal['gender'],
                $personal['userId']
            );
        }
    }
?>