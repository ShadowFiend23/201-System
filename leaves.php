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
            <table class="table table-light table-responsive table-hover border" id="leavesTable" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th class='border border-top border-bottom' style="width: 3%;"></th>
                        <th class='border border-top border-bottom' style="width: 12%;">ID No.</th>
                        <th class='border border-top border-bottom' style="width: 23%;">Name</th>
                        <th class='border border-top border-bottom' style="width: 13%;">Position</th>
                        <th class='border border-top border-bottom' style="width: 12%;">Department</th>
                        <th class='border border-top border-bottom' style="width: 11%;">Type</th>
                        <th class='border border-top border-bottom' style="width: 10%;">From</th>
                        <th class='border border-top border-bottom' style="width: 2%;">Days</th>
                        <th class='border border-top border-bottom' style="width: 5%;">Attachments</th>
                        <th class='border border-top border-bottom' style="width: 5%;">View</th>
                    </tr>
                </thead>
                <tbody id="leavesTableList">
                    
                </tbody>
            </table>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>