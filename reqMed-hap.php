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
        <form action="" id="medhapForm">
            <div class="container-fluid">
                <!--<div class="mt-5" id="canvasContainer" style="position:absolute; z-index:10000; margin: 0 !important; background-color:rgba(254, 254, 254,0.9); display:none;">
                    <button class="close" type="button" id="signatureClose">
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
                            <button type="button" class="btn btn-primary float-right mt-2" id="saveSignature">Save</button>
                        </div>
                    </div>
                    </div>
                </div>-->
                <h4 style="border-bottom: 2px solid;">Request Med Hap</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label for="medhapType">MED-HAP Type:</label>
                        <select class="form-control select2" name="medhapType" id="medhapType">
                            <option hidden>Please Select MED-HAP Type</option>
                            <?php

                                $sql = $conn->prepare("SELECT * FROM dbo.medhapType");
                                $sql->execute();
                                while($row = $sql->fetch()){
                                    echo "<option value=$row[id]>$row[name]</option>";
                                }
                            
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" class="form-control" name="amount">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6" id="forHospital">
                    </div>
                    <div class="col-md-6" id="forDependents">
                    </div>
                </div>
                <button class="btn btn-info float-right">Submit</button>
            </div>
        </form>
        <!-- /.container-fluid -->
        
    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>