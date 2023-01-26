<?php 

    if(isset($_POST["id"])){
        require "../includes/connection.php";

        $id         = $_POST["id"];
        $status     = "Approved";
        $response   = array();


        $sql = $conn->prepare("UPDATE dbo.reRequest SET status=:status WHERE id=:id");
        if($sql->execute([
            "status"    => $status,
            "id"        => $id
        ])){
            $sql = $conn->prepare("SELECT * FROM dbo.reRequest WHERE id=:id");
            $sql->execute([ 
                "id"    => $id
            ]);
            $row = $sql->fetch();
            $medhapID = $row["medhapID"];
            $reqAmount = $row["amount"];

            $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE id=:id");
            $sql->execute([
                "id"    => $medhapID
            ]);
            $row = $sql->fetch();

            $totalAmount = $row["amount"] + $reqAmount;

            $sql = $conn->prepare("UPDATE dbo.medhapReq SET amount=:amount WHERE id=:id");
            if($sql->execute([
                "amount"    => $totalAmount,
                "id"        => $medhapID
            ])){

                $response["result"] = true;
                $response["msg"] = "Successfully Approved Request.";

            }else{

                $response["result"] = false;
                $response["msg"] = "Server Error. Try Again Later.";

            }
        }else{
            $response["result"] = false;
            $response["msg"] = "Server Error. Try Again Later.";
        }

        echo json_encode($response);
    }

?>