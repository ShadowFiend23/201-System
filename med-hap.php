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
            <div class="card" id="requestMedAdminInfo">
                <ul class="nav nav-tabs card-header-tabs" style="margin-bottom:10px; margin-left: 0px;">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#adminMedhap" style="border-left:0;">MED-HAP</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#adminReRequest">Re-request</a></li>
                </ul>

                <div class="tab-content" style="padding:0 10px;">
                    <div id="adminMedhap" class="tab-pane fade-in active">
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
                                    <th class='border border-top border-bottom' style="">Liquidate</th>

                                </tr>
                            </thead>
                            <tbody id="med-hapTableList" class='small'>
                                <?php 
                                    $count = 0;
                                    $sql = $conn->prepare("SELECT employee.employeeID,employee.lastName,employee.firstName,employee.middleName,employee.position,
                                    employee.department, req.* FROM dbo.employee_info as employee INNER JOIN dbo.medhapReq as req 
                                    ON employee.employeeID=req.employeeID");
                                    $sql->execute();
                                    
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
                                        
                                        $liquiBtn = "";
                                        if($row["status"] == "Approved")
                                            $liquiBtn  = "<button class='btn btn-info liquiBtn' data-id='$row[id]' data-toggle='tooltip'
                                             data-placement='top' title='Liquidate'><i class='fa fa-archive'></i></button>";


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
                                            <td class='border border-top border-bottom'>$liquiBtn</td>
                                        </tr>";
                                    }
                                    if($count == 0)
                                        echo "<tr><td class='border border-top border-bottom' colspan='7'>No MED-HAP Request Found.</td></tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="adminReRequest" class="tab-pane fade-in">
                        <table class="table table-light table-hover border" id="med-hapTable" style="text-align: center;">
                            <thead class="thead-dark">
                                <tr>
                                    <th class='border border-top border-bottom' style=""></th>
                                    <th class='border border-top border-bottom' style="">Name</th>
                                    <th class='border border-top border-bottom' style="">Department</th>
                                    <th class='border border-top border-bottom' style="">Relation</th>
                                    <th class='border border-top border-bottom' style="">Old Amount</th>
                                    <th class='border border-top border-bottom' style="">Re-Request Amount</th>
                                    <th class='border border-top border-bottom' style="">Action</th>
                                </tr>
                            </thead>
                            <tbody id="med-hapTableList">
                                <?php 
                                    $status = "Pending";
                                    $count = 0;
                                    $sql = $conn->prepare("SELECT reReq.*,req.amount as oldAmount,req.relation FROM dbo.reRequest as reReq INNER JOIN
                                    dbo.medhapReq as req ON reReq.medhapID=req.id WHERE reReq.status=:status");
                                    $sql->execute([
                                        "status" => $status
                                    ]);
                                    while($row = $sql->fetch()){
                                        $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID = :employeeID");
                                        $sqlE->execute([
                                            "employeeID"    => $row["employeeID"]
                                        ]);
                                        $rowE = $sqlE->fetch();
                                        $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
                                        $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
                                        
                                        $sqlD = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:department");
                                        $sqlD->execute([ "department" => $rowE["department"]]);
                                        $rowD = $sqlD->fetch();
                                        $department = $rowD["type"] == "branch" ? $rowD["name"] ." Branch" : $rowD["name"];

                                        $relation = $row["relation"];
                                        if($relation !== "self"){

                                            $sqlDep = $conn->prepare("SELECT * FROM dbo.dependents WHERE id=:id");
                                            $sqlDep->execute([
                                                "id" => $relation
                                            ]);
                                            $rowDep = $sql->fetch();
                                            $relation = $rowDep["fullName"] . "<br>" . $rowDep["relation"];

                                        }
                                        $oldAmount = "₱ ".number_format($row["oldAmount"], 2);
                                        $amount = "₱ ".number_format($row["amount"], 2);
                                        echo "<tr>
                                                    <td class='border border-top border-bottom'>".++$count."</td>
                                                    <td class='border border-top border-bottom'>$fullName</td>
                                                    <td class='border border-top border-bottom'>$department</td>
                                                    <td class='border border-top border-bottom'>$relation</td>
                                                    <td class='border border-top border-bottom'>$oldAmount</td>
                                                    <td class='border border-top border-bottom'>$amount</td>
                                                    <td class='border border-top border-bottom'>
                                                        <button class='btn btn-info approveReRequest' data-id='$row[id]' data-amount='$amount' data-fullname='$fullName'>
                                                            <i class='fa fa-tasks'></i>
                                                        </button>
                                                    </td>
                                                </tr>";
                                    }

                                    if($count == 0){
                                        echo "<tr><td colspan='7'>No Re-request.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>