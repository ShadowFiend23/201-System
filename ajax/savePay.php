<?php 

    if(isset($_POST["leaveID"]) && isset($_POST["payVal"]) && isset($_POST['note'])){
        require "../includes/connection.php";


        $leaveID    = $_POST["leaveID"];
        $payVal     = $_POST["payVal"] == "With Pay" ? 1 : 2;
        $note       = $_POST["note"];
        $response   = array();
        $error      = 0;

        $sql = $conn->prepare("UPDATE dbo.leaveList SET pay=:payVal, note=:note WHERE id=:id");
        if(!$sql->execute([
            "payVal"    => $payVal,
            "note"      => $note,
            "id"        => $leaveID
        ]))
            $error++;

        if($error == 0){
            $response["result"] = true;
            $response["msg"]    = "Successfully Updated.";
        }else{
            $response["result"] = false;
            $response["msg"]    = "Server Error. Try Again Later.";
        }
        echo json_encode($response);
    }    

?>