<?php
    declare(strict_types = 1);

    class Hashtag {
        public int $id;
        public string $name;

        public function __construct(int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

        static function getHashtag(PDO $db, int $id) {
            $stmt = $db->prepare('
                SELECT *
                FROM hashtag
                WHERE hashtagId = ?
            ');
            $stmt->execute(array($id));
            $hashtag = $stmt->fetch();

            return new Hashtag(
                $hashtag['hashtagId'],
                $hashtag['name']
            );
        }

        static function getHashtagId(PDO $db, string $hashtag) : int {
            $stmt = $db->prepare('
                SELECT hashtagId
                FROM hashtag
                WHERE name = ? 
            ');
            $stmt->execute(array($hashtag));
            $row = $stmt->fetch();

            if ($row !== false && isset($row['hashtagId'])) {
                return (int)$row['hashtagId'];
            } else {
                return 0;
            }
        }

        static function create_hashtag(PDO $db, string $name) {
            $stmt = $db->prepare('
                INSERT INTO hashtag (name)
                VALUES (?)
            ');
            $stmt->execute(array($name));
            return $db->lastInsertId();
        }

        static function getAllTags(PDO $db) {
            $stmt = $db->prepare('
                SELECT *
                FROM hashtag
                ORDER BY name ASC
            ');
            $stmt->execute();
            $hashtags = [];
            while ($hashtag = $stmt->fetch()) {
                $hashtags[] = new Hashtag(
                    $hashtag['hashtagId'],
                    $hashtag['name']
                );
            }
            return $hashtags;
        }

        function remove(PDO $db) {
            $stmt = $db->prepare('
                DELETE FROM hashtag
                WHERE hashtagId = ?
            ');
            $stmt->execute(array($this->id));
            $stmt = $db->prepare('
                DELETE FROM ticket_hash
                WHERE hashtagId = ?
            ');
            $stmt->execute(array($this->id));
        }
    }


?>