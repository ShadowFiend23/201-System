<?php 

    require "session/sessionAdmin.php";
    require "includes/connection.php";
    require "includes/header.php";
    require "includes/sidebarAdmin.php";

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
            
        <div class="container body" style="margin-top: 1.5rem;">
            <table class="table table-light table-hover border" id="profilesTable" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th class='border border-top border-bottom' style="width: 3%;"></th>
                        <th class='border border-top border-bottom' style="width: 12%;">ID No.</th>
                        <th class='border border-top border-bottom' style="width: 25%;">Name</th>
                        <th class='border border-top border-bottom' style="width: 13%;">Department</th>
                        <th class='border border-top border-bottom' style="width: 13%;">List</th>
                        <th class='border border-top border-bottom' style="width: 10%;">View</th>
                    </tr>
                </thead>
                <tbody id="profilesTableList" class="small">
                    <?php 
                    
                        $status = "Pending";
                        $count = 0;
                        $sql = $conn->prepare("SELECT prof.*,employ.* FROM dbo.profiles as prof INNER JOIN
                        dbo.employee_info as employ ON prof.employeeID=employ.employeeID WHERE prof.status=:status");
                        $sql->execute([
                            "status" => $status
                        ]);
                        while($row = $sql->fetch()){
                            $middleName     = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
                            $fullName = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";
                            
                            $sqlD = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:id");
                            $sqlD->execute([
                                "id" => $row["department"]
                            ]);
                            $rowD = $sqlD->fetch();
                            $department = ucwords($rowD["name"]);
                            
                            echo "
                                <tr>
                                    <td>".++$count."</td>
                                    <td>$row[employeeID]</td>
                                    <td>$fullName</td>
                                    <td>$department</td>
                                    <td></td>
                                    <td>
                                        <button class='btn btn-success'><i class='fa fa-eye'>&nbsp;</i></button>
                                    </td>
                                </tr>
                            ";

                        }
                    
                    ?>
                </tbody>
            </table>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>