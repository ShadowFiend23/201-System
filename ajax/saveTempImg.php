<?php 

    function cancelUp($list){
        for($i=0; $i<count($list); $i++){
            unlink($list[$i]);
        }
    }

    if(isset($_FILES["files"])){
        $response = array();
        $allowed = array("image/jpeg", "image/jpg", "image/png");
        $pathList = array();
        for($i=0; $i<count($_FILES["files"]["name"]); $i++){
            $type = $_FILES["files"]["type"][$i];
            if(!in_array($type,$allowed)) {
                $response["result"] = false;
                $response["msg"]    = "Invalid Image. Select jpeg, jpg and png image only.";
                if(!empty($pathList)){
                    cancelUp($pathList);
                    $pathList = array();
                } 
                break;
            } else {
                $fileType = strtolower(pathinfo(basename($_FILES["files"]["name"][$i]),PATHINFO_EXTENSION));
                $path = "../temp/" . uniqid() . ".$fileType";
                if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $path)) {
                    array_push($pathList,$path);
                } else {
                    if(!empty($pathList)){
                        cancelUp($pathList);
                        $pathList = array();
                    } 
                    break;
                }
            }
        }
        if(!empty($pathList)){
            $response["result"] = true;
            $response["paths"] = $pathList;
        }else{
            $response["result"] = false;
            $response["msg"] = "Server error when uploading files.";
        }
        echo json_encode($response);
    }

?>