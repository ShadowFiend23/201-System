<?php 

    if(isset($_POST["leaveID"]) && isset($_POST["remarks"])){
        require "../includes/connection.php";

        $leaveID = $_POST["leaveID"];
        $remarks = $_POST["remarks"];
        $status = "Disapproved";
        $response = array();
        $error = 0;

        $sql = $conn->prepare("UPDATE dbo.leaveList SET status=:status, note=:remarks WHERE id=:id");
        if(!$sql->execute([
            "status"            => $status,
            "remarks"           => $remarks,
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