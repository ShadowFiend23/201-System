<?php 

    if(isset($_POST["id"]) && isset($_POST["amount"])){
        require "../includes/connection.php";

        function inquireAvailable($years,$medhapType,$conn){
            $result = array();

            $sql = $conn->prepare("SELECT * FROM dbo.medhapYear WHERE medhapType=:medhapType");
            $sql->execute([ "medhapType" => $medhapType ]);
            while($row = $sql->fetch()){
                if($years >= $row["start"] && $years <= $row["ending"])
                    $availAmount = $row["amount"];
            }
            $result["amount"] = $availAmount;
            
            return $result;
        }

        session_start();
        $employeeID = $_SESSION["employeeID"];
        $id         = $_POST["id"];
        $amount     = $_POST["amount"];
        $response   = array();
        $error      = 0;

        $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
        $sql->execute([
            "employeeID"    => $employeeID
        ]);
        $row = $sql->fetch();
        
        $currentDate = date("Y-m-d");
        $date1 = new DateTime($row["dateHired"]);
        $date2 = new DateTime($currentDate);
        $interval = $date1->diff($date2);
        $years = $interval->y;

        $result = inquireAvailable($years,'1',$conn);

        if(is_numeric($amount)){

            $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE id=:id");
            $sql->execute([ "id" => $id ]);
            $row = $sql->fetch();
            $oldAmount = $row["amount"];
            
            $totalAmount = $oldAmount + $amount;
            if($totalAmount > $result["amount"]){
                $response["result"] = "Pending";
                $response["avail"]  = number_format((float)$result["amount"] - $oldAmount, 2, '.', ',');
            }else{

                $sql = $conn->prepare("SELECT count(*) as count FROM dbo.reRequest WHERE medhapID=:id");
                $sql->execute([
                    "id"    => $id
                ]);
                $row = $sql->fetch();

                if($row["count"] == 0){
                    $status = "Pending";
                    $sql = $conn->prepare("INSERT INTO dbo.reRequest (employeeID,medhapID,amount,dateReReq,status) VALUES (:employeeID,:id,:amount,:dateReReq,:status)");
                    if(!$sql->execute([
                        "employeeID"    => $employeeID,
                        "id"            => $id,
                        "amount"        => $amount,
                        "dateReReq"     => $currentDate,
                        "status"        => $status
                    ]))
                        $error++;

                    if($error == 0){
                        $response["result"] = true;
                        $response["msg"] = "Successfully Updated Request. Waiting For Approval.";
                    }else{
                        $response["result"] = false;
                        $response["msg"] = "Server Error. Try Again Later.";
                    }
                }else{
                    $response["result"] = false;
                    $response["msg"] = "Already Have A Pending Re-request.";
                }
            }
        }else{
            $response["result"] = false;
            $response["msg"]    = "Invalid Amount";
        }
        echo json_encode($response);
    }

?>