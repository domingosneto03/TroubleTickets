<?php 

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");


    $db = getDatabaseConnection();

    $birthDate = $_POST['birthDate'];

    $user = User::getUserById($db, $session->getId());
    try {
        $user->changeBirthDate($db, $birthDate);
    }
    catch (PDOException $e) {
        echo 'error is' . $e;
    }
    catch (Exception $e) {
        echo 'error is' . $e;
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);

?>