<?php
    declare(strict_types = 1);

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    if (isset($_POST['ticketId']) && isset($_POST['tag'])) {
        require_once(__DIR__ . "/../database/connection.php");
        require_once(__DIR__ . "/../database/ticket.class.php");
        require_once(__DIR__ . "/../database/hashtag.class.php");
        $db = getDatabaseConnection();
        $ticketId = (int)$_POST['ticketId'];
        $tag = $_POST['tag'];

        $ticket = Ticket::getTicket($db, $ticketId);
        $tagId = 0;

        if (Hashtag::getHashtagId($db, $tag) !== 0) {
            if ($ticket->hasHashtag($db, $tag)) {
                $response = ['success' => false, 'message' => 'Tag already exists.'];
                echo json_encode($response);
                return;
            } else {
                $tagId = Hashtag::getHashtagId($db, $tag);
            }
        } else {
            $tagId = Hashtag::create_hashtag($db, $tag);
        }

        if ($tagId !== 0) {
            $ticket->add_hashtag($db, $tagId, $session->getId());
            $response = ['success' => true, 'tagId' => $tagId, 'message' => 'Tag added successfully'];
            echo json_encode($response);
        } else {
            $response = ['success' => false, 'message' => 'Tag could not be added.'];
            echo json_encode($response);
        }

    } else {
        $response = ['success' => false, 'message' => 'Tag or Ticket data not provided.'];
        echo json_encode($response);
    }

?>