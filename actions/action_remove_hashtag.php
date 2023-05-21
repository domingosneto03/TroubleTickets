<?php
    declare(strict_types = 1);

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    if (isset($_POST['ticketId']) && isset($_POST['tagId'])) {
        require_once(__DIR__ . "/../database/connection.php");
        require_once(__DIR__ . "/../database/ticket.class.php");
        require_once(__DIR__ . "/../database/hashtag.class.php");
        $db = getDatabaseConnection();
        $ticketId = (int)$_POST['ticketId'];
        $tagId = (int)$_POST['tagId'];

        $ticket = Ticket::getTicket($db, $ticketId);
        $ticket->remove_hashtag($db, $tagId);

        $response = ['success' => true, 'message' => 'Tag removed successfully'];
        echo json_encode($response);
    } else {
        $response = ['success' => false, 'message' => 'Tag or Ticket data not provided.'];
        echo json_encode($response);
    }

?>