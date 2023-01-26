<?php 

    if(isset($_FILES["imgFile"])){

        require "../includes/connection.php";

        session_start();
        $employeeID     = $_SESSION["employeeID"];
        $target_file    = "../profiles/". basename($_FILES["imgFile"]["name"]);
        $response       = array();
        $imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        
        $check = getimagesize($_FILES["imgFile"]["tmp_name"]);
        if($check !== false) {
            
            if (move_uploaded_file($_FILES["imgFile"]["tmp_name"], $target_file)) {
                $sql = $conn->prepare("UPDATE dbo.employee_info SET profile=:profile WHERE employeeID=:employeeID");
                if($sql->execute([
                    "profile"       => $target_file,
                    "employeeID"    => $employeeID
                ])){

                    $response["result"] = true;
                    $response["msg"] = "Successfully Updated Profile.";

                }else{
                    $response["result"] = false;
                    $response["msg"] = "Server Error. Try Again Later.";
                }

            }else{

                $response["result"] = false;
                $response["msg"] = "Server Error. Try Again Later.";

            }
            

        } else {
            $response["result"] = false;
            $response["msg"] = "Selected File Is Not An Image";
            $response["type"] = $imageFileType;
        }
        
        echo json_encode($response);
    }

?>