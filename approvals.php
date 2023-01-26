<?php 

    require "session/sessionStaff.php";
    require "includes/connection.php";
    require "includes/header.php";

    $notiStatus = "read";
    $type       = "Leave";
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
        
            <form id="signatoryForm">
                <input type="hidden" name="signatoryPic" id="signatoryPic">
                <input type="hidden" name="leaveID" id="leaveID">
            </form>
        <div class="container-fluid">
            <div class="mt-5" id="canvasContainer" style="position:absolute; z-index:10000; margin: 0 !important; background-color:rgba(254, 254, 254,0.9); display:none;">
                <button class="close" type="button" id="signatureCloseSigna">
                    <span aria-hidden="true">×</span>
                </button>
                <div id="parentCanvas" class="">
                <div id="canvasDiv" class="mx-auto border border-primary" style="background:white;"></div>
                
                <div id="buttonHolder" class="row mx-auto">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-info mt-2" id="resetSignature">Reset</button>
                    </div>
                    <div class="col-md-8">
                        <h4 class="text-center mt-2"> Add Signature</h4>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary float-right mt-2" id="saveSignatory">Save</button>
                    </div>
                </div>
                </div>
            </div>
        <div class="container body" style="margin-top: 1.5rem;">
            <table class="table table-light table-responsive table-hover border" id="signatoryTable" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th class='border border-top border-bottom' style="width: 3%;"></th>
                        <th class='border border-top border-bottom' style="width: 25%;">Name</th>
                        <th class='border border-top border-bottom' style="width: 22%;">Position</th>
                        <th class='border border-top border-bottom' style="width: 17%;">Department</th>
                        <th class='border border-top border-bottom' style="width: 12%;">Type</th>
                        <th class='border border-top border-bottom' style="width: 11%;">From</th>
                        <th class='border border-top border-bottom' style="width: 5%;">Days</th>
                        <th class='border border-top border-bottom' style="width: 5%;">View</th>
                    </tr>
                </thead>
                <tbody id="signatoryTableList">
                    
                </tbody>
            </table>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>