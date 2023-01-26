<?php 

    if(isset($_POST["leaveID"])){
        require "../includes/connection.php";

        session_start();
        $employeeID     = $_SESSION["employeeID"];
        $leaveID        = $_POST["leaveID"];
        $status         = "Approved";
        $response       = array();
        $error = 0;

        $sql = $conn->prepare("SELECT * FROM dbo.leaveList WHERE id=:id");
        $sql->execute([ "id" => $leaveID ]);
        $row = $sql->fetch();
        $signaturePaths = empty($row["signaturePaths"]) ? array() : unserialize($row["signaturePaths"]);
        $approvalsID = unserialize($row["signatureID"]);
        $lastAppr = end($approvalsID);
        $signaturePaths[$employeeID] = $status;
        $signaturePaths = serialize($signaturePaths);

        if($employeeID == $lastAppr){
            $sqlA = $conn->prepare("UPDATE dbo.leaveList SET signaturePaths=:signaturePaths, status=:status WHERE id=:id");
            if(!$sqlA->execute([
                "signaturePaths"    => $signaturePaths,
                "status"            => $status,
                "id"                => $leaveID
            ]))
                $error++;
        }else{
            $sqlA = $conn->prepare("UPDATE dbo.leaveList SET signaturePaths=:signaturePaths WHERE id=:id");
            if(!$sqlA->execute([
                "signaturePaths" => $signaturePaths,
                "id"    => $leaveID
            ]))
                $error++;
        }
        
        if($error == 0){
            $response["result"] = true;
            $response["msg"] = "Successfully Approved Leave Request";
        }else{
            $response["result"] = false;
            $response["msg"] = "Server Error, Try Again Later";
        }
        echo json_encode($response);
    }

?>