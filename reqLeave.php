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
        <form action="" id="leaveForm">
            <div class="container-fluid">
                <div class="mt-5" id="canvasContainer" style="position:absolute; z-index:10000; margin: 0 !important; background-color:rgba(254, 254, 254,0.9); display:none;">
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
                </div>
                <input type="hidden" id="signaturePic" name="signaturePic">
                <h4 style="border-bottom: 2px solid;">Request Leave</h4>
                <div class="row">
                    <div class="col-md-4">
                        <label for="leaveType">Leave Type:</label>
                        <select class="form-control select2" name="leaveType" id="leaveType">
                            <option hidden>Please Select Leave Type</option>
                            <?php

                                $sql = $conn->prepare("SELECT * FROM dbo.leaveType");
                                $sql->execute();
                                while($row = $sql->fetch()){
                                    echo "<option value=$row[id]>$row[name]</option>";
                                }
                            
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dateFrom">Date From:</label>
                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" required>
                    </div>
                    <div class="col-md-4">
                        <label for="dateTo">Date To:</label>
                        <input type="date" class="form-control" name="dateTo" id="dateTo" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="numDays">Number of Days:</label>
                        <input type="text" class="form-control" name="numDays" id="numDays" required>
                    </div>
                    <div class="col-md-4">
                        <label for="reason">Reason:</label>
                        <input type="text" name="reason" id="reason" class="form-control" required>
                    </div>
                    <div class="col-md-4 row">
                        <div class="col-md-6">
                            <label for="">Upload File:</label>
                            <label class="custom-file-upload btn btn-info">
                                <input type="file" name='attachments[]' multiple="multiple" accept="image/*" id="leaveFileSlct"/>
                                <i class="fa fa-upload">&nbsp;</i> <span id='numSelected'>Select a File</span>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label for="signature">Add Signature:</label>
                            <button class="form-control btn btn-primary" id="signature" type="button">Signature</button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-info float-right mt-3">Submit</button>
            </div>
        </form>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>