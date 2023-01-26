<?php 

    if(isset($_POST["medhapType"])){

        require "../includes/connection.php";

        function inquireAvailable($employeeID,$years,$medhapType,$conn){
            $result = array();

            $sqlMed = $conn->prepare("SELECT COUNT(*) as count FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:medhapType");
            $sqlMed->execute([
                "employeeID"    => $employeeID,
                "medhapType"    => $medhapType
            ]);
            $rowS = $sqlMed->fetch();
            if($rowS["count"]){
                $status1 = "Pending";
                $status2 = "Approved";
                $sqlMed = $conn->prepare("SELECT COUNT(*) as count FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:medhapType AND status=:status1 OR status=:status2");
                $sqlMed->execute([
                    "employeeID"    => $employeeID,
                    "medhapType"    => $medhapType,
                    "status1"       => $status1,
                    "status2"       => $status2
                ]);
                $rowS = $sqlMed->fetch();
                if($rowS["count"] > 0){
                    $result["status"] = true;
                }else{
                    $result["status"] = false;
                    $status = "Liquidated";
                    $totalUsed = 0;
                    $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:medhapType AND status=:status");
                    $sql->execute([
                        "employeeID"    => $employeeID,
                        "medhapType"    => $medhapType,
                        "status"        => $status
                    ]);
                    while($row = $sql->fetch()){
                        $totalUsed += $row["used"];
                    }
                    $sql = $conn->prepare("SELECT * FROM dbo.medhapYear WHERE medhapType=:medhapType");
                    $sql->execute([ "medhapType" => $medhapType ]);
                    while($row = $sql->fetch()){
                        if($years >= $row["start"] && $years <= $row["ending"])
                            $availAmount = $row["amount"];
                    }
                    $result["amount"] = $availAmount - $totalUsed;
                }
            }else{
                $result["status"] = false;
                $sql = $conn->prepare("SELECT * FROM dbo.medhapYear WHERE medhapType=:medhapType");
                $sql->execute([ "medhapType" => $medhapType ]);
                while($row = $sql->fetch()){
                    if($years >= $row["start"] && $years <= $row["ending"])
                        $result["amount"] = $row["amount"];
                }
            }
            return $result;
        }
        
        session_start();
        $employeeID     = $_SESSION["employeeID"];
        $medhapType     = $_POST["medhapType"];
        $reqAmount      = $_POST["amount"];
        $dateRequest    = date("Y-m-d");
        $status         = "Pending";
        $response       = array();
        $error          = 0;
        $relation       = "";

        $sql = $conn->prepare("SELECT COUNT(*) as count FROM dbo.medhapType WHERE id=:id");
        $sql->execute(["id" => $medhapType]);
        $row = $sql->fetch();

        if($row["count"]){
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

            $result = inquireAvailable($employeeID,$years,$medhapType,$conn);

            if(!$result["status"]){ 
                if($reqAmount > $result["amount"]){
                    $response["result"] = false;
                    $response["msg"] = "Exceeded Request Amount Limit.";
                    $response["amount"] = $result["amount"];
                }else{

                    if($medhapType == 1){
                        $for = $_POST["for"];

                        if($for == "self"){
                            $relation = "self";
                        }else{
                            $relation = $_POST["dependents"];
                        }

                        $sql = $conn->prepare("SELECT count(*) as count FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:medhapType");
                        $sql->execute([
                            "employeeID" => $employeeID,
                            "medhapType" => $medhapType
                        ]);
                        $row = $sql->fetch();
                        if(!$row["count"]){
                            if($reqAmount > 10000)
                                $reqAmount = 10000;
                        }
                    }

                    $approvalsID = array();
                    $sql = $conn->prepare("SELECT dep.type,dep.id FROM dbo.employee_info as em INNER JOIN dbo.departments as dep
                    ON em.department=dep.id WHERE em.employeeID=:employeeID");
                    $sql->execute([
                        "employeeID" => $employeeID
                    ]);
                    $row = $sql->fetch();
                    $depType = $row["type"];
                    $depID   = $row["id"];

                    if($depType == "branch"){
                        $position = 3;
                        $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE position=:position AND department=:department");
                        $sql->execute([
                            "position"      => $position,
                            "department"    => $depID
                        ]);
                        $row = $sql->fetch();
                        $bManager = $row["employeeID"];
                        array_push($approvalsID,$bManager);
                    }
                    $type = "admin";
                    $sql = $conn->prepare("SELECT * FROM dbo.login WHERE type=:type");
                    $sql->execute([ "type" => $type]);
                    $row = $sql->fetch();
                    $adminID = $row["userID"];
                    array_push($approvalsID,$adminID);

                    $position = 5;
                    $depCAO = 49;
                    $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE position=:position AND department=:department");
                    $sql->execute([
                        "position"      => $position,
                        "department"    => $depCAO
                    ]);
                    $row = $sql->fetch();
                    $CAO = $row["employeeID"];
                    array_push($approvalsID,$CAO);

                    $position = 6;
                    $depCFO = 48;
                    $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE position=:position AND department=:department");
                    $sql->execute([
                        "position"      => $position,
                        "department"    => $depCFO
                    ]);

                    $row = $sql->fetch();
                    $CFO = $row["employeeID"];
                    array_push($approvalsID,$CFO);

                    $approvalsID = serialize($approvalsID);
                    $sql = $conn->prepare("INSERT INTO dbo.medhapReq (employeeID,medhapType,amount,dateRequest,status,approvalsID,relation)
                    VALUES (:employeeID,:medhapType,:amount,:dateRequest,:status,:approvalsID,:relation)");
                    if(!$sql->execute([
                        "employeeID"    => $employeeID,
                        "medhapType"    => $medhapType,
                        "amount"        => $reqAmount,
                        "dateRequest"   => $dateRequest,
                        "status"        => $status,
                        "approvalsID"   => $approvalsID,
                        "relation"      => $relation
                    ]))
                        $error++;

                    if($error == 0){
                        $response["result"] = true;
                        $response["msg"] = "Successfully Sent A Request.";
                    }else{
                        $response["result"] = false;
                        $response["msg"] = "Server Error. Try Again Later.";
                    }
                }

            }else{
                $response["result"] = false;
                $response["msg"] = "A Request Is Already Pending/Approved";
            }

        }else{
            $response["result"] = false;
            $response["msg"] = "Invalid MED-HAP Type.";
        }
        echo json_encode($response);
    }

?>