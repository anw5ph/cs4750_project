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

function getTransactions($userID, $order, $type) {
    $test = 0;
    if(strlen($type) == 0) {
        $test = 1;
    }

    global $db;
    $query = "
    (SELECT userID, transID, name, service AS \"Category\", period, flatAmount, numPayments, dailyRate, allTime AS \"elapsed\", startDate, endDate
        FROM transaction            NATURAL JOIN
             transactionDailyRate   NATURAL JOIN
             transactionAllTime     NATURAL JOIN
             transactionDates       NATURAL JOIN
             expense                NATURAL JOIN
             expenseServiceCategory NATURAL JOIN
             expenseNecessity
        WHERE userID = :userID AND (necessityLevel = :type OR $test))
    UNION
    (SELECT userID, transID, name, source, period, flatAmount, numPayments, dailyRate, allTime AS \"elapsed\", startDate, endDate
        FROM transaction            NATURAL JOIN
             transactionDailyRate   NATURAL JOIN
             transactionAllTime     NATURAL JOIN
             transactionDates       NATURAL JOIN
             incomeSource           NATURAL JOIN
             incomeSourceType
        WHERE userID = :userID AND (type = :type OR $test))
    ORDER BY $order;";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':type', $type);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function delTransaction($userID, $transID) {
    global $db;
    $query = "DELETE FROM expense WHERE userID = :userID AND transID = :transID;
              DELETE FROM incomeSource WHERE userID = :userID AND transID = :transID;
              DELETE FROM transaction WHERE userID = :userID AND transID = :transID";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $userID);
    $statement->bindValue(":transID", $transID);
    $statement->execute();
    $statement->closeCursor();
}

function updateTransaction($userID, $transID, $name, $description) {
    global $db;
    $query = "UPDATE transaction SET name=:name, description=:description
              WHERE userID = :userID AND transID = :transID";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':transID', $transID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $result = $statement->fetch();
    header("Location:home.php");
    $statement->closeCursor();

    echo "<p>$result</p>";
}


function filterTransactions($userID, $since, $until, $order, $type) {

    if(!strtotime($since) or !strtotime($until)) {
        return getTransactions($userID, $order, $type);
    } 

    $now = date("Y-m-d");
    $dateNow = new DateTime($now);
    $dateSince = new DateTime($since);
    $dateUntil = new DateTime($until);

    if($dateSince >= $dateUntil) {
        return getTransactions($userID, $order, $type);

    }
    
    //if(Id is null, 0, id)
    // DATEDIFF(if(startDate < :since, :since, startDate), if(endDate > :until, :until, endDate)) AS \"elapsed\"

    $test = 0;
    if(strlen($type) == 0) {
        $test = 1;
    }

    global $db;
    $query = "
    (SELECT userID, transID, name, period, flatAmount, numPayments, allTime, startDate, endDate, dailyRate *
    DATEDIFF(if(endDate > :until, :until, endDate), if(startDate < :since, :since, startDate)) AS \"elapsed\"
        FROM transaction            NATURAL JOIN
             transactionDailyRate   NATURAL JOIN
             transactionAllTime     NATURAL JOIN
             transactionDates       NATURAL JOIN
             expense                NATURAL JOIN
             expenseServiceCategory NATURAL JOIN
             expenseNecessity
        WHERE userID = :userID AND NOT
              ((:since <= startDate AND :until <= startDate) OR 
               (:since >= endDate AND :until >= endDate)
              ) AND
              (necessityLevel = :type OR $test)
    )
    UNION
    (SELECT userID, transID, name, period, flatAmount, numPayments, allTime, startDate, endDate, dailyRate *
    DATEDIFF(if(endDate > :until, :until, endDate), if(startDate < :since, :since, startDate)) AS \"elapsed\"
        FROM transaction            NATURAL JOIN
            transactionDailyRate    NATURAL JOIN
            transactionAllTime      NATURAL JOIN
            transactionDates        NATURAL JOIN
            incomeSource            NATURAL JOIN
            incomeSourceType
        WHERE userID = :userID AND NOT
              ((:since <= startDate AND :until <= startDate) OR 
               (:since >= endDate AND :until >= endDate)
              ) AND
              (type = :type OR $test)
    )
    ORDER BY $order;";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':since', $since);
    $statement->bindValue(':until', $until);
    $statement->bindValue(':type', $type);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}


function addTransaction($userID, $name, $description, $flatAmount, $period, $numPayments, $startDate, $service) {
    $incomeSourceList = array('Commissions', 'Gift','Inheritance','Interest/Dividends', 'Investments','Profits','Rentals','Salary','Social Welfare','Wages');



    $transID = time();

    if(!strtotime($startDate)) {
        echo "<p>Not real date</p>";
        return;
    } 


    $allTime = $flatAmount * $numPayments;

    $days = $period * $numPayments;
    $endDate = date('Y-m-d', strtotime($startDate. " + ".$days."days"));
    $dailyRate = $flatAmount / $period;

    $transType = "";
    if(in_array($service, $incomeSourceList)) {
        $transType = "incomeSource";
    } else {
        $transType = "expense";
    }

    
    global $db;
    $query = "INSERT INTO transactions (userID, transID, name, description, flatAmount, period, numPayments, startDate) VALUES (:userID, :transID, :name, :description, :flatAmount, :period, :numPayments, :startDate)";

    //INSERT INTO transactionDates VALUES ({numPayments}, "{startDate}", "{endDate}", {period});
    $query1 = "INSERT INTO transactionDates VALUES (:numPayments, :startDate, :endDate, :period)";

    //INSERT INTO transactionAllTime VALUES ({flatAmount}, {numPayments}, {allTime});
    $query2 = "INSERT INTO transactionAllTime VALUES (:flatAmount, :numPayments, :allTime)";

    // INSERT INTO transactionDailyRate VALUES ({period}, {flatAmount}, {dailyRate});
    $query3 = "INSERT INTO transactionDailyRate VALUES (:period, :flatAmount, :dailyRate)";

    // INSERT INTO transaction VALUES ({userID}, {transID}, "{name}", "{description}", {flatAmount}, {period}, {numPayments}, "{startDate}");
    $query4 = "INSERT INTO transaction VALUES (:userID, :transID, :name, :description, :flatAmount, :period, :numPayments, :startDate)";

    // INSERT INTO expense VALUES ({userID}, {transID}, "{service}");
    $query5 = "INSERT INTO $transType VALUES (:userID, :transID, :service)";


        $statement = $db->prepare($query1);
        $statement->bindValue(':period', $period);
        $statement->bindValue(':numPayments', $numPayments);
        $statement->bindValue(':startDate', $startDate);
        $statement->bindValue(':endDate', $endDate);
        $statement->execute();
        $statement->closeCursor();

        $statement = $db->prepare($query2);
        $statement->bindValue(':flatAmount', $flatAmount);
        $statement->bindValue(':numPayments', $numPayments);
        $statement->bindValue(':allTime', $allTime);
        $statement->execute();
        $statement->closeCursor();
   
        $statement = $db->prepare($query3);
        $statement->bindValue(':flatAmount', $flatAmount);
        $statement->bindValue(':period', $period);
        $statement->bindValue(':dailyRate', $dailyRate);
        $statement->execute();
        $statement->closeCursor();
 
        $statement = $db->prepare($query4);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':transID', $transID);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':flatAmount', $flatAmount);
        $statement->bindValue(':period', $period);
        $statement->bindValue(':numPayments', $numPayments);
        $statement->bindValue(':startDate', $startDate);
        $statement->execute();
        $statement->closeCursor();
 
        $statement = $db->prepare($query5);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':transID', $transID);
        $statement->bindValue(':service', $service);
        $statement->execute();
        header("Location:home.php");
        $statement->closeCursor();

    

}

function fetchTransaction($userID, $transID) {
    global $db;
    $query = "SELECT * FROM transaction WHERE userID = :userID AND transID = :transID";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':transID', $transID);
    $statement->execute();
    $result = $statement->fetch(); 
    $statement->closeCursor();
    
    $name = $result['name'];
    echo "<p>$name<\p>";
    return $result;
}

?>
