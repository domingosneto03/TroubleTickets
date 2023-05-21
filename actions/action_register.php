<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    $db = getDatabaseConnection();
    var_dump($_POST);
    var_dump($_FILES);

    $user = User::getUser($db, $username);
    var_dump($user);

    try {
        if (!is_null($user)) {
            $session->addMessage('error', 'username already exists!');
            echo "1 ";
            var_dump($_SESSION['messages']);
            //header('Location: /register.php' );
        } else {
            if((strlen($password) >= 1 and strlen($password) <= 7) or (strlen($confirm) >= 1 and strlen($confirm) <= 7)) {
                $session->addMessage('error', 'password is too short');
                echo "2 ";
                var_dump($_SESSION['messages']);
                //header('Location: /register.php' );
            } elseif (strlen($password) > 7 or strlen($confirm) > 7) {
                if ($password !== $confirm) {
                    $session->addMessage('error', 'passwords do not match');
                    echo "3 ";
                    var_dump($_SESSION['messages']);
                    //header('Location: /register.php' );
                } else {
                    try { 
                        User::register($db, $username, $email, $password, $bio);
                        $session->addMessage('success', 'Successfully registered!');
                        echo "4 ";
                        var_dump($_SESSION['messages']);
                        //header('Location: /ticket_list.php' );
                    } catch (PDOException $e) {
                        echo 'Database Error: ' . $e->getMessage();
                    } catch (Exception $e) {
                        echo 'Error: ' . $e->getMessage();
                    }
                }
            }
        }
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

    var_dump($_SESSION['messages']);
    echo "final";
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
?>