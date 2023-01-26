<?php 

    require "../includes/connection.php";
    $response = array();
    $response["html"] = "";
    $count = 1;

    $sql = $conn->prepare("SELECT * FROM dbo.employee_info ORDER by lastName");
    $sql->execute();
    while($row = $sql->fetch()){
        $middleName = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
        $fullName = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";

        $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
        $sqlP->execute([ "id" => $row["position"]]);
        $rowP = $sqlP->fetch();

        $sqlD = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:id");
        $sqlD->execute([ "id" => $row["department"]]);
        $rowD = $sqlD->fetch();

        
        $response["html"] .= "
            <tr>
                <td class='border border-top border-bottom'>". $count++ ."</td>
                <td class='border border-top border-bottom'>$fullName</td>
                <td class='border border-top border-bottom'>$rowP[position]</td>
                <td class='border border-top border-bottom'>$rowD[name]</td>
                <td class='border border-top border-bottom'><a href='viewEmployee.php?id=$row[id]' target='_blank'><button class='btn btn-info view'><i class='fa fa-eye'></i></button></a></td>
            </tr>
        ";

    }

    echo json_encode($response);

?>