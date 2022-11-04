<?php

function userLogIn($email, $password) {
    global $db;
    $query = "SELECT password FROM user WHERE email=:email";
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch();
    
        if (password_verify($password, $result[0])) {
            header("Location:index.php");
        }
        else {
            header("Location:login.php?error=Incorrect email or password");
        }
        $statement->closeCursor();
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
    
}

function addUser($firstName, $middleName, $lastName, $email, $location, $password) {
    global $db;
    $query = "INSERT INTO user (firstName, middleName, lastName, email, location, password) VALUES (:firstName, :middleName, :lastName, :email, :location, :password)";

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':middleName', $middleName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':location', $location);

        $password = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindValue(':password', $password);
        $statement->execute();

        header("Location:login.php");
        $statement->closeCursor();

    }
    catch (PDOException $e) {
        // echo $e->getMessage();
        if (str_contains($e->getMessage(), "Duplicate")) {
            echo "A user already exists with this information <br/>";
        }
    }

    catch (Exception $e) {
        echo $e->getMessage();
    }

}
?>