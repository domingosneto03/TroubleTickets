<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/comment.class.php");

    $body = $_POST['body'];
    $userId = $_SESSION['id'];
    $ticketId = (int)$_POST['ticketId'];
    if ($body != '') {
        try {
            $db = getDatabaseConnection();
            Comment::create_comment($db, $body, $userId, $ticketId);

        } catch (PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
    header('Location: /ticket.php?id=' . $ticketId);
?>