<?php
    declare(strict_types = 1);

    class Ticket {
        public int $id;
        public string $title;
        public string $body;
        public string $status = "open";
        public int $assigned;
        public int $clientId;
        public string $priority;
        public int $department;

        static int $next_id = 0;

        public function __construct(int $id, string $title, string $body, ?string $status, int $assigned, int $clientId, string $priority, int $department) {
            $this->id = $id;
            $this->title = $title;
            $this->body = $body;
            $this->status = $status;
            $this->assigned = $assigned;
            $this->clientId = $clientId;
            $this->priority = $priority;
            $this->department = $department;
        }

        static function getTicket(PDO $db, int $id) {
            $stmt = $db->prepare('
                SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department
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
                $ticket['department']
            );
        }

        static function getTickets(PDO $db) {
            $stmt = $db->prepare('
                SELECT t.ticketId, title, body, status, assigned, clientId, priority, td.departmentId AS department
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
                    $ticket['department'] 
                );
            }
            return $tickets;
        }

        static function create_ticket(PDO $db, string $title, string $body, string $status, string $assigned, string $clientId, string $priority, string $department) {
            $stmt = $db->prepare('
                INSERT into ticket (title, body, status, assigned, clientId, priority)
                VALUES (? ? ? ? ? ?)');
            $stmt->execute(array($title, $body, $status, $assigned, $clientId, $priority));
            
            $stmt = $db->prepare('
                SELECT last_insert_rowid()
            ');
            $stmt->execute();
            Ticket::$next_id = $stmt->fetch();

            $stmt = $db->prepare('
                INSERT into ticket_department (ticketId, departmentId)
                VALUE (? ?)');
            $stmt->execute(array(Ticket::$next_id, $department));

            $stmt = $db->prepare('
                INSERT into ticket_history (ticketId, type_of_edit, date, agentId, old_value)
                VALUES (? ? ? ? ?)');
            $stmt->execute(array(Ticket::$next_id, "CREATION", time(), $assigned, NULL));
        }

        static function get_tags(PDO $db, int $id) {
            $stmt = $db->prepare(
                'SELECT h.name
                FROM hashtag h JOIN ticket_hash th JOIN ticket t
                ON th.ticketID=t.ticketID AND th.hashtagID=h.hashtagID
                WHERE t.ticketID=?'
            );

            $stmt->execute(array($id));
            $tags = [];
            while($tag = $stmt->fetch()) {
                $tags = $tag;
            }
            return $tags;
        }

    }


?>