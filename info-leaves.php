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
            require "includes/topbar.php";
        ?>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
           
            <div class="container-fluid table-responsive">
                <table class="table table-light table-hover border" id="employeeLeaveTable" style="text-align: center;">
                    <thead class="thead-dark">
                        <tr>
                            <th class='border border-top border-bottom'></th>
                            <th class='border border-top border-bottom'>Type</th>
                            <th class='border border-top border-bottom'>Date Prepared</th>
                            <th class='border border-top border-bottom'>Date From</th>
                            <th class='border border-top border-bottom'>Date To</th>
                            <th class='border border-top border-bottom'>Days</th>
                            <th class='border border-top border-bottom'>Status</th>
                            <th class='border border-top border-bottom'>View</th>
                        </tr>
                    </thead>
                    <tbody id="employeeLeaveTableList">
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