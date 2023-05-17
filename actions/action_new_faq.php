<?php
    declare(strict_types = 1);
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/faq.class.php");

    $db = getDatabaseConnection();
    $question = $_POST['faq_question'];
    $answer = $_POST['faq_answer'];

    try {    
        FAQ::createFaq($db, $question, $answer);
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>