<?php 

    if($_POST["leaveID"]){

        require "../includes/connection.php";


        $leaveID = $_POST["leaveID"];
        $response = array();

        $sql = $conn->prepare("SELECT * FROM dbo.leaveList WHERE id=:id");
        if($sql->execute([
            "id"    => $leaveID
        ])){
            $row = $sql->fetch();
            $filePaths = unserialize($row["filePaths"]);

            if(!empty($filePaths)){

                $response["result"] = true;
                $response["count"] = count($filePaths);
                $response["paths"] = array();
                for($i = 0; $i < count($filePaths); $i++)
                    array_push($response["paths"],$filePaths[$i]);
                

            }else{

                $response["result"] = false;
                $response["msg"] = "No Attachments Found.";

            }
        }else{

            $response["result"] = false;
            $response["msg"] = "Couldn't Find Leave Request.";

        }
        echo json_encode($response);
    }

?>