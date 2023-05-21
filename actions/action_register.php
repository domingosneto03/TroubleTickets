<?php
    require_once(__DIR__ . "/../utils/session.php");
    $session = new Session();

    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . "/../database/user.class.php");

    $username = $_POST['username'];
    $actualName = $_POST['actualName'];
    $birthDate = (int) $_POST['birthDate'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    $db = getDatabaseConnection();

    $user = User::getUser($db, $username);

    try {
        if (!is_null($user)) {
            $session->addMessage('error', 'username already exists!');
            header('Location: /register.php' );
            exit();
        } else {
            if((strlen($password) >= 1 and strlen($password) <= 7) or (strlen($confirm) >= 1 and strlen($confirm) <= 7)) {
                $session->addMessage('error', 'password is too short');
                header('Location: /register.php' );
                exit();
            } elseif (strlen($password) > 7 or strlen($confirm) > 7) {
                if ($password !== $confirm) {
                    $session->addMessage('error', 'passwords do not match');
                    header('Location: /register.php' );
                    exit();
                } else {
                    try { 
                        User::register($db, $username, $actualName, $birthDate, $gender, $email, $password, $bio);
                        $session->addMessage('success', 'Successfully registered!');
                        header('Location: /ticket_list.php' );
                        exit();
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

  
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>