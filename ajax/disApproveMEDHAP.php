<?php 

    if(isset($_POST["medhapID"]) && isset($_POST["reason"])){
        require "../includes/connection.php";

        session_start();
        $employeeID = $_SESSION["employeeID"];
        $medhapID = $_POST["medhapID"];
        $reason = $_POST["reason"];
        $status = "Disapproved";
        $response = array();
        $error = 0;

        $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE id=:id");
        $sql->execute([ "id" => $medhapID ]);
        $row = $sql->fetch();
        $approvalsStatus = empty($row["approvalsStatus"]) ? array() : unserialize($row["approvalsStatus"]);
        $approvalsStatus[$employeeID] = $status;
        $approvalsStatus = serialize($approvalsStatus);

        $sql = $conn->prepare("UPDATE dbo.medhapReq SET approvalsStatus=:approvalsStatus, status=:status, reason=:reason WHERE id=:id");
        if(!$sql->execute([
            "approvalsStatus"    => $approvalsStatus,
            "status"            => $status,
            "reason"            => $reason,
            "id"                => $medhapID
        ]))
            $error++;
        
        if($error == 0){
            $response["result"] = true;
            $response["msg"] = "Successfully Disapproved MED-HAP Request";
        }else{
            $response["result"] = true;
            $response["msg"] = "Server Error, Try Again Later";
        }
        echo json_encode($response);
    }

?>