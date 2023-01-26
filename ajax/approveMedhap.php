<?php 

    if(isset($_POST["medhapID"])){
        require "../includes/connection.php";

        session_start();
        $employeeID     = $_SESSION["employeeID"];
        $medhapID        = $_POST["medhapID"];
        $status         = "Approved";
        $response       = array();
        $error = 0;

        $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE id=:id");
        $sql->execute([ "id" => $medhapID ]);
        $row = $sql->fetch();
        $approvalsStatus = empty($row["approvalsStatus"]) ? array() : unserialize($row["approvalsStatus"]);
        $approvalsID = unserialize($row["approvalsID"]);

        $invalid = false;
        foreach($approvalsStatus as $id => $val){
            if($val == "Disapproved")
                $invalid = true;
        }

        if(!$invalid){
            $approvalsStatus[$employeeID] = $status;

            if(count($approvalsStatus) == 3){
                
                $approvalsStatus = serialize($approvalsStatus);
                $sqlA = $conn->prepare("UPDATE dbo.medhapReq SET approvalsStatus=:approvalsStatus, status=:status WHERE id=:id");
                if(!$sqlA->execute([
                    "approvalsStatus"   => $approvalsStatus,
                    "status"            => $status,
                    "id"                => $medhapID
                ]))
                    $error++;
            }else{
                $approvalsStatus = serialize($approvalsStatus);
                $sqlA = $conn->prepare("UPDATE dbo.medhapReq SET approvalsStatus=:approvalsStatus WHERE id=:id");
                if(!$sqlA->execute([
                    "approvalsStatus" => $approvalsStatus,
                    "id"    => $medhapID
                ]))
                    $error++;
            }
        
            if($error == 0){
                $response["result"] = true;
                $response["msg"] = "Successfully Approved MED-HAP Request";
            }else{
                $response["result"] = false;
                $response["msg"] = "Server Error, Try Again Later";
            }
        }else{
            $response["result"] = false;
            $response["msg"] = "HR or Other Chief Disapproved the request.";
        }
        echo json_encode($response);
    }

?>