<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/ticket.class.php");
    $db = getDatabaseConnection();

    $filters = isset($_POST['filter']) ? $_POST['filter'] : array();
    $conditions = array();

    if ($filters['priority'] !== "") {
        $priority = $filters['priority'];
        if ($priority === "high") {
            $conditions[] = "priority = 1";
        } elseif ($priority === "medium") {
            $conditions[] = "priority = 2";
        } elseif ($priority === "low") {
            $conditions[] = "priority = 3";
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

    $whereClause = 'WHERE th.type_of_edit = "CREATION" ';
    if (!empty($conditions)) {
        $whereClause .= ' AND ' . implode(' AND ', $conditions);
    }

    if ($_POST['ordering'] !== ""){
        if ($_POST['ordering'] === "htl_priority")
            $whereClause .= " ORDER BY priority DESC";
        elseif ($_POST['ordering'] === "lth_priority")
            $whereClause .= " ORDER BY priority ASC";
        elseif ($_POST['ordering'] === "most_recent")
            $whereClause .= " ORDER BY createdAt DESC";
        elseif ($_POST['ordering'] === "least_recent")
            $whereClause .= " ORDER BY createdAt ASC";
    }

    $query = "SELECT t.ticketId, title, body, status, assigned, clientId, `priority`, td.departmentId AS department, th.date AS createdAt, deadline
              FROM ticket t
              JOIN ticket_department td
              ON t.ticketId = td.ticketId
              JOIN ticket_history th
              ON t.ticketId = th.ticketId " . $whereClause;

    $stmt = $db->prepare($query);
    $stmt->execute();
    $tickets = array();
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

    $_SESSION['filtered_tickets'] = $tickets;

    header('Location: /ticket_list.php');
?>