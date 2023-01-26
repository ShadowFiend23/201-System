<?php 

    require "../includes/connection.php";
    session_start();
    $employeeID = $_SESSION["employeeID"];
    $response = array();
    $response["html"] = "";
    $count = 1;

    $sql = $conn->prepare("SELECT * FROM dbo.leaveList WHERE employeeID=:employeeID");
    $sql->execute([
        "employeeID" => $employeeID
    ]);
    while($row = $sql->fetch()){
        $sqlT = $conn->prepare("SELECT * FROM dbo.leaveType WHERE id=:id");
        $sqlT->execute([
            "id" => $row["leaveType"]
        ]);
        $rowT = $sqlT->fetch();
        $leaveType = $rowT["name"];
        
        $response["html"] .= "
            <tr>
                <td class='border border-top border-bottom'>". $count++ ."</td>
                <td class='border border-top border-bottom'>$leaveType</td>
                <td class='border border-top border-bottom'>$row[datePrepared]</td>
                <td class='border border-top border-bottom'>$row[dateFrom]</td>
                <td class='border border-top border-bottom'>$row[dateTo]</td>
                <td class='border border-top border-bottom'>$row[numDays]</td>
                <td class='border border-top border-bottom'>$row[status]</td>
                <td class='border border-top border-bottom'><a href='viewLeave.php?id=$row[id]' target='_blank'><button class='btn btn-info'><i class='fa fa-eye'></i></button></a></td>
            </tr>
        ";

    }

    echo json_encode($response);

?>