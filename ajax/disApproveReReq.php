<?php 

    if(isset($_POST["id"]) && isset($_POST["reason"])){
        require "../includes/connection.php";

        $id         = $_POST["id"];
        $reason     = $_POST["reason"];
        $status     = "Disapproved";
        $response   = array();


        $sql = $conn->prepare("UPDATE dbo.reRequest SET status=:status, reason=:reason WHERE id=:id");
        if($sql->execute([
            "status"    => $status,
            "reason"    => $reason,
            "id"        => $id
        ])){

            $response["result"] = true;
            $response["msg"] = "Successfully Disapproved Request.";

        }else{

            $response["result"] = false;
            $response["msg"] = "Server Error. Try Again Later.";

        }

        echo json_encode($response);
    }

?>