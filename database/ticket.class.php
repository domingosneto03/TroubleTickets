<?php
    declare(strict_types = 1);

    class Ticket {
        public int $id;
        public string $title;
        public string $body;
        public string $status = "open";
        public ?int $assigned;
        public int $clientId;
        public string $priority;
        public int $department;
        public int $deadline;

        static int $next_id = 0;

        public function __construct(int $id, string $title, string $body, ?string $status, ?int $assigned, int $clientId, string $priority, int $department, int $deadline) {
            $this->id = $id;
            $this->title = $title;
            $this->body = $body;
            isset($status) ? $this->status = $status : null;
            is_null($assigned) ? $this->assigned = $assigned : null;
            $this->assigned = $assigned;
            $this->clientId = $clientId;
            $this->priority = $priority;
            $this->department = $department;
            $this->deadline = $deadline;
        }

        static function getTicket(PDO $db, int $id) {
            $stmt = $db->prepare('
                SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, deadline
                FROM ticket t
                JOIN ticket_department td
                ON t.ticketId = td.ticketId
                WHERE t.ticketId = ?
            ');
            $stmt->execute(array($id));
            $ticket = $stmt->fetch();

            return new Ticket(
                $ticket['ticketId'],
                $ticket['title'],
                $ticket['body'],
                $ticket['status'],
                $ticket['assigned'],
                $ticket['clientId'],
                $ticket['priority'],
                $ticket['department'],
                $ticket['deadline']
            );
        }

        static function getTickets(PDO $db) {
            $stmt = $db->prepare('
                SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, deadline
                FROM ticket t
                JOIN ticket_department td
                ON t.ticketId = td.ticketId
            ');
            $stmt->execute();
            $tickets = [];
            while ($ticket = $stmt->fetch()) {
                $tickets[] = new Ticket(
                    $ticket['ticketId'],
                    $ticket['title'],
                    $ticket['body'],
                    $ticket['status'],
                    $ticket['assigned'],
                    $ticket['clientId'],
                    $ticket['priority'],
                    $ticket['department'],
                    $ticket['deadline'] 
                );
            }
            return $tickets;
        }

        static function create_ticket(PDO $db, string $title, string $body, int $clientId, string $priority, int $department, int $deadline) {
            $stmt = $db->prepare('
                INSERT into ticket (title, body, clientId, priority, deadline)
                VALUES (?, ?, ?, ?, ?)
            ');
            $stmt->execute(array($title, $body, $clientId, $priority, $deadline));
            
            Ticket::$next_id = (int)$db->lastInsertId();

            $targetDir = __DIR__ . "/../uploads/" . Ticket::$next_id . "/";

            $totalFiles = count($_FILES['file']['name']);
            for ($i = 0; $i < $totalFiles; $i++) {
                $filename = $_FILES['file']['name'][$i];
                $targetFilePath = $targetDir . $filename;
                $dbFilePath = "uploads/" . Ticket::$next_id . "/" . $filename;
                $fileTmpPath = $_FILES['file']['tmp_name'][$i];

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                    $stmt = $db->prepare('
                        INSERT into ticket_file (ticketId, filepath)
                        VALUES (?, ?)
                    ');
                    $stmt->execute(array(Ticket::$next_id, $dbFilePath));
                }
            }

            $stmt = $db->prepare('
                INSERT into ticket_department (ticketId, departmentId)
                VALUES (?, ?)');
            $stmt->execute(array(Ticket::$next_id, $department));

            $stmt = $db->prepare('
                INSERT into ticket_history (ticketId, type_of_edit, date, old_value)
                VALUES (?, ?, ?, ?)');
            $stmt->execute(array(Ticket::$next_id, "CREATION", time(), NULL));
        }

        function add_Hashtag(PDO $db, int $ticketId) {
            $stmt = $db->prepare('
                INSERT into ticket_hash (ticketId, hashtagId)
                VALUES (? ?)
            ');
            $stmt->execute(array($ticketId, $this->id));
        }

        public function getHashtags(PDO $db) {
            $stmt = $db->prepare('
                SELECT hashtag.hashtagId, name
                FROM hashtag
                JOIN ticket_hash
                ON hashtag.hashtagId = ticket_hash.hashtagId
                WHERE ticketId = ?
            ');
            $stmt->execute(array($this->id));
            $tags = [];
            while ($tag = $stmt->fetch()) {
                $tags[] = new Hashtag(
                    $tag['hashtagId'],
                    $tag['name']
                );
            }
            return $tags;
        }

        public function getClientName(PDO $db) : string {
            $stmt = $db->prepare('
                SELECT username
                FROM user
                WHERE userId = ?
            ');
            $stmt->execute(array($this->clientId));
            $client = $stmt->fetch();
            return $client['username'];
        }

        public function getAgentName(PDO $db) : ?string {
            $stmt = $db->prepare('
                SELECT username
                FROM user
                WHERE userId = ?
            ');
            $stmt->execute(array($this->assigned));
            $agent = $stmt->fetch();
            if ($agent)
                return $agent['username'];
            else
                return null;
        }

        public function getCreationDate(PDO $db) {
            $stmt = $db->prepare('
                SELECT date
                FROM ticket_history
                WHERE ticketId = ?
                AND type_of_edit = "CREATION"
            ');
            $stmt->execute(array($this->id));
            $date = $stmt->fetch();
            return $date['date'];
        }

        public function getDepartment(PDO $db) : string {
            $stmt = $db->prepare('
                SELECT name
                FROM department
                WHERE departmentId = ?
            ');
            $stmt->execute(array($this->department));
            $department = $stmt->fetch();
            return $department['name'];
        }

        public function getComments(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT commentId, body, date, ticketId, comment.userId, username
                FROM comment
                JOIN user
                ON comment.userId = user.userId
                WHERE ticketId = ?
            ');
            $stmt->execute(array($this->id));
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

        public function getFiles(PDO $db) : ?array {
            $stmt = $db->prepare('
                SELECT filepath
                FROM ticket_file
                WHERE ticketId = ?
            ');
            $stmt->execute(array($this->id));
            $files = [];
            while ($file = $stmt->fetch()) {
                $files[] = $file['filepath'];
            }
            return $files;
        }
 
    }


?>