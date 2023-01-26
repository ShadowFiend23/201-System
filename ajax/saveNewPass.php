<?php 

    if(isset($_POST["newPass"]) && isset ($_POST["userID"])){

        require "../includes/connection.php";

        $password = password_hash($_POST["newPass"], PASSWORD_DEFAULT);
        $userID = $_POST["userID"];
        $response = array();
        $error = 0;
        $sql = $conn->prepare("UPDATE dbo.login SET password=:password WHERE userID=:userID");
        if(!$sql->execute([
            "password"  => $password,
            "userID"        => $userID
        ]))
            $error++;

        $sql = $conn->prepare("SELECT * FROM dbo.login WHERE userID=:userID");
        if(!$sql->execute([
            "userID"    => $userID
        ]))
            $error++;


        $row = $sql->fetch();

        if($error == 0){
            $response["result"] = true;
            $response["msg"]    = "Successfully Registered New Password";
            
            $response["type"] = $row["type"];
            $response["userID"] = $row["id"];

            session_start();
            $_SESSION["userID"] = $row["id"];
            $_SESSION["type"] = $row["type"];
            $_SESSION["employeeID"] = $userID;

            if($row["type"] == "admin")
                $response["link"] = "http://201.occcicoop.com/";
            else{
                $response["link"] = "http://201.occcicoop.com/employee.php";
            }
                

        }else{
            $response["result"] = false;
            $response["msg"]   = "Server Error. Try Again Later";
        }
        echo json_encode($response);

    }

?>