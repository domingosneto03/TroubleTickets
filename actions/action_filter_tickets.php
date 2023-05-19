<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    require_once(__DIR__ . "/../database/user.class.php");
    $db = getDatabaseConnection();

    $user = User::getUserById($db, $_SESSION['id']);
    $filters = isset($_POST['filter']) ? $_POST['filter'] : array();
    $conditions = array();

    if ($filters['priority'] !== "") {
        $priority = $filters['priority'];
        if ($priority === "urgent") {
            $conditions[] = "priority = 1";
        } elseif ($priority === "high") {
            $conditions[] = "priority = 2";
        } elseif ($priority === "medium") {
            $conditions[] = "priority = 3";
        } elseif ($priority === "low") {
            $conditions[] = "priority = 4";
        }
    }

    if ($filters['department'] !== "") {
        $department = $filters['department'];
        $conditions[] = "departmentId = $department";
    }

    if ($filters['tag'] !== "") {
        $tag = $filters['tag'];
        $conditions[] = "t.ticketId IN (SELECT ticketId FROM ticket_hash WHERE hashtagId = $tag)";
    }

    if ($_POST['date_start'] !== "") {
        $date_start = $_POST['date_start'];
        $date_start = strtotime($date_start);
        $conditions[] = "createdAt >= '$date_start'";
    }

    if ($_POST['date_end'] !== "") {
        $date_end = $_POST['date_end'];
        $date_end = strtotime($date_end);
        $conditions[] = "createdAt <= '$date_end'";
    }

    $filter = ' AND ';
    if (!empty($conditions)) {
        $filter .= implode(' AND ', $conditions);
    } else {
        $filter = null;
    }

    $order = '';
    if ($_POST['ordering'] !== ""){
        if ($_POST['ordering'] === "htl_priority")
            $order = " ORDER BY priority ASC";
        elseif ($_POST['ordering'] === "lth_priority")
            $order = " ORDER BY priority DESC";
        elseif ($_POST['ordering'] === "most_recent")
            $order = " ORDER BY createdAt DESC";
        elseif ($_POST['ordering'] === "least_recent")
            $order = " ORDER BY createdAt ASC";
    } else {
        $order = null;
    }

    $tickets = array();
    if ($session->isAdmin()) {
        $tickets = Ticket::getTickets($db, $filter, $order);
    } elseif ($session->isAgent()) {
        $tickets = Ticket::getAgentTickets($db, $_SESSION['id'], $user->department, $filter, $order);
    } else {
        $tickets = Ticket::getClientTickets($db, $_SESSION['id'], $filter, $order);
    }
    
    $_SESSION['filtered_tickets'] = $tickets;
    header('Location: /ticket_list.php');
?>