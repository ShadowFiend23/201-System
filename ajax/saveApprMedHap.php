<?php

    if(isset($_POST["medHapID"])){
        require "../includes/connection.php";

        session_start();
        $employeeID = $_SESSION["employeeID"];
        $id = $_POST["medHapID"];
        $response = array();
        $error = 0;
        
        $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE id=:id");
        $sql->execute([
            "id"    => $id
        ]);
        $row = $sql->fetch();
        $approvalsID = unserialize($row["approvalsID"]);

        $approvalStatus = empty($row["approvalStatus"]) ? array() : unserialize($row["approvalStatus"]);
        $approvalStatus[$employeeID] = "Approved";

        $approvalStatus = serialize($approvalStatus);
        $sql = $conn->prepare("UPDATE dbo.medhapReq SET approvalsStatus=:approvalStatus WHERE id=:id");
        if(!$sql->execute([
            "approvalStatus"    => $approvalStatus,
            "id"                => $id
        ]))
            $error++;

        if($approvalsID[count($approvalsID)-1] == $employeeID){
            $status = "Approved";
            $sql = $conn->prepare("UPDATE dbo.medhapReq SET status=:status WHERE id=:id");
            if(!$sql->execute([
                "status"        => $status,
                "id"            => $id
            ]))
                $error++;
        }

        if($error == 0){
            $response["result"] = true;
            $response["msg"]    = "Successfully Approved Request.";
        }else{
            $response["result"] = false;
            $response["msg"]    = "Server Error. Try Again Later.";
        }

        echo json_encode($response);
    }

?>