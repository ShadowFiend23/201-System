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
        <div id="reportForm">
            <div style="">
                <div class="card" id="reportInfo" style="padding:.50rem;">
                    <ul class="nav nav-tabs card-header-tabs" style="margin-bottom:10px; margin-left:0px;">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#leaveTab" style="border-left:0;">Leave</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#medhapTab">MED-HAP</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#generateRepTab">Generate Report</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cvTab">Curriculum Vitae</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="leaveTab" class="tab-pane fade-in active">
                            <div class="row" style="padding-left:.75rem;">
                                <div class="form-group form-inline">
                                    <label for="" class="col-md-4 float-right">Month</label>
                                    <select class="form-control col-md-8 startChange" name="reportMonth" id="reportMonth">
                                        <option value='01'>January</option>
                                        <option value='02'>February</option>
                                        <option value='03'>March</option>
                                        <option value='04'>April</option>
                                        <option value='05'>May</option>
                                        <option value='06'>June</option>
                                        <option value='07'>July</option>
                                        <option value='08'>August</option>
                                        <option value='09'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                </div>
                                <div class="form-group form-inline">
                                    <label for="" class="col-md-4">Day</label>
                                    <select class="form-control col-md-8 startChange" name="reportDay" id="reportDay">
                                        <option value='1'>1</option>
                                        <option value='16'>16</option>
                                    </select>
                                </div>
                                <div class="form-group form-inline">
                                    <label for="" class="col-md-4">Year</label>
                                    <select class="form-control col-md-8 startChange" name="reportYear" id="reportYear">
                                    <?php 
                                    
                                        $curYear = date("Y");

                                        for($i=0; $i<=15; $i++){
                                            $year = $curYear - $i;
                                            echo "<option value='$year'>$year</option>";
                                        }
                                    
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group form-inline" style="margin-left:30px;">
                                    <label for="">To</label>
                                </div>
                                <div class="form-group form-inline" style="margin-left:30px;">
                                    <label for="" style="font-size: 95%;" id="reportEndDate"></label>
                                </div>
                                <div class="form-group form-inline" style="margin-left:30px;">
                                        <button class="btn btn-info">Submit</button>
                                </div>
                            </div>
                            <hr style="margin-top: 0px;">
                            <table class="table table-light table-hover border small" id="leaveSumTable" style="text-align: center;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class='border border-top border-bottom w-auto' style=""></th>
                                        <th class='border border-top border-bottom w-auto' style="">NAME</th>
                                        <th class='border border-top border-bottom w-auto' style="">POSITION</th>
                                        <th class='border border-top border-bottom w-auto' style="">DEPARTMENT</th>
                                        <th class='border border-top border-bottom w-auto' style="">Category</th>
                                        <th class='border border-top border-bottom w-auto' style="">GENDER</th>
                                        <th class='border border-top border-bottom w-auto' style="">START</th>
                                        <th class='border border-top border-bottom w-auto' style="">DAYS</th>
                                        <th class='border border-top border-bottom w-auto' style="">REQUESTED</th>
                                    </tr>
                                </thead>
                                <tbody id="leaveSumTableList">
                                </tbody>
                            </table>
                        </div>
                        <div id="medhapTab" class="tab-pane fade-in">
                            <div class="row" style="padding-left:.75rem;">
                                <div class="form-group form-inline">
                                    <label for="" class="col-md-4 float-right">Month</label>
                                    <select class="form-control col-md-8 startChangeMed" name="reportMonthMed" id="reportMonthMed">
                                        <option value='01'>January</option>
                                        <option value='02'>February</option>
                                        <option value='03'>March</option>
                                        <option value='04'>April</option>
                                        <option value='05'>May</option>
                                        <option value='06'>June</option>
                                        <option value='07'>July</option>
                                        <option value='08'>August</option>
                                        <option value='09'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>
                                </div>
                                <div class="form-group form-inline">
                                    <label for="" class="col-md-4">Day</label>
                                    <select class="form-control col-md-8 startChangeMed" name="reportDayMed" id="reportDayMed">
                                        <option value='1'>1</option>
                                        <option value='16'>16</option>
                                    </select>
                                </div>
                                <div class="form-group form-inline">
                                    <label for="" class="col-md-4">Year</label>
                                    <select class="form-control col-md-8 startChangeMed" name="reportYearMed" id="reportYearMed">
                                    <?php 
                                    
                                        $curYear = date("Y");

                                        for($i=0; $i<=15; $i++){
                                            $year = $curYear - $i;
                                            echo "<option value='$year'>$year</option>";
                                        }
                                    
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group form-inline" style="margin-left:30px;">
                                    <label for="">To</label>
                                </div>
                                <div class="form-group form-inline" style="margin-left:30px;">
                                    <label for="" style="font-size: 95%;" id="reportEndDateMed"></label>
                                </div>
                                <div class="form-group form-inline" style="margin-left:30px;">
                                        <button class="btn btn-info">Submit</button>
                                </div>
                            </div>
                            <hr style="margin-top: 0px;">
                            <table class="table table-light table-hover border small" id="medhapSumTable" style="text-align: center;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class='border border-top border-bottom w-auto' style=""></th>
                                        <th class='border border-top border-bottom w-auto' style="">NAME</th>
                                        <th class='border border-top border-bottom w-auto' style="">POSITION</th>
                                        <th class='border border-top border-bottom w-auto' style="">DEPARTMENT</th>
                                        <th class='border border-top border-bottom w-auto' style="">Category</th>
                                        <th class='border border-top border-bottom w-auto' style="">GENDER</th>
                                        <th class='border border-top border-bottom w-auto' style="">RELATIONSHIP</th>
                                        <th class='border border-top border-bottom w-auto' style="">AMOUNT</th>
                                        <th class='border border-top border-bottom w-auto' style="">USED</th>
                                    </tr>
                                </thead>
                                <tbody id="medhapSumTableList">
                                </tbody>
                            </table>
                        </div>
                        <div id="generateRepTab" class="tab-pane fade-in">
                            <div class="row px-4">
                                <div class="form-group col-md-3">
                                    <label for='reportType' class='font-weight-bolder'>Type</label>
                                    <select name="" id="reportType" class="form-control">
                                        <option hidden>Please Select Type</option>
                                        <option value='leave'>Leave</option>
                                        <option value='medhap'>MED-HAP</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for='reportType' class='font-weight-bolder'>Category</label>
                                    <select name="" class="form-control" id="reportCateg" disabled>
                                        
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for='reportType' class='font-weight-bolder'>Start</label>
                                    <input type="date" class="form-control" id="repStartD">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for='reportType' class='font-weight-bolder'>End</label>
                                    <input type="date" class="form-control" id="repEndD">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-info float-right mr-4" id="generateRep">Generate</button>
                        <div id="cvTab" class="tab-pane fade-in">
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