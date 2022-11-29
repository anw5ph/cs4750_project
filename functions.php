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
            setcookie('user', $email, time()+3600);
            header("Location:home.php");
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

function userLogout(){
    if (count($_COOKIE) > 0)
    {
        foreach ($_COOKIE as $key => $value)
        {
          // Deletes the variable (array element) where the value is stored in this PHP.
          // However, the original cookie still remains intact in the browser.
            unset($_COOKIE[$key]);

          // To completely remove cookies from the client,
          // set the expiration time to be in the past
            setcookie($key, '', time() - 3600);
        }
       header('Location:login.php');

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

function currentUser($email) {
    global $db;

    $query = "SELECT userID FROM user WHERE email = :email;";

    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result['userID'];


}

function getUser($curr_user) {
    global $db;

    $query = "SELECT * FROM user WHERE userID = :curr_user;";

    $statement = $db->prepare($query);
    $statement->bindValue(':curr_user', $curr_user);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;


}

function updateUser($userID, $firstName, $middleName, $lastName, $email, $location) {
    global $db;
    $query = "UPDATE user SET firstName=:firstName, middleName=:middleName, lastName=:lastName, email=:email, location=:location WHERE userID=:userID";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $userID);
    $statement->bindValue(":firstName", $firstName);
    $statement->bindValue(":middleName", $middleName);
    $statement->bindValue(":lastName", $lastName);
    $statement->bindValue(":email", $email);
    $statement->bindValue(":location", $location);
    $statement->execute();

    header("Location:my-account.php");
    $statement->closeCursor();

}

function getTransactions($userID, $order) {
    global $db;
    $query = "
    (SELECT transID, name, service AS \"Category\", period, flatAmount, numPayments, dailyRate, allTime AS \"elapsed\", startDate, endDate
        FROM transaction            NATURAL JOIN
             transactionDailyRate   NATURAL JOIN
             transactionAllTime     NATURAL JOIN
             transactionDates       NATURAL JOIN
             expense
        WHERE userID = :userID)
    UNION
    (SELECT transID, name, source, period, flatAmount, numPayments, dailyRate, allTime AS \"elapsed\",startDate, endDate
        FROM transaction            NATURAL JOIN
             transactionDailyRate   NATURAL JOIN
             transactionAllTime     NATURAL JOIN
             transactionDates       NATURAL JOIN
             incomeSource
        WHERE userID = :userID)
    ORDER BY $order;";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function delTransaction($userID, $transID) {
    global $db;
    $query = "DELETE FROM expense WHERE userID = :userID AND transID = :transID;
              DELETE FROM incomeSource WHERE userID = :userID AND transID = :transID";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $userID);
    $statement->bindValue(":transID", $transID);
    $statement->execute();
    $statement->closeCursor();
}

function updateTransaction($userID, $transID) {
    
}


function filterTransactions($userID, $since, $until, $order) {

    if(!strtotime($since) or !strtotime($until)) {
        return getTransactions($userID, $order);
    } 

    $now = date("Y-m-d");
    $dateNow = new DateTime($now);
    $dateSince = new DateTime($since);
    $dateUntil = new DateTime($until);

    if($dateSince >= $dateUntil) {
        return getTransactions($userID, $order);

    }
    echo "<p>$order</p>";
    
    //if(Id is null, 0, id)
    // DATEDIFF(if(startDate < :since, :since, startDate), if(endDate > :until, :until, endDate)) AS \"elapsed\"

    global $db;
    $query = "
    (SELECT name, period, flatAmount, numPayments, allTime, startDate, endDate, dailyRate *
    DATEDIFF(if(endDate > :until, :until, endDate), if(startDate < :since, :since, startDate)) AS \"elapsed\"
        FROM transaction            NATURAL JOIN
             transactionDailyRate   NATURAL JOIN
             transactionAllTime     NATURAL JOIN
             transactionDates       NATURAL JOIN
             expense
        WHERE userID = :userID AND NOT
              ((:since <= startDate AND :until <= startDate) OR 
               (:since >= endDate AND :until >= endDate)
              )
    )
    UNION
    (SELECT name, period, flatAmount, numPayments, allTime, startDate, endDate, dailyRate *
    DATEDIFF(if(endDate > :until, :until, endDate), if(startDate < :since, :since, startDate)) AS \"elapsed\"
        FROM transaction            NATURAL JOIN
            transactionDailyRate    NATURAL JOIN
            transactionAllTime      NATURAL JOIN
            transactionDates        NATURAL JOIN
            incomeSource
        WHERE userID = :userID AND NOT
              ((:since <= startDate AND :until <= startDate) OR 
               (:since >= endDate AND :until >= endDate)
              )
    )
    ORDER BY $order;";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':since', $since);
    $statement->bindValue(':until', $until);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

?>