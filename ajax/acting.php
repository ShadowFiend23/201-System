<?php 

    if(isset($_POST["check"]) && isset($_POST["employeeID"])){
        
        require "../includes/connection.php";
        
        $check      = $_POST["check"];
        $employeeID = $_POST["employeeID"];
        $response   = array();

        $sql = $conn->prepare("UPDATE dbo.employee_info SET acting=:check WHERE employeeID=:employeeID");
        if($sql->execute([
            "check"         => $check,
            "employeeID"    => $employeeID
        ])){

            $response["result"] = true;
            $response["msg"] = "Successfully Updated Employee.";
        }else{

            $response["result"] = false;
            $response["msg"] = "Server Error. Try Again Later";

        }

        echo json_encode($response);
    }
?>