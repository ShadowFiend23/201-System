<?php 

    if(isset($_POST["leaveID"]) && isset($_POST["reason"])){
        require "../includes/connection.php";

        session_start();
        $employeeID = $_SESSION["employeeID"];
        $leaveID = $_POST["leaveID"];
        $reason = $_POST["reason"];
        $status = "Disapproved";
        $response = array();
        $error = 0;

        $sql = $conn->prepare("SELECT * FROM dbo.leaveList WHERE id=:id");
        $sql->execute([ "id" => $leaveID ]);
        $row = $sql->fetch();
        $signaturePaths = empty($row["signaturePaths"]) ? array() : unserialize($row["signaturePaths"]);
        $signaturePaths[$employeeID] = $status;
        $signaturePaths = serialize($signaturePaths);

        $sql = $conn->prepare("UPDATE dbo.leaveList SET signaturePaths=:signaturePaths, status=:status, disAppReason=:reason WHERE id=:id");
        if(!$sql->execute([
            "signaturePaths"    => $signaturePaths,
            "status"            => $status,
            "reason"            => $reason,
            "id"                => $leaveID
        ]))
            $error++;
        
        if($error == 0){
            $response["result"] = true;
            $response["msg"] = "Successfully Disapproved Leave Request";
        }else{
            $response["result"] = true;
            $response["msg"] = "Server Error, Try Again Later";
        }
        echo json_encode($response);
    }

?>