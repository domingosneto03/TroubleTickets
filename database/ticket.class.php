<?php
    declare(strict_types = 1);

    class Ticket {
        public int $id;
        public string $title;
        public string $body;
        public string $status = "open";
        public ?int $assigned;
        public int $clientId;
        public int $priority;
        public ?int $department;
        public int $createdAt;
        public int $deadline;

        static int $next_id = 0;

        public function __construct(int $id, string $title, string $body, ?string $status, ?int $assigned, int $clientId, int $priority, ?int $department, int $createdAt, int $deadline) {
            $this->id = $id;
            $this->title = $title;
            $this->body = $body;
            isset($status) ? $this->status = $status : null;
            is_null($assigned) ? $this->assigned = $assigned : null;
            $this->assigned = $assigned;
            $this->clientId = $clientId;
            $this->priority = $priority;
            $this->department = $department;
            $this->createdAt = $createdAt;
            $this->deadline = $deadline;
        }

        static function getTicket(PDO $db, int $id) {
            $stmt = $db->prepare('
                SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, th.date as createdAt, deadline
                FROM ticket t
                JOIN ticket_department td
                ON t.ticketId = td.ticketId
                JOIN ticket_history th
                ON t.ticketId = th.ticketId
                WHERE t.ticketId = ?
                AND th.type_of_edit = "CREATION"
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
                $ticket['createdAt'],
                $ticket['deadline']
            );
        }

        static function getTickets(PDO $db, ?string $filter, ?string $order) {
            $query = 'SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, th.date as createdAt, deadline
            FROM ticket t
            JOIN ticket_department td
            ON t.ticketId = td.ticketId
            JOIN ticket_history th
            ON t.ticketId = th.ticketId
            WHERE th.type_of_edit = "CREATION"';
            if ($filter !== null)
                $query .= $filter;
            if ($order !== null)
                $query .= $order;
            $stmt = $db->prepare($query);
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
                    $ticket['createdAt'],
                    $ticket['deadline'] 
                );
            }
            return $tickets;
        }

        static function getClientTickets(PDO $db, int $clientId, ?string $filter, ?string $order) {
            $query = 'SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, th.date as createdAt, deadline
            FROM ticket t
            JOIN ticket_department td
            ON t.ticketId = td.ticketId
            JOIN ticket_history th
            ON t.ticketId = th.ticketId
            WHERE th.type_of_edit = "CREATION"
            AND clientId = ?';

            if ($filter !== null)
                $query .= $filter;
            if ($order !== null)
                $query .= $order;

            $stmt = $db->prepare($query);
            $stmt->execute(array($clientId));
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
                    $ticket['createdAt'],
                    $ticket['deadline']
                );
            }
            return $tickets;
        }

        static function getAgentTickets(PDO $db, int $agentId, int $departmentId, ?string $filter, ?string $order) {
            $query = 'SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, th.date AS createdAt, deadline
            FROM ticket t
            JOIN ticket_department td
            ON t.ticketId = td.ticketId
            JOIN ticket_history th
            ON t.ticketId = th.ticketId
            WHERE th.type_of_edit = "CREATION"
            AND departmentId = ?';
            $or = ' OR clientId = ' . $agentId;
            $depOrder = ' ORDER BY department DESC';

            if ($filter !== null)
                $query .= $filter;
            else 
                $query .= $or;

            if ($order !== null)
                $query .= $order;
            else 
                $query .= $depOrder;
            
            $stmt = $db->prepare($query);
            $stmt->execute(array($departmentId));
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
                    $ticket['createdAt'],
                    $ticket['deadline']
                );
            }
            return $tickets;
        }
        
        static function getMyTickets(PDO $db, int $userId) {
            $stmt = $db->prepare('
                SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, th.date as createdAt, deadline  
                FROM ticket t
                JOIN ticket_department td
                ON t.ticketId = td.ticketId
                JOIN ticket_history th
                ON t.ticketId = th.ticketId
                WHERE th.type_of_edit = "CREATION"
                AND clientId = ?
            ');
            $stmt->execute(array($userId));
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
                    $ticket['createdAt'],
                    $ticket['deadline']
                );
            }
            return $tickets;
        }

        static function getTrackedTickets(PDO $db, int $agentId) {
            $stmt = $db->prepare('
                SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department, th.date as createdAt, deadline  
                FROM ticket t
                JOIN ticket_department td
                ON t.ticketId = td.ticketId
                JOIN ticket_history th
                ON t.ticketId = th.ticketId
                WHERE th.type_of_edit = "CREATION"
                AND assigned = ?
            ');
            $stmt->execute(array($agentId));
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
                    $ticket['createdAt'],
                    $ticket['deadline']
                );
            }
            return $tickets;
        }

        static function create_ticket(PDO $db, string $title, string $body, int $clientId, int $priority, ?int $department, int $deadline) {
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

        static function edit_ticket(PDO $db, int $id, string $title, string $body, int $priority, int $department, int $deadline) {
            $stmt = $db->prepare('
                UPDATE ticket
                SET title = ?, body = ?, priority = ?, deadline = ?
                WHERE ticketId = ?
            ');
            $stmt->execute(array($title, $body, $priority, $deadline, $id));

            $stmt = $db->prepare('
                UPDATE ticket_department
                SET departmentId = ?
                WHERE ticketId = ?
            ');
            $stmt->execute(array($department, $id));

            $stmt = $db->prepare('
                INSERT into ticket_history (ticketId, type_of_edit, date, old_value)
                VALUES (?, ?, ?, ?)
            ');
            $stmt->execute(array($id, "EDIT", time(), NULL));
        }

        public function closeTicket(PDO $db, int $id, int $agentId) {
            $stmt = $db->prepare('
                UPDATE ticket
                SET status = "closed"
                WHERE ticketId = ?
            ');
            $stmt->execute(array($id));

            $stmt = $db->prepare('
                INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value)
                VALUES (?, ?, ?, ?, ?)
            ');
            $stmt->execute(array($id, "closed", time(), $agentId, null));
        }

        public function openTicket(PDO $db) {
            $stmt = $db->prepare('
                UPDATE ticket
                SET status = "open"
                WHERE ticketId = ?
            ');
            $stmt->execute(array($this->id));

            $stmt = $db->prepare('
                INSERT INTO ticket_history (ticketId, type_of_edit, date, old_value)
                VALUES (?, ?, ?, ?)
            ');
            $stmt->execute(array($this->id, "open", time(), null));
        }

        public function hasHashtag(PDO $db, string $hashtag) : bool {
            $stmt = $db->prepare('
                SELECT h.hashtagId
                FROM hashtag h
                JOIN ticket_hash th
                ON h.hashtagId = th.hashtagId
                WHERE ticketId = ?
                AND name = ? 
            ');
            $stmt->execute(array($this->id, $hashtag));
            return $stmt->fetch() !== false;
        }

        public function add_hashtag(PDO $db, int $hashtagId, int $agentId) {
            $stmt = $db->prepare('
                INSERT INTO ticket_hash (ticketId, hashtagId)
                VALUES (?, ?)
            ');
            $stmt->execute(array($this->id, $hashtagId));

            $stmt = $db->prepare('
                INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value)
                VALUES (?, ?, ?, ?, ?)
            ');
            $stmt->execute(array($this->id, $hashtagId, time(), $agentId, null));
        }

        public function remove_hashtag(PDO $db, int $tagId) {
            $stmt = $db->prepare('
                DELETE FROM ticket_hash
                WHERE ticketId = ?
                AND hashtagId = ?
            ');
            $stmt->execute(array($this->id, $tagId));
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

        public function getPriority() : string {
            switch ($this->priority) {
                case 1:
                    return "urgent";
                case 2:
                    return "high";
                case 3:
                    return "medium";
                case 4:
                    return "low";
            }
        }

        public function getClientName(PDO $db) : string {
            $stmt = $db->prepare('
                SELECT actualName
                FROM user
                WHERE userId = ?
            ');
            $stmt->execute(array($this->clientId));
            $client = $stmt->fetch();
            return $client['actualName'];
        }

        public function getAgentName(PDO $db) : ?string {
            $stmt = $db->prepare('
                SELECT actualName
                FROM user
                WHERE userId = ?
            ');
            $stmt->execute(array($this->assigned));
            $agent = $stmt->fetch();
            if ($agent)
                return $agent['actualName'];
            else
                return null;
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
                ORDER BY date DESC
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

        static function getNewTicketsWeek(PDO $db) : int {
            $now = time();
            $weekAgo = time() - 604800;
            $stmt = $db->prepare('
                SELECT *
                FROM ticket_history
                WHERE type_of_edit = "CREATION"
                AND date
                BETWEEN ? AND ?
            ');
            $stmt->execute(array($weekAgo, $now));
            return count($stmt->fetchAll());
        }

        static function getNewTicketsMonth(PDO $db) : int {
            $now = time();
            $monthAgo = time() - 2592000;
            $stmt = $db->prepare('
                SELECT *
                FROM ticket_history
                WHERE type_of_edit = "CREATION"
                AND date
                BETWEEN ? AND ?
            ');
            $stmt->execute(array($monthAgo, $now));
            return count($stmt->fetchAll());
        }

        static function getClosedTicketsWeek(PDO $db) : int {
            $now = time();
            $weekAgo = time() - 604800;
            $stmt = $db->prepare('
                SELECT *
                FROM ticket_history
                WHERE type_of_edit = "closed"
                AND date
                BETWEEN ? AND ?
            ');
            $stmt->execute(array($weekAgo, $now));
            return count($stmt->fetchAll());
        }

        static function getClosedTicketsMonth(PDO $db) : int {
            $now = time();
            $monthAgo = time() - 2592000;
            $stmt = $db->prepare('
                SELECT *
                FROM ticket_history
                WHERE type_of_edit = "closed"
                AND date
                BETWEEN ? AND ?
            ');
            $stmt->execute(array($monthAgo, $now));
            return count($stmt->fetchAll());
        }

        public function changeTicketDepartment(PDO $db, int $departmentId) {
            $stmt = $db->prepare('
                UPDATE ticket_department
                SET departmentId = ?
                WHERE ticketId = ?
            ');
            $stmt->execute(array($departmentId, $this->id));
        }

        public function assignTicket(PDO $db, int $userId) {
            $stmt = $db->prepare('
                UPDATE ticket
                SET assigned = ?
                WHERE ticketId = ?
            ');
            $stmt->execute(array($userId, $this->id));
            $stmt = $db->prepare('
                UPDATE ticket
                SET status = "assigned"
                WHERE ticketId = ?
            ');
            $stmt->execute(array($this->id));
        }
    }


?>