<?php
    declare(strict_types = 1);

    class Comment {
        public int $id;
        public string $body;
        public int $ticketId;
        public int $userId;
        public int $createdAt;

        public function __construct(int $id, string $body, int $createdAt, int $ticketId, int $userId) {
            $this->id = $id;
            $this->body = $body;
            $this->createdAt = $createdAt;
            $this->ticketId = $ticketId;
            $this->userId = $userId;
        }

        static function getComment(PDO $db, int $id) {
            $stmt = $db->prepare('
                SELECT *
                FROM comment
                WHERE commentId = ?
            ');
            $stmt->execute(array($id));
            $comment = $stmt->fetch();

            return new Comment(
                $comment['commentId'],
                $comment['body'],
                $comment['date'],
                $comment['ticketId'],
                $comment['userId']
            );
        }

        static function getComments(PDO $db, int $ticketId) {
            $stmt = $db->prepare('
                SELECT *
                FROM comment
                WHERE ticketId = ?
            ');
            $stmt->execute(array($ticketId));
            $comments = [];
            while ($comment = $stmt->fetch()) {
                $comments[] = new Comment(
                    $comment['commentId'],
                    $comment['body'],
                    $comment['date'],
                    $comment['ticketId'],
                    $comment['userId']
                );
            }
            return $comments;
        }

        static function create_comment(PDO $db, string $body, int $ticketId, int $userId) {
            $stmt = $db->prepare('
                INSERT INTO comment (body, date, ticketId, userId)
                VALUES (?, ?, ?)
            ');
            $stmt->execute(array($body, time(), $ticketId, $userId));
            return $db->lastInsertId();
        }
    }

?>