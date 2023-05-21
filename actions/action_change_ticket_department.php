<?php 
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $db = getDatabaseConnection();

    $ticket = Ticket::getTicket($db, $_POST['ticket_id']);

    if ($_POST['new_department'] != '') {
        $ticket->changeTicketDepartment($db, $_POST['new_department']);
        $ticket->openTicket($db);
    }

    $user = User::getUserById($db, $session->getId());

    if ($session->isAdmin() || ($user->$department == $_POST['new_department'] || $session->getId() == $ticket->$userId)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    else {
        header("Location: /../ticket_list.php");
    }

?>