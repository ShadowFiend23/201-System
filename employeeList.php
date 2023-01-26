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
            
            <div class="container-fluid">
                <table class="table table-light table-hover border" id="employeeTable" style="text-align: center;">
                    <thead class="thead-dark">
                        <tr>
                            <th class='border border-top border-bottom' style=""></th>
                            <th class='border border-top border-bottom' style="">Name</th>
                            <th class='border border-top border-bottom' style="">Position</th>
                            <th class='border border-top border-bottom' style="">Department</th>
                            <th class='border border-top border-bottom' style="">View</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableList">
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