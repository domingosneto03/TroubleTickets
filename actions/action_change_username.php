<?php 

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $username = $session->getUsername();
    $newusername = $_POST['new_username'];

    $db = getDatabaseConnection();

    $user = User::getUser($db, $username);

    try {
        if ($user) {
            $session->addMessage('error', 'username already exists!');
            header('Location: /settings.php' );
        } else {
            $username = $newusername;
            $session->addMessage('success', 'Username updated!');
            header('Location: /settings.php' );
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>