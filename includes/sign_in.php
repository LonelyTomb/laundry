<?php
require 'start_session.php';
require 'processor.php';
require 'connection.php';

if (isset($_POST['log_in'])) {
    try {
        $email = secure($_POST['email']);
        $password = secure($_POST['password']);
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            try {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $result['password'])) {
                    $_SESSION['logged'] = true;
                    $_SESSION['username'] = $result['name'];
                    header('location: ../index.php?status=success&code=logged_in');
                    exit;
                } else {
                    header('location: ../index.php?status=error&code=not_logged');
                    exit;
                }
            } catch (PDOException $e) {
                $error = $e->getMessage();
            }
        } else {
            header('location: ../index.php?status=error&code=not_logged');
            exit;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
