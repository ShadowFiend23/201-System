<?php 

    require "../includes/connection.php";

    session_start();
    $employeeID = $_SESSION["employeeID"];
    $html = "";

    $sql = $conn->prepare("SELECT * FROM dbo.dependents WHERE employeeID=:employeeID");
    $sql->execute([
        "employeeID"    => $employeeID
    ]);
    while($row = $sql->fetch()){
        $html .= "<option value='$row[id]'>". ucwords($row["fullName"]) ." (". ucfirst($row["relation"]) .")</option>";
    }
    if(empty($html)){
        $html = "<option>No Available Dependents. (Please Add Dependents In Dashboard)</option>";
    }
    echo $html;
?>