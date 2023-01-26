<?php 
    
    if(isset($_GET["id"])){

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
            require "includes/topbar.php";
        ?>
        <!-- End of Topbar -->
        <?php 
            
            $id = $_GET["id"];
            $employeeID = $_SESSION["employeeID"];
            
            $sql = $conn->prepare("SELECT req.*,employee.* FROM dbo.medhapReq as req INNER JOIN
             dbo.employee_info as employee ON req.employeeID=employee.employeeID WHERE req.id=:id");
            $sql->execute([ "id"    => $id]);
            $row = $sql->fetch();
            $status = $row["status"];
            $approvalsID = unserialize($row["approvalsID"]);
            $approvalsStatus = empty($row["approvalsStatus"]) ? array() : unserialize($row["approvalsStatus"]);

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

            $amount = "₱ ".number_format($row["amount"], 2);
        ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="row">
                <h4 class="col-md-6">Request Information</h4>
                <?php 
                    
                    if($status == "Pending"){
                        $index = array_search($employeeID, $approvalsID);
                        if($index == 0){
                ?>
                <div class="col-md-6" id="acceptDeclineMedhap">
                    <div class="float-right">
                        <input type="hidden" id="medHapID" value="<?php echo $id; ?>" />
                        <button  class="btn btn-primary" id="apprMedBtn">Approve</button>
                        <button class="btn btn-danger" id="decMedBtn">Decline</button>
                    </div>
                </div>
                <?php        
                        }else{
                            $prevEmployee = $approvalsID[$index-1];
                            if(array_key_exists($prevEmployee,$approvalsStatus)){
                ?>
                <div class="col-md-6" id="acceptDeclineMedhap">
                    <div class="float-right">
                        <input type="hidden" id="medHapID" value="<?php echo $id; ?>" />
                        <button  class="btn btn-primary" id="apprMedBtn">Approve</button>
                        <button class="btn btn-danger" id="decMedBtn">Decline</button>
                    </div>
                </div>
                <?php 
                            }else{
                                    echo "<h6>Waiting For Endorsement Before Approval.</h6>";
                            }
                        }
                        
                    }

                ?>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 row">
                    <div class="col-md-4">FullName:</div>
                    <div class="col-md-8"><?php echo $fullName; ?></div>
                </div>
                <div class="col-md-4 row" style="border-left:2px solid;">
                    <div class="col-md-4">Position:</div>
                    <div class="col-md-8"><?php echo $position; ?></div>
                </div>
                <div class="col-md-4 row" style="border-left:2px solid;">
                    <div class="col-md-4">Department:</div>
                    <div class="col-md-8"><?php echo $department; ?></div>
                </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-md-4 row">
                    <div class="col-md-6">MED-HAP Type:</div>
                    <div class="col-md-6"><?php echo $medhapType; ?></div>
                </div>
                <div class="col-md-4 row" style="border-left:2px solid;">
                    <div class="col-md-4">Amount:</div>
                    <div class="col-md-8"><?php echo $amount; ?></div>
                </div>
                <div class="col-md-4 row" style="border-left:2px solid;">
                    <div class="col-md-4">Status:</div>
                    <div class="col-md-8"><?php echo $row["status"]; ?></div>
                </div>
            </div>
            <hr>
            
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";

    }
?>