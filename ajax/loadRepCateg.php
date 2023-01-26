<?php 

    if(isset($_POST["reportType"])){
        require "../includes/connection.php";

        $reportType = $_POST["reportType"];

        if($reportType == "leave"){
            $sql = $conn->prepare("SELECT * FROM dbo.leaveType");
        }else if($reportType == "medhap"){
            $sql = $conn->prepare("SELECT * FROM dbo.medhapType");
        }

        $sql->execute();
        while($row = $sql->fetch()){
            echo "<option id='$row[id]'>$row[name]</option>";
        }   
    }

?>