<?php 

    require "session/sessionStaff.php";
    require "includes/connection.php";
    require "includes/header.php";
    $notiStatus = "read";
    $type       = "MedHAP";
    $sql = $conn->prepare("UPDATE dbo.notify SET status=:status WHERE employeeID=:employeeID AND type=:type");
    $sql->execute([
        "status"        => $notiStatus,
        "employeeID"    => $_SESSION["employeeID"],
        "type"          => $type
    ]);
    require "includes/sidebarStaff.php";

?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php 
            require "includes/topbar.php";
        ?>
        <!-- End of Topbar -->
        
        <!-- Begin Page Content -->
        <div class="container-fluid">
        <div class="container-fluid">
            <table class="table table-light table-hover border" id="med-hapTable" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th class='border border-top border-bottom' style=""></th>
                        <th class='border border-top border-bottom' style="">Name</th>
                        <th class='border border-top border-bottom' style="">Position</th>
                        <th class='border border-top border-bottom' style="">Department</th>
                        <th class='border border-top border-bottom' style="">Type</th>
                        <th class='border border-top border-bottom' style="">Status</th>
                        <th class='border border-top border-bottom' style="">View</th>
                    </tr>
                </thead>
                <tbody id="med-hapTableList">
                    <?php 
                        $count = 0;
                        $status = "Pending";
                        $sql = $conn->prepare("SELECT employee.employeeID,employee.lastName,employee.firstName,employee.middleName,employee.position,
                        employee.department, req.* FROM dbo.employee_info as employee INNER JOIN dbo.medhapReq as req 
                        ON employee.employeeID=req.employeeID WHERE req.status=:status");
                        $sql->execute([ "status" => $status]);
                        
                        while($row = $sql->fetch()){

                            $middleName = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
                            $fullName = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";

                            $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:id");
                            $sqlP->execute(["id" => $row["position"]]);
                            $rowP = $sqlP->fetch();
                            $position = $rowP["position"];

                            $sqlD = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:id");
                            $sqlD->execute(["id" => $row["department"]]);
                            $rowD = $sqlD->fetch();
                            $department = ucwords($rowD["name"]);

                            $sqlT = $conn->prepare("SELECT * FROM dbo.medhapType WHERE id=:id");
                            $sqlT->execute(["id" => $row["medhapType"]]);
                            $rowT = $sqlT->fetch();
                            $medhapType = $rowT["name"];

                            echo "<tr>
                                <td class='border border-top border-bottom'>".++$count."</td>
                                <td class='border border-top border-bottom'>$fullName</td>
                                <td class='border border-top border-bottom'>$position</td>
                                <td class='border border-top border-bottom'>$department</td>
                                <td class='border border-top border-bottom'>$medhapType</td>
                                <td class='border border-top border-bottom'>$row[status]</td>
                                <td class='border border-top border-bottom'>
                                    <a href='viewMedhapReq.php?id=".$row["id"]."' target='_blank'>
                                        <button class='btn btn-primary'><i class='fa fa-eye'></i></button>
                                    </a>
                                </td>
                            </tr>";
                        }
                        if($count == 0)
                            echo "<tr><td class='border border-top border-bottom' colspan='7'>No MED-HAP Request Found.</td></tr>";
                    ?>
                </tbody>
            </table>
            
        </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>