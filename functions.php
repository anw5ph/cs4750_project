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

function getTransactions($userID, $order) {
    global $db;
    $query = "
    (SELECT name, service AS \"Category\", period, flatAmount, numPayments, dailyRate, allTime AS \"elapsed\", startDate, endDate
        FROM transaction            NATURAL JOIN
             transactionDailyRate   NATURAL JOIN
             transactionAllTime     NATURAL JOIN
             transactionDates       NATURAL JOIN
             expense
        WHERE userID = :userID)
    UNION
    (SELECT name, source, period, flatAmount, numPayments, dailyRate, allTime AS \"elapsed\",startDate, endDate
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