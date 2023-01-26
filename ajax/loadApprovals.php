<?php 
    

    require "../includes/connection.php";
    session_start();
    $employeeID         = $_SESSION["employeeID"];
    $response           = array();
    $response["html"]   = "";
    $count              = 1;
    $stat               = "Pending";

    $sql = $conn->prepare("SELECT * FROM dbo.leaveList WHERE status=:status");
    $sql->execute([ "status" => $stat]);
    while($row = $sql->fetch()){
        $signatory = unserialize($row["signatureID"]);

        if(in_array($employeeID,$signatory)){
            if(!empty($row["signaturePaths"])){
                $paths = unserialize($row["signaturePaths"]);
                if(!array_key_exists($employeeID,$paths)){
                    $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlE->execute([
                        "employeeID"    => $row["employeeID"]
                    ]);
                    $rowE = $sqlE->fetch();

                    $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                    $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";

                    $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                    $sqlP->execute([
                        "id" => $rowE["position"]
                    ]);
                    $rowP = $sqlP->fetch();
                    $position = $rowP["position"];

                    $sqlD = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:id");
                    $sqlD->execute([
                        "id" => $rowE["department"]
                    ]);
                    $rowD = $sqlD->fetch();
                    $department = ucwords($rowD["name"]);

                    $sqlT = $conn->prepare("SELECT * FROM dbo.leaveType WHERE id=:id");
                    $sqlT->execute([
                        "id" => $row["leaveType"]
                    ]);
                    $rowT = $sqlT->fetch();
                    $leaveType = $rowT["name"];

                    $response["html"] .= "
                        <tr>
                            <td class='border border-top border-bottom'>". $count++ ."</td>
                            <td class='border border-top border-bottom'>$fullName</td>
                            <td class='border border-top border-bottom'>$position</td>
                            <td class='border border-top border-bottom'>$department</td>
                            <td class='border border-top border-bottom'>$leaveType</td>
                            <td class='border border-top border-bottom'>$row[dateFrom]</td>
                            <td class='border border-top border-bottom'>$row[numDays]</td>
                        <td class='border border-top border-bottom'><a href='viewSignatory.php?id=$row[id]' target='_blank'><button class='btn btn-info'><i class='fa fa-eye'></i></button></a></td>
                        </tr>
                    ";
                }
            }else{

                $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                $sqlE->execute([
                    "employeeID"    => $row["employeeID"]
                ]);
                $rowE = $sqlE->fetch();

                $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";

                $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                $sqlP->execute([
                    "id" => $rowE["position"]
                ]);
                $rowP = $sqlP->fetch();
                $position = $rowP["position"];

                $sqlD = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:id");
                $sqlD->execute([
                    "id" => $rowE["department"]
                ]);
                $rowD = $sqlD->fetch();
                $department = ucwords($rowD["name"]);

                $sqlT = $conn->prepare("SELECT * FROM dbo.leaveType WHERE id=:id");
                $sqlT->execute([
                    "id" => $row["leaveType"]
                ]);
                $rowT = $sqlT->fetch();
                $leaveType = $rowT["name"];

                $response["html"] .= "
                    <tr>
                        <td class='border border-top border-bottom'>". $count++ ."</td>
                        <td class='border border-top border-bottom'>$fullName</td>
                        <td class='border border-top border-bottom'>$position</td>
                        <td class='border border-top border-bottom'>$department</td>
                        <td class='border border-top border-bottom'>$leaveType</td>
                        <td class='border border-top border-bottom'>$row[dateFrom]</td>
                        <td class='border border-top border-bottom'>$row[numDays]</td>
                        <td class='border border-top border-bottom'><a href='viewSignatory.php?id=$row[id]' target='_blank'><button class='btn btn-info'><i class='fa fa-eye'></i></button></a></td>
                    </tr>
                ";
            }
        }
    }
    echo json_encode($response);

?>