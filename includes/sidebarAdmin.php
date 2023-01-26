<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="img/loader.jpg" alt="" style="width:60px;">
                </div>
                <div class="sidebar-brand-text mx-3"></div>
            </a>

            <hr class="sidebar-divider my-0">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
              <span class='sidebar-brand-text mx-3'>Administrator</span>
            </a>
            <?php 
            
                echo '<input type="hidden" name="sess_dep" id="sess_dep" value="'.$_SESSION["type"].'">';
            
            ?>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item side-link">
                <a class="nav-link" id="indexID" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Nav Item - Pages Collapse Menu -->
            <div class="sidebar-heading">
                List
            </div>
            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item side-link">
                <a class="nav-link" href="leaves.php">
                <i class="fa fa-table"></i>
                    <span>Leaves</span>
                </a>
            </li>
            <li class="nav-item side-link">
                <a class="nav-link" href="med-hap.php">
                <i class="fa fa-medkit"></i>
                    <span>MED-HAP</span>
                </a>
            </li>
            <li class="nav-item side-link">
                <a class="nav-link" href="profiles.php">
                <i class="fa fa-users"></i>
                    <span>Profiles</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <div class="sidebar-heading">
                Information
            </div>
            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item side-link">
                <a class="nav-link" href="employeeList.php">
                <i class="fa fa-table"></i>
                    <span>Employees</span>
                </a>
            </li>
            <li class="nav-item side-link">
                <a class="nav-link" href="addEmployee.php">
                <i class="fa fa-upload"></i>
                    <span>Add Employee</span>
                </a>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            
        </ul>