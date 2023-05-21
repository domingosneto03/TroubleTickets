<?php 

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $newusername = $_POST['new_username'];

    $db = getDatabaseConnection();
    $user = User::getUserById($db, $session->getId());
    $maybe_user = User::getUser($db, $newusername);

    try {
        if ($maybe_user) {
            $session->addMessage('error', 'username already exists!');
            header('Location: /settings.php' );
        } 
        else {
            $user->changeUsername($db, $newusername);
            $session->setUsername($newusername);
            $session->addMessage('success', 'Username updated!');
            header('Location: /settings.php' );
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>