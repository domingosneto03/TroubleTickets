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
        if($password != $old_password) {
            $session->addMessage('error', 'old password do not match');
            header('Location: /settings.php' );
        } else {
            if((strlen($new_password)>=1 and strlen($new_password)<=2) or (strlen($confirm)>=1 and strlen($confirm)<=2)) {
                $session->addMessage('error', 'password is too short');
                header('Location: /settings.php' );
            } else if(strlen($new_password)>3 or strlen($confirm)>3){
                if ($new_password != $confirm) {
                $session->addMessage('error', 'passwords do not match');
                header('Location: /settings.php' );
            }
            } else {
                $password = $new_password;
                $session->addMessage('success', 'Password updated!');
                header('Location: /settings.php' );
            }  
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>