<?php 

    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $username = $session->getUsername();
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm = $_POST['confirmPassword'];

    $db = getDatabaseConnection();
    $password = User::getPassword($db, $username);

    try {
        if(($password !== $old_password || strlen($new_password) < 7 ) || $new_password != $confirm) {
            $session->addMessage('error', 'old password does not match');
            header('Location: /settings.php' );
        } 
        else {
            
                $password = $new_password;
                $session->addMessage('success', 'Password updated!');
                header('Location: /settings.php' );
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>