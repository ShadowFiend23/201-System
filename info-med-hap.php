<?php 

    require "session/sessionStaff.php";
    require "includes/connection.php";
    require "includes/header.php";
    require "includes/sidebarStaff.php";

?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php 
            function inquireAvailable($employeeID,$years,$medhapType,$conn){
                $result = array();
    
                $sqlMed = $conn->prepare("SELECT COUNT(*) as count FROM dbo.medhapReq WHERE employeeID=:employeeID");
                $sqlMed->execute([
                    "employeeID"   => $employeeID
                ]);
                $rowS = $sqlMed->fetch();
                if($rowS["count"]){
                    $status = "Liquidated";
                    $sqlMed = $conn->prepare("SELECT COUNT(*) as count FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:medhapType AND status=:status");
                    $sqlMed->execute([
                        "employeeID"    => $employeeID,
                        "medhapType"    => $medhapType,
                        "status"       => $status,
                    ]);
                    $rowS = $sqlMed->fetch();
                    if($rowS["count"] > 0){
                        $totalAmount = 0;
                        $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:medhapType AND status=:status");
                        $sql->execute([
                            "employeeID"    => $employeeID,
                            "medhapType"    => $medhapType,
                            "status"        => $status
                        ]);
                        while($row = $sql->fetch()){
                            $totalAmount += $row["used"];
                        }
                        $result["used"] = $totalAmount;
                    }else{
                        $result["used"] = 0;
                    }
                    $sql = $conn->prepare("SELECT * FROM dbo.medhapYear WHERE medhapType=:medhapType");
                    $sql->execute([ "medhapType" => $medhapType ]);
                    while($row = $sql->fetch()){
                        if($years >= $row["start"] && $years <= $row["ending"])
                            $result["amount"] = $row["amount"];
                    }

                }else{
                    $sql = $conn->prepare("SELECT * FROM dbo.medhapYear WHERE medhapType=:medhapType");
                    $sql->execute([ "medhapType" => $medhapType ]);
                    while($row = $sql->fetch()){
                        if($years >= $row["start"] && $years <= $row["ending"]){
                            $result["amount"] = $row["amount"];
                            $result["used"] = 0;
                        }
                    }
                }
                return $result;
            }


            require "includes/topbar.php";

            $results = array();
            $employeeID = $_SESSION["employeeID"];
            $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
            $sql->execute([
                "employeeID"    => $employeeID
            ]);
            $row = $sql->fetch();

            $currentDate = date("Y-m-d");
            $date1 = new DateTime($row["dateHired"]);
            $date2 = new DateTime($currentDate);
            $interval = $date1->diff($date2);
            $years = $interval->y;
            
            $sql = $conn->prepare("SELECT * FROM dbo.medhapType");
            $sql->execute();
            while($row = $sql->fetch()){
                $results[$row["name"]] = inquireAvailable($employeeID,$years,$row["id"],$conn);
            }
        ?>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="card" id="allMedhapInfo">
                <ul class="nav nav-tabs card-header-tabs" style="margin-bottom:10px;">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#allMedHapInfoTab" style="border-left:0;">Info</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#requestInfo">Request List</a></li>
                </ul>

                <div class="tab-content">
                    <!-- List OF MED-HAP-->
                    <div id="allMedHapInfoTab" class="tab-pane fade-in active table-responsive">
                        <table class="table table-light table-hover border" id="employeeMedhapTable" style="text-align: center;">
                            <thead class="thead-dark">
                                <tr>
                                    <th class='border border-top border-bottom'></th>
                                    <th class='border border-top border-bottom'>Type</th>
                                    <th class='border border-top border-bottom'>Amount</th>
                                    <th class='border border-top border-bottom'>Used</th>
                                    <th class='border border-top border-bottom'>Balance</th>
                                </tr>
                            </thead>
                            <tbody id="employeeMedhapTableList">
                                <?php 
                                    $count = 1;

                                    foreach ($results as $type => $val) {
                                        if(!empty($val)){
                                            $amount =  "₱ ".number_format($val["amount"], 2);
                                            $used = "₱ ".number_format($val["used"], 2);
                                            $balance = $val["amount"] - $val["used"];
                                            $balance = "₱ ".number_format($balance, 2);
                                            echo "<tr>
                                                <td class='border border-top border-bottom'>".$count++."</td>
                                                <td class='border border-top border-bottom'>$type</td>
                                                <td class='border border-top border-bottom'>$amount</td>
                                                <td class='border border-top border-bottom'>$used</td>
                                                <td class='border border-top border-bottom'>$balance</td>
                                            </tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Request List-->
                    <div id="requestInfo" class="tab-pane fade-in">
                        <div class="card" id="requestMedAllInfo">
                            <ul class="nav nav-tabs card-header-tabs" style="margin-bottom:10px;">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#hospitalInfo" style="border-left:0;">Hospitalization</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eyecareInfo">Eye Care</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#checkupInfo">Check-Up</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reRequestInfo">Re-Request</a></li>
                            </ul>

                            <div class="tab-content">
                                <!-- Hospital Info -->
                                <div id="hospitalInfo" class="tab-pane fade-in active table-responsive">
                                    <table class="table table-light table-hover border" id="employeeMedReqTable" style="text-align: center;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class='border border-top border-bottom'></th>
                                                <th class='border border-top border-bottom'>Name</th>
                                                <th class='border border-top border-bottom'>Relation</th>
                                                <th class='border border-top border-bottom'>Date Requested</th>
                                                <th class='border border-top border-bottom'>Amount</th>
                                                <th class='border border-top border-bottom'>Used</th>
                                                <th class='border border-top border-bottom'>Status</th>
                                                <th class='border border-top border-bottom'>Re-Request</th>
                                            </tr>
                                        </thead>
                                        <tbody class="small" id="employeeMedhapTableList">
                                            <?php 
                                                $count = 1;
                                                $hospital = 1;
                                                $sql = $conn->prepare("SELECT count(*) as count FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:hospital");
                                                $sql->execute([
                                                    "employeeID"    => $employeeID,
                                                    "hospital"      => $hospital
                                                ]);
                                                $row = $sql->fetch();
                                                if($row["count"]){
                                                    $numReq = $row["count"];
                                                    $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE employeeID=:employeeID AND medhapType=:hospital");
                                                    $sql->execute([
                                                        "employeeID"    => $employeeID,
                                                        "hospital"      => $hospital
                                                    ]);

                                                    while($row = $sql->fetch()){
                                                        if($numReq == 1 && $row["status"] == "Approved")
                                                            $reRequest = "<button class='btn btn-danger' id='reRequest' data-id='$row[id]'><i class='fa fa-plus'></i></button>";
                                                        else
                                                            $reRequest = "";

                                                        if($row["relation"] == "self"){
                                                            $sqlName = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                                                            $sqlName->execute([
                                                                "employeeID"    => $employeeID
                                                            ]);
                                                            $rowName        = $sqlName->fetch();
                                                            $middleName     = empty($rowName["middleName"]) ? "" : ucwords($rowName["middleName"][0]);
                                                            $fullName       = ucwords($rowName["lastName"]) . ", " . ucwords($rowName["firstName"]) . " " . $middleName . ".";
                                                            $relation       = "Self";
                                                        }else{
                                                            $sqlName = $conn->prepare("SELECT * FROM dbo.dependents WHERE id=:id");
                                                            $sqlName->execute([
                                                                "id"    => $row["relation"]
                                                            ]);
                                                            $rowName        = $sqlName->fetch();
                                                            $fullName       = $rowName["fullName"];
                                                            $relation       = $rowName["relation"];
                                                        }

                                                        $amount = "₱ ".number_format($row["amount"], 2);
                                                        $used = "₱ ".number_format($row["used"], 2);
                                                        echo "<tr>
                                                            <td class='border border-top border-bottom'>".$count++."</td>
                                                            <td class='border border-top border-bottom'>$fullName</td>
                                                            <td class='border border-top border-bottom'>$relation</td>
                                                            <td class='border border-top border-bottom'>$row[dateRequest]</td>
                                                            <td class='border border-top border-bottom'>$amount</td>
                                                            <td class='border border-top border-bottom'>$used</td>
                                                            <td class='border border-top border-bottom'>$row[status]</td>
                                                            <td class='border border-top border-bottom'>$reRequest</td>
                                                        </tr>";
                                                    }
                                                }else{
                                                    echo "<tr><td class='border border-top border-bottom' colspan='8'>No MED-HAP Request Found.</td></tr>";
                                                }
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="eyecareInfo" class="tab-pane fade-in table-responsive">
                                    <table class="table table-light table-hover border" id="eyeCareReqTable" style="text-align: center;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class='border border-top border-bottom'></th>
                                                <th class='border border-top border-bottom'>Date Requested</th>
                                                <th class='border border-top border-bottom'>Amount</th>
                                                <th class='border border-top border-bottom'>Used</th>
                                                <th class='border border-top border-bottom'>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="small" id="eyeCareReqTableTableList">
                                            <?php 

                                                $count = 0;
                                                $medhapType = 2;
                                                $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE medhapType=:medhapType");
                                                $sql->execute([
                                                    "medhapType" => $medhapType
                                                ]);
                                                while($row = $sql->fetch()){
                                                    $amount = "₱ ".number_format($row["amount"], 2);
                                                    $used = "₱ ".number_format($row["used"], 2);
                                                    echo "<tr>
                                                        <td class='border border-top border-bottom'>".++$count."</td>
                                                        <td class='border border-top border-bottom'>$row[dateRequest]</td>
                                                        <td class='border border-top border-bottom'>$amount</td>
                                                        <td class='border border-top border-bottom'>$used</td>
                                                        <td class='border border-top border-bottom'>$row[status]</td>
                                                    </tr>";
                                                }
                                                if($count == 0){
                                                    echo "<tr><td colspan='6'>No Eye Care Request.</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="checkupInfo" class="tab-pane fade-in table-responsive">
                                    <table class="table table-light table-hover border" id="eyeCareReqTable" style="text-align: center;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class='border border-top border-bottom'></th>
                                                <th class='border border-top border-bottom'>Date Requested</th>
                                                <th class='border border-top border-bottom'>Amount</th>
                                                <th class='border border-top border-bottom'>Used</th>
                                                <th class='border border-top border-bottom'>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="small" id="eyeCareReqTableTableList">
                                            <?php 

                                                $count = 0;
                                                $medhapType = 3;
                                                $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE medhapType=:medhapType");
                                                $sql->execute([
                                                    "medhapType" => $medhapType
                                                ]);
                                                while($row = $sql->fetch()){
                                                    $amount = "₱ ".number_format($row["amount"], 2);
                                                    $used = "₱ ".number_format($row["used"], 2);
                                                    echo "<tr>
                                                        <td class='border border-top border-bottom'>".++$count."</td>
                                                        <td class='border border-top border-bottom'>$row[dateRequest]</td>
                                                        <td class='border border-top border-bottom'>$amount</td>
                                                        <td class='border border-top border-bottom'>$used</td>
                                                        <td class='border border-top border-bottom'>$row[status]</td>
                                                    </tr>";
                                                }
                                                if($count == 0){
                                                    echo "<tr><td colspan='6'>No General Check-up Request.</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="reRequestInfo" class="tab-pane fade-in table-responsive">

                                    <table class="table table-light table-hover border" id="reRequestTable" style="text-align: center;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class='border border-top border-bottom' ></th>
                                                <th class='border border-top border-bottom' >Date Requested</th>
                                                <th class='border border-top border-bottom' >Date Re-requested</th>
                                                <th class='border border-top border-bottom' >Amount</th>
                                                <th class='border border-top border-bottom' >Request Amount</th>
                                                <th class='border border-top border-bottom' >Reason</th>
                                                <th class='border border-top border-bottom' >Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="small" id="employeeMedhapTableList">
                                            <?php 
                                            
                                                $count = 0;
                                                $sql = $conn->prepare("SELECT reReq.*,req.dateRequest, req.amount as oldAmount FROM dbo.reRequest as reReq INNER JOIN
                                                dbo.medhapReq as req ON reReq.medhapID=req.id WHERE req.employeeID=:employeeID");
                                                $sql->execute([
                                                    "employeeID" => $employeeID
                                                ]);
                                                while($row = $sql->fetch()){
                                                    $oldAmount = "₱ ".number_format((float)$row["oldAmount"], 2,".",",");
                                                    $amount = "₱ ".number_format((float)$row["amount"], 2,".",",");
                                                    echo "<tr>
                                                            <td class='border border-top border-bottom'>".++$count."</td>
                                                            <td class='border border-top border-bottom'>$row[dateRequest]</td>
                                                            <td class='border border-top border-bottom'>$row[dateReReq]</td>
                                                            <td class='border border-top border-bottom'>$oldAmount</td>
                                                            <td class='border border-top border-bottom'>$amount</td>
                                                            <td class='border border-top border-bottom'>$row[reason]</td>
                                                            <td class='border border-top border-bottom'>$row[status]</td>
                                                        </tr>";
                                                }
                                            
                                                if($count == 0)
                                                    echo "<tr><td colspan='7'>No Pending Re-request.</td></tr>"
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
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