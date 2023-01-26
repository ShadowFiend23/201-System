<?php 

    $notiStatus = "unread";
    $leaveAppr = 0;
    $medHapAppr = 0;
    $sql = $conn->prepare("SELECT * FROM dbo.notify WHERE employeeID=:employeeID AND status=:status");
    $sql->execute([
        "employeeID" => $_SESSION["employeeID"],
        "status"     => $notiStatus,
    ]);
    while($row = $sql->fetch()){
        if($row["type"] == "Leave")
            $leaveAppr++;
        else if($row["type"] == "MedHAP")
            $medHapAppr++;
        
    }
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="employee.php">
                <div class="sidebar-brand-icon">
                    <img src="img/loader.jpg" alt="" style="width:60px;">
                </div>
                <div class="sidebar-brand-text mx-3"></div>
            </a>

            <hr class="sidebar-divider my-0">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="employee.php">
              <span class='sidebar-brand-text mx-3'>
                  <?php
                    $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sql->execute([ "employeeID" => $_SESSION["employeeID"] ]);
                    $row = $sql->fetch();
                    
                    $middleName = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
                    $fullName = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";
                    echo $fullName;
                  ?>
                  </span>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item side-link active">
                <a class="nav-link" href="employee.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Leaves
            </div>
            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item side-link">
                <a class="nav-link" href="info-leaves.php">
                <i class="fa fa-info-circle"></i>
                    <span>Info</span>
                </a>
            </li>
            <li class="nav-item side-link">
                <a class="nav-link" href="reqLeave.php">
                <i class="fa fa-table"></i>
                    <span>Request</span>
                </a>
            </li>
            <?php 
                $employeeID = $_SESSION["employeeID"];
                $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                $sql->execute([
                    "employeeID"    => $employeeID
                ]);
                $row = $sql->fetch();
                $position = $row["position"];
                if($row){
                    if($row["rank"] >= 3){
            ?>
                    <li class='nav-item side-link'>
                            <a class='nav-link' href='approvals.php'>
                            <i class='fa fa-table'></i>
                                <span>Approvals
                                <?php 
                                    if($leaveAppr != 0)
                                        echo "<span class='badge badge-pill badge-success'>$leaveAppr</span>";
                                ?>
                                </span>
                            </a>
                        </li>
            <?php
                    }
                }
            ?>
            
            <div class="sidebar-heading">
                MED-HAP
            </div>
            <li class="nav-item side-link">
                <a class="nav-link" href="info-med-hap.php">
                <i class="fa fa-info"></i>
                    <span>Info</span>
                </a>
            </li>
            <li class="nav-item side-link">
                <a class="nav-link" href="reqMed-hap.php">
                <i class="fa fa-table"></i>
                    <span>Request</span>
                </a>
            </li>
            <?php 
            
                if($position == 5 || $position == 6 || $position == 3){
            ?>
            <li class="nav-item side-link">
                <a class="nav-link" href="medHapApprovals.php">
                <i class="fa fa-table"></i>
                    <span>Approvals
                        <?php 
                            if($medHapAppr != 0)
                            echo "<span class='badge badge-success'>$medHapAppr</span>";
                        ?>
                    </span>
                </a>
            </li>
            <?php } ?>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            
        </ul>