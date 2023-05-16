<?php
    declare(strict_types = 1);

    class Comment {
        public int $id;
        public string $body;
        public int $ticketId;
        public int $userId;
        public string $username;
        public int $createdAt;

        public function __construct(int $id, string $body, int $createdAt, int $ticketId, int $userId, string $username) {
            $this->id = $id;
            $this->body = $body;
            $this->createdAt = $createdAt;
            $this->ticketId = $ticketId;
            $this->userId = $userId;
            $this->username = $username;
        }

        static function getComment(PDO $db, int $id) : Comment {
            $stmt = $db->prepare('
                SELECT commentId, body, date, ticketId, comment.userId, username
                FROM comment
                JOIN user
                ON user.userId = comment.userId 
                WHERE commentId = ?
            ');
            $stmt->execute(array($id));
            $comment = $stmt->fetch();

            return new Comment(
                $comment['commentId'],
                $comment['body'],
                $comment['date'],
                $comment['ticketId'],
                $comment['userId'],
                $comment['username']
            );
        }

        static function getComments(PDO $db, int $ticketId) : array {
            $stmt = $db->prepare('
                SELECT commentId, body, date, ticketId, comment.userId, username
                FROM comment
                JOIN user
                ON user.userId = comment.userId
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
                    $comment['userId'],
                    $comment['username']
                );
            }
            return $comments;
        }

        static function create_comment(PDO $db, string $body, int $userId, int $ticketId) {
            $date = time();
            $stmt = $db->prepare('
                INSERT INTO comment (body, date, userId, ticketId)
                VALUES (?, ?, ?, ?)
            ');
            $stmt->execute(array($body, $date, $userId, $ticketId));
            return $db->lastInsertId();
        }
    }

?>