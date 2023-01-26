<?php

    if(isset($_POST["employeeID"]) && isset($_POST["firstName"])  && isset($_POST["lastName"]) &&
        isset($_POST["dateHired"]) && isset($_POST["position"]) && isset($_POST["department"]) &&
        isset($_POST["supervisor"]) && isset($_POST["chief"]) && isset($_POST["rank"])){

        require "../includes/connection.php";

        $employeeID     = $_POST['employeeID'];
        $firstName      = $_POST["firstName"];
        $lastName       = $_POST["lastName"];
        $middleName     = $_POST["middleName"];
        $dateHired      = date("Y-m-d",strtotime($_POST["dateHired"]));
        $position       = $_POST["position"];
        $department     = $_POST["department"];
        $supervisor     = $_POST["supervisor"];
        $chief          = $_POST["chief"];
        $rank           = $_POST["rank"];
        $error          = 0;

        $sql = $conn->prepare("INSERT INTO dbo.employee_info (employeeID,lastName,firstName,middleName,dateHired,position,department,supervisor,chief,rank) 
        VALUES (:employeeID,:lastName,:firstName,:middleName,:dateHired,:position,:department,:supervisor,:chief,:rank)");
        if(!$sql->execute([
            "employeeID"    => $employeeID,
            "lastName"      => $lastName,
            "firstName"     => $firstName,
            "middleName"    => $middleName,
            "dateHired"     => $dateHired,
            "position"      => $position,
            "department"    => $department,
            "supervisor"    => $supervisor,
            "chief"         => $chief,
            "rank"          => $rank
        ]))
            $error++;
        if($position == 12){
            $district = $_POST["district"];
            $sql = $conn->prepare("UPDATE dbo.districts SET manager=:manager WHERE id=:id");
            if(!$sql->execute([
                "manager"   => $employeeID,
                "id"        => $district
            ]))
                $error++;
        }

        if($error == 0){
            $pass = 1;
            $sql = $conn->prepare("INSERT INTO dbo.login (userID,password,type) VALUES (:userID,:password,:type)");
            if(!$sql->execute([ 
                "userID"    => $employeeID,
                "password"  => $pass,
                "type"      => $rank
            ]))
                $error++;
            
            if($error == 0){

                $response["result"] = true;
                $response["msg"]    = "Successfuly Added New Employee";

            }else{

                $response["result"] = false;
                $response["msg"]    = "Server Error. Try Again Later.";

            }
        }else{

            $response["result"] = false;
            $response["msg"]    = "Server Error. Try Again Later.";

        }

    }else{
        $response = array();
        $response["result"] = false;
        $response["msg"]    = "No Higher Ups Detected";
    }
    
    echo json_encode($response);
?>