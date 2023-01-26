<?php

    date_default_timezone_set("Asia/Manila");
    
    $response = array();
    if($_POST["numDays"] <= 0){

        $response["result"] = false;
        $response["msg"] = "Invalid Number Of Days";

    }else if(isset($_POST["signaturePic"]) && isset($_POST["leaveType"]) && isset($_POST["dateFrom"]) &&
        isset($_POST["dateTo"]) && isset($_POST["numDays"]) && isset($_POST["reason"])){

        require "../includes/connection.php";

        function getManager($branch, $conn){
            $position = 3;
            $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE position=:position AND department=:department");
            $sql->execute([
                "position"      => $position,
                "department"    => $branch
            ]);
            $row = $sql->fetch();
            return $row["employeeID"];
        }
        function getDistrictManager($branch,$conn){
            $sql = $conn->prepare("SELECT code FROM dbo.departments WHERE id=:branch");
            $sql->execute([ "branch" => $branch ]);
            $row = $sql->fetch();
            $branch = $row["code"];

            $sql = $conn->prepare("SELECT * FROM dbo.districts");
            $sql->execute();
            while($row = $sql->fetch()){
                $branches = unserialize($row["branches"]);
                if(in_array($branch,$branches))
                    return $row["manager"];
            }
        }
        function getChief($conn){
            $position = 7;
            $department = 47;
            $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE position=:position AND department=:department");
            $sql->execute([
                "position"      => $position,
                "department"    => $department
            ]);
            $row = $sql->fetch();
            return $row["employeeID"];
        }
        function getBod($conn){
            $position = "BOD";
            $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE position=:position");
            $sql->execute([
                "position"      => $position
            ]);
            $row = $sql->fetch();
            return $row["employeeID"];
        }

        function ifBranch($days,$id,$branch,$position,$conn){
            $infos = array();
            if($position == 3){
                if($days <= 2){
                    $infos["signatory"] = array(getDistrictManager($branch,$conn));
                    $infos["count"] = 1;
                }else if($days > 2 && $days <= 30){
                    $infos["signatory"] = array(getDistrictManager($branch,$conn),getChief($conn));
                    $infos["count"] = 2;
                }else{
                    $infos["signatory"] = array(getDistrictManager($branch,$conn),getChief($conn));
                    $infos["count"] = 2;
                }
                
            }else{
                if($days <= 2){
                    $infos["signatory"] = array(getManager($branch,$conn),getDistrictManager($branch,$conn));
                    $infos["count"] = 2;
                }else if($days <= 30){
                    $infos["signatory"] = array(getManager($branch,$conn),getDistrictManager($branch,$conn),getChief($conn));
                    $infos["count"] = 3;
                }else{
                    $infos["signatory"] = array(getManager($branch,$conn),getDistrictManager($branch,$conn),getChief($conn),getBod($conn));
                    $infos["count"] = 4;
                }
            }
            return $infos;
        }
        function ifDep($days,$id,$department,$conn,$rank){
            $infos = array();
            if($rank == 3){

                $sql = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:department");
                $sql->execute([
                    "department"    => $department
                ]);
                $row = $sql->fetch();
                $headOffice = empty($row["headOffice"]) ? $department : $row["headOffice"];

                $chiefRank = 4;
                $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank=:rank");
                $sql->execute([
                    "department"    => $headOffice,
                    "rank"          => $chiefRank
                ]);
                $row = $sql->fetch();
                $chief = $row["employeeID"];
                $infos["signatory"] = array($chief);
                $infos["count"] = 1;
            }/*else if($days <= 2){
                $headRank = 3;
                $sql = $conn->prepare("SELECT * FROM dbo. employee_info WHERE department=:department AND rank=:rank");
                $sql->execute([
                    "department"    => $department,
                    "rank"          => $headRank
                ]);
                $row = $sql->fetch();
                $infos["signatory"] = array($row["employeeID"]);
                $infos["count"] = 1;
            }*/else{
                $headRank = 3;
                $sql = $conn->prepare("SELECT * FROM dbo. employee_info WHERE department=:department AND rank=:rank");
                $sql->execute([
                    "department"    => $department,
                    "rank"          => $headRank
                ]);
                $row = $sql->fetch();
                $head = $row["employeeID"];

                $sql = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:department");
                $sql->execute([
                    "department"    => $department
                ]);
                $row = $sql->fetch();
                $headOffice = empty($row["headOffice"]) ? $department : $row["headOffice"];

                $chiefRank = 4;
                $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE department=:department AND rank=:rank");
                $sql->execute([
                    "department"    => $headOffice,
                    "rank"          => $chiefRank
                ]);
                $row = $sql->fetch();
                $chief = $row["employeeID"];
                $infos["signatory"] = array($head,$chief);
                $infos["count"] = 2;
            }
            return $infos;
        }

        
        session_start();
        $error              = 0;
        $employeeID         = $_SESSION["employeeID"];
        $leaveType          = $_POST["leaveType"];
        $datePrepared       = date("Y-m-d");
        $dateFrom           = date("Y-m-d",strtotime($_POST["dateFrom"]));
        $dateTo             = date("Y-m-d",strtotime($_POST["dateTo"]));
        $numDays            = $_POST["numDays"];
        $signature          = $_POST['signaturePic'];
        $signatureFileName  = uniqid().'.png';
        $signature          = str_replace('data:image/png;base64,', '', $signature);
        $signature          = str_replace(' ', '+', $signature);
        $data               = base64_decode($signature);
        $signature          = '../signatures/'.$signatureFileName;
        $reason             = $_POST["reason"];
        file_put_contents($signature, $data);
        $sql = $conn->prepare("SELECT ei.*, dep.* FROM dbo.employee_info as ei INNER JOIN dbo.departments as dep
        ON ei.department=dep.id WHERE ei.employeeID=:employeeID");
        $sql->execute([
            "employeeID"    => $employeeID
        ]);
        $row = $sql->fetch();
        if($row["type"] == "branch"){

            $infos = ifBranch($numDays,$employeeID,$row["department"],$row["position"],$conn);
            $signatureID = serialize($infos["signatory"]);
            
        }else{

            $infos = ifDep($numDays,$employeeID,$row["department"],$conn,$row["rank"]);
            $signatureID = serialize($infos["signatory"]);
        }
        $status = "Pending";

        if(!empty($_FILES["attachments"])){

            $attachments = $_FILES["attachments"];
            $attachmentCount = count($attachments['name']);
            $allowed = array("image/jpeg", "image/gif", "image/jpeg", "image/png");
            $filePaths = array();

            for($i = 0; $i < $attachmentCount; $i++){
                
                $file_type = $attachments['type'][$i];

                if(!in_array($file_type, $allowed)) {

                    $response["result"] = false;
                    $response["msg"] = "Invalid Image Format.";

                }else{

                    $temp = $attachments['tmp_name'][$i];
                    $fileName =  $attachments['name'][$i];
                    $path = "../leaveImages/" . $fileName;

                    if(move_uploaded_file($temp, $path)) {

                        array_push($filePaths,$fileName);

                    }else{

                        $error++;

                    }

                }
                
            }
        }
        
        if($error == 0){
            $filePaths = serialize($filePaths);
            $sql = $conn->prepare("INSERT INTO dbo.leaveList (employeeID,datePrepared,dateFrom,dateTo,numDays,leaveType,
            signatureCount,userSignature,signatureID,status,reason,filePaths) VALUES (:employeeID,:datePrepared,:dateFrom,:dateTo,:numDays,:leaveType,
            :signatureCount,:userSignature,:signatureID,:status,:reason,:filePaths)");
            if(!$sql->execute([
                "employeeID"        => $employeeID,
                "datePrepared"      => $datePrepared,
                "dateFrom"          => $dateFrom,
                "dateTo"            => $dateTo,
                "numDays"           => $numDays,
                "leaveType"         => $leaveType,
                "signatureCount"    => $infos["count"],
                "userSignature"     => $signature,
                "signatureID"       => $signatureID,
                "status"            => $status,
                "reason"            => $reason,
                "filePaths"         => $filePaths
            ]))
                $error++;

            $signatureID = unserialize($signatureID);
            $notiStatus = "unread";
            $notiType   = "Leave";
            foreach($signatureID as $employID){
                $sql = $conn->prepare("INSERT INTO dbo.notify (employeeID,type,status) VALUES (:employeeID,:type,:status)");
                $sql->execute([
                    "employeeID"    => $employID,
                    "type"          => $notiType,
                    "status"        => $notiStatus
                ]);
            }


            if($error == 0){
                $response["result"] = true;
                $response["msg"] = "Successfully Added A Leave";
            }else{
                $response["result"] = false;
                $response["msg"] = "Server Error. Try Again Later";
            }
        }else{

            $response["result"] = false;
            $response["msg"] = "Server Error. Try Again Later";

        }
    }
    echo json_encode($response);
?>