<?php 

    if(isset($_POST["id"]) && isset($_POST["amount"]) && isset($_POST["slctFiles"])){

        require "../includes/connection.php";

        $id         = $_POST["id"];
        $amount     = $_POST["amount"];
        $files      = $_POST["slctFiles"];
        $response   = array();

        if(!is_numeric($amount)){

            $response["result"] = false;
            $response['msg'] = "Please Write The Tmount Used.";

        }else if(empty($files)){

            $response["result"] = false;
            $response['msg'] = "Please Select Atleast 1 File.";

        }else{

            $sql = $conn->prepare("SELECT amount FROM dbo.medhapReq WHERE id=:id");
            $sql->execute([ "id" => $id ]);
            $row = $sql->fetch();
            if($amount > $row["amount"]){
                $response["result"] = false;
                $response["msg"] = "Amount Exceed From The Requested Amount.";
            }else{
                $files = serialize($files);
                $status = "Liquidated";

                $sql = $conn->prepare("UPDATE dbo.medhapReq SET used=:used, status=:status, liquidate=:liquidate WHERE id=:id");
                if($sql->execute([
                    "used"      => $amount,
                    "status"    => $status,
                    "liquidate" => $files,
                    "id"        => $id
                ])){
                    $response["result"] = true;
                    $response["msg"]    = "Successfully Liquidated The Request.";
                }else{
                    $response["result"] = false;
                    $response["msg"]    = "Server Error. Try Again Later.";
                }
            }

        }

        echo json_encode($response);
    }

?>