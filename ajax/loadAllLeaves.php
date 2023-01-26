<?php 

    require "../includes/connection.php";
    $response = array();
    $response["html"] = "";
    $count = 1;

    $sql = $conn->prepare("SELECT * FROM dbo.leaveList");
    $sql->execute();
    while($row = $sql->fetch()){

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

        $filePaths = unserialize(($row["filePaths"]));

        if(empty($filePaths)){
            $filePaths = "Empty";
        }else{
            $filePaths = "<button class='btn btn-info viewLeaveImage' data-id='".$row["id"]."'><i class='fa fa-image'>&nbsp;</i></button>";
        }

        $response["html"] .= "
            <tr>
                <td class='border border-top border-bottom'>". $count++ ."</td>
                <td class='border border-top border-bottom'>$row[employeeID]</td>
                <td class='border border-top border-bottom'>$fullName</td>
                <td class='border border-top border-bottom'>$position</td>
                <td class='border border-top border-bottom'>$department</td>
                <td class='border border-top border-bottom'>$leaveType</td>
                <td class='border border-top border-bottom'>$row[dateFrom]</td>
                <td class='border border-top border-bottom'>$row[numDays]</td>
                <td class='border border-top border-bottom'>$filePaths</td>
                <td class='border border-top border-bottom'><button class='btn btn-info viewEmpLeave' data-id='".$row["id"]."'><i class='fa fa-eye'></i></button></td>
            </tr>
        ";

    }

    echo json_encode($response);

?>