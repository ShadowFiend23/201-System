<?php 

    if(isset($_POST["leaveID"]) && isset($_POST["signatoryPic"])){
        require "../includes/connection.php";

        session_start();
        $employeeID         = $_SESSION["employeeID"];
        $leaveID            = $_POST["leaveID"];
        $signaturePic       = $_POST["signatoryPic"];
        $response           = array();
        $error              = 0 ;
        $signatureFileName  = uniqid().'.png';
        $signature          = str_replace('data:image/png;base64,', '', $signaturePic);
        $signature          = str_replace(' ', '+', $signature);
        $data               = base64_decode($signature);
        $signature          = '../signatures/'.$signatureFileName;
        file_put_contents($signature, $data);

        $sql = $conn->prepare("SELECT * FROM dbo.leaveList WHERE id=:id");
        $sql->execute([
            "id"    => $leaveID
        ]);
        $row = $sql->fetch();
        if(!empty($row["signaturePaths"])){
            $signaturePaths = unserialize($row["signaturePaths"]);
            $signaturePaths[$employeeID] = $signature;
        }else{
            $signaturePaths = array();
            $signaturePaths[$employeeID] = $signature;
        }
        $signaturePaths = serialize($signaturePaths);
        $sql = $conn->prepare("UPDATE dbo.leaveList SET signaturePaths=:signaturePaths WHERE id=:id");
        if(!$sql->execute([
            "signaturePaths"    => $signaturePaths,
            "id"                => $leaveID
        ]))
            $error++;

        if($error == 0){
            $response["result"] = true;
            $response["msg"] = "Successfully Added Signature.";
        }else{
            $response["result"] = false;
            $response["msg"] = "Server Error. Please Try Again Later.";
        }
        echo json_encode($response);
    }

?>