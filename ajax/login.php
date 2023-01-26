<?php

    if(isset($_POST["username"]) && isset($_POST["password"])){

        require "../includes/connection.php";

        $username = $_POST["username"];
        $password = $_POST["password"];
        $response = array();
        $error    = 0;

       $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.login WHERE userID=:username");
       $sql->execute([
           "username"   => $username
       ]);
       $row = $sql->fetch();

        if($row["count"] > 0 ){
            $sql = $conn->prepare("SELECT * FROM dbo.login WHERE userID=:username");
            if(!$sql->execute([
                "username"  => $username
            ]))
                $error++;
            
            $row = $sql->fetch();
            if($error == 0){
                if(($row["password"] == $password) && ($row["password"] == 1)){
                    $response["result"] = true;
                    $response["changePass"] = true;
                    $response["userID"] = $row["userID"];

                }else if (password_verify($password, $row['password'])) {
                    $response["result"] = true;
                    $response["msg"] = "Login Successfully";
                    $response["userID"] = $row["userID"];
                    $response["type"] = $row["type"];

                    
                    session_start();
                    $_SESSION["userID"] = $row["id"];
                    $_SESSION["type"] = $row["type"];
                    $_SESSION["employeeID"] = $username;

                }else{
                    $response["result"] = false;
                    $response["msg"] = "Invalid User Or Password";
                }
            }else{
                $response["result"] = false;
                $response["msg"] = "Invalid User Or Password";
            }
        }else{
            $response["result"] = false;
            $response["msg"] = "Invalid User Or Password";
        }
        

        echo json_encode($response);
        
    }

?>