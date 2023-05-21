<?php 

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $username = $session->getUsername();
    $db = getDatabaseConnection();
    $user = User::getUser($db, $username);

    try {
        if($user) {
            $user->delete($db);
            $session->addMessage('success', 'Account deleted');
            header('Location: /login.php' );
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>