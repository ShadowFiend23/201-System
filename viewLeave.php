<?php 

    if(isset($_GET['id'])){
        require "includes/connection.php";

        $id = $_GET['id'];
        $head       = "";
        $headID     = "";
        $chief      = "";
        $chiefID    = "";
        $bManager   = "";
        $bManagerID = "";
        $dManagerID = "";
        $dManager   = "";
        $bod        = "";
        $headSignature = "";
        $chiefSignature = "";

        $sql = $conn->prepare("SELECT * FROM dbo.leaveList WHERE id=:id");
        $sql->execute([ "id"    => $id]);
        $row = $sql->fetch();
        $status = $row["status"];
        $signaturePaths = empty($row["signaturePaths"]) ? array() : unserialize($row["signaturePaths"]);
        $payVal = $row["pay"];
        $note = $row["note"];
        

        $sqlE = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID = :employeeID");
        $sqlE->execute([
            "employeeID"    => $row["employeeID"]
        ]);
        $rowE = $sqlE->fetch();
        $middleName = empty($rowE["middleName"]) ? "" : ucwords($rowE["middleName"][0]);
        $fullName = ucwords($rowE["lastName"]) . ", " . ucwords($rowE["firstName"]) . " " . $middleName . ".";
        $fullName2 = strtoupper($rowE["firstName"]) . " " . strtoupper($middleName) . ". " . strtoupper($rowE["lastName"]) ;

        $sqlD = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:department");
        $sqlD->execute([ "department" => $rowE["department"]]);
        $rowD = $sqlD->fetch();
        $department = $rowD["type"] == "branch" ? $rowD["name"] ." Branch" : $rowD["name"];

        $sqlP = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:position");
        $sqlP->execute([ "position" => $rowE["position"]]);
        $rowP = $sqlP->fetch();
        $position = ucwords($rowP["position"]);
        
        $approvalsID = unserialize($row["signatureID"]);
        if($rowD["type"] == "branch"){
            for($i=0; $i<$row["signatureCount"]; $i++){
                if($i == 0){
                    $sqlN = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlN->execute([
                        "employeeID"    => $approvalsID[$i]
                    ]);
                    $rowN = $sqlN->fetch();
                    $middle = empty($rowN["middleName"]) ? "" : ucwords($rowN["middleName"][0]);
                    $bManager = strtoupper($rowN["firstName"]) . " " . $middle . ". " . strtoupper($rowN["lastName"]);
                    $bManagerID = $approvalsID[$i];
                }else if($i == 1){
                    $sqlN = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlN->execute([
                        "employeeID"    => $approvalsID[$i]
                    ]);
                    $rowN = $sqlN->fetch();
                    $middle = empty($rowN["middleName"]) ? "" : ucwords($rowN["middleName"][0]);
                    $dManager = strtoupper($rowN["firstName"]) . " " . $middle . ". " . strtoupper($rowN["lastName"]);
                    $dManagerID = $approvalsID[$i];
                }else if($i == 2){
                    $sqlN = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlN->execute([
                        "employeeID"    => $approvalsID[$i]
                    ]);
                    $rowN = $sqlN->fetch();
                    $middle = empty($rowN["middleName"]) ? "" : ucwords($rowN["middleName"][0]);
                    $chief = strtoupper($rowN["firstName"]) . " " . $middle . ". " . strtoupper($rowN["lastName"]);
                    $chiefID = $approvalsID[$i];
                    $chiefSignature = str_replace("../","",$signaturePaths[$approvalsID[$i]]);
                }else if($i == 3){
                    $sqlN = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlN->execute([
                        "employeeID"    => $approvalsID[$i]
                    ]);
                    $rowN = $sqlN->fetch();
                    $middle = empty($rowN["middleName"]) ? "" : ucwords($rowN["middleName"][0]);
                    $bod = strtoupper($rowN["firstName"]) . " " . $middle . ". " . strtoupper($rowN["lastName"]);
                }
            }
        }else{
            for($i=0; $i<$row["signatureCount"]; $i++){
                if($i == 0){
                    $sqlN = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlN->execute([
                        "employeeID"    => $approvalsID[$i]
                    ]);
                    $rowN = $sqlN->fetch();
                    $middle = empty($rowN["middleName"]) ? "" : ucwords($rowN["middleName"][0]);
                    $head = strtoupper($rowN["firstName"]) . " " . $middle . ". " . strtoupper($rowN["lastName"]);
                    $headID = $approvalsID[$i];
                    $headSignature = empty($signaturePaths[$approvalsID[$i]]) ? "" : str_replace("../","",$signaturePaths[$approvalsID[$i]]);
                }else if($i == 1){
                    $sqlN = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlN->execute([
                        "employeeID"    => $approvalsID[$i]
                    ]);
                    $rowN = $sqlN->fetch();
                    $middle = empty($rowN["middleName"]) ? "" : ucwords($rowN["middleName"][0]);
                    $chief = strtoupper($rowN["firstName"]) . " " . $middle . ". " . strtoupper($rowN["lastName"]);
                    $chiefID = $approvalsID[$i];
                    $chiefSignature = empty($signaturePaths[$approvalsID[$i]]) ? "" : str_replace("../","",$signaturePaths[$approvalsID[$i]]);
                }else if($i == 3){
                    $sqlN = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
                    $sqlN->execute([
                        "employeeID"    => $approvalsID[$i]
                    ]);
                    $rowN = $sqlN->fetch();
                    $middle = empty($rowN["middleName"]) ? "" : ucwords($rowN["middleName"][0]);
                    $bod = strtoupper($rowN["firstName"]) . " " . $middle . ". " . strtoupper($rowN["lastName"]);
                }
            }
        }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!--<link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">-->

    <!-- Custom styles for this template-->
    <link href="css/paper-dashboard.css" rel="stylesheet">
    <style>
        body,html{
            height:99%;
        }
        .container{
            padding:10px 20px;
            height:93%;
        }
        .leaveform{
            border:2px solid;
            height:100%;
        }
        .heading{
            display:flex;
            justify-content: center;
            align-items: center;
        }
        
        .leaveTitle{
            margin:0;
            text-align:center;
        }
        .heading img{
            height:50px;
        }
        .row{
            display:flex;
        }
        .col{
            padding: 0 3px;
        }
        #userSignature{
            display:flex;
            justify-content: center;
            align-items: center;
        }
        p{
            margin: 4px 0;
        }
        hr{
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #858796;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0px 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.35rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            margin:0 2px;
        }
        
        .btn-info {
            color: #fff;
            background-color: #36b9cc;
            border-color: #36b9cc;
        }
        .btn-danger {
            color: #fff;
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        #withPayDiv input,#withPayDiv {
            vertical-align:middle;
        }
        .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6e707e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        #headSignature img{
            height:50px;
            width:90px;
        }
        
        @media print {
            .container{
                height: 89%;
                padding: 0 20px;
            }
            @page {
                margin: 0;
            }
        }
        
    </style>
</head>
<body>
        
        <div class="container">
            <div class="leaveform">
                <div class="heading">
                    <img src="img/loader.jpg" alt="">
                    <h4>METRO ORMOC COMMUNITY MULTI-PURPOSE COOPERATICE (OCCCI)</h4>
                </div>
                <h2 class="leaveTitle">Application For Leave</h2>
                <hr>
                <div class="info">
                    <div class="row">
                        <div class="col" style="width:40%;">
                            <p><strong>Employee Name:</strong> <?php echo $fullName; ?></p>
                        </div>
                        <div class="col" style="width:20%;">
                            <p><strong>Employee ID:</strong> <?php echo $row["employeeID"]; ?></p>
                        </div>
                        <div class="col" style="width:20%;">
                            <p><strong>Date Prepared:</strong> <?php echo date("Y-m-d",strtotime($row["datePrepared"])); ?></p>
                        </div>
                        <div class="col" style="width:20%;">
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="">
                        <div class="col" style="width:25%; border-right:1px solid;text-align:center;">
                            <p><strong>Department</strong></p>
                            <p><?php echo $department; ?></p>
                        </div>
                        <div class="col" style="width:25%; border-right:1px solid;text-align:center;">
                            <p><strong>Position</strong></p>
                            <p><?php echo $position; ?></p>
                        </div>
                        <div class="col" style="width:25%; border-right:1px solid;">
                            <p style="text-align:center;"><strong>Duration</strong></p>
                            <div style="display:flex">
                                <div style="width:50%;">
                                    <p><strong>From:</strong> <?php echo date("M-d-Y",strtotime($row["dateFrom"])); ?></p>
                                </div>
                                <div style="width:50%;">
                                    <p><strong>To:</strong> <?php echo  date("M-d-Y",strtotime($row["dateTo"])); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="width:25%; text-align:center;">
                            <p><strong>No Of Days</strong></p>
                            <p><?php echo $row["numDays"]; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div id="leaveType" style="width:50%; border-bottom:1px solid;">
                            <p style="text-align:center;"><strong>Type Of Leave</strong></p>
                            <input type="hidden" id="leaveTypeVal" value='<?php echo $row['leaveType']; ?>'>
                            <div style="display:flex;">
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType1" value="1" class="leaveType" >Vacation
                                </div>
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType4" value="4" class="leaveType" >Maternity
                                </div>
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType7" value="7" class="leaveType" >Emergency
                                </div>
                            </div>
                            <div style="display:flex;">
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType2" value="2" class="leaveType" >Sick
                                </div>
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType5" value="5" class="leaveType" >Paternity
                                </div>
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType8" value="8" class="leaveType" >Special Leave For Women
                                </div>
                            </div>
                            <div style="display:flex;">
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType3" value="3" class="leaveType" >Compensatory
                                </div>
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType6" value="6" class="leaveType" >Bereavement
                                </div>
                                <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                    <input type="checkbox" name="" id="leaveType9" value="9" class="leaveType" > Solo Parenthood
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="signaturePath" value="<?php echo str_replace("../","",$row["userSignature"]); ?>">
                        <div id="user" style="width:50%; border: 1px solid;text-align:center;">
                            <div id="userSignature">
                                <img src="" alt="" id="signature" style="margin:0 auto;">
                            </div>
                            <strong style="margin:0;"><?php echo $fullName2; ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p style="padding: 2px 0;"><strong>Reason: </strong> <?php echo ucwords($row["reason"]); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="text-align:center;">
                        <div style="width:40%;">
                            <h3 class="leaveTitle" style="width:100%;">Endorsement</h3>
                        </div>
                        <div style="width:60%;">
                            <h3 class="leaveTitle" style="width:100%;">Approvals</h3>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="row" id="approvals">
                        <div class="col" style="width:20%; text-align:center;">
                            <p style="text-align:center"><strong>Section Head</strong></p>
                            <p style="margin:10px 0px;"><strong><?php echo $head; ?></strong></p>
                            <?php 
                                if(!empty($head)){
                                    if(array_key_exists($headID,$signaturePaths))
                                        echo "<input type='hidden' id='headStatus' value='".$signaturePaths[$headID]."' />";
                                    else
                                        echo "<input type='hidden' id='headStatus' value='' />";

                                    echo '<input type="checkbox" class="statBtn" name="" id="headEndorse">Endorsed
                                        <input type="checkbox" class="statBtn" name="" id="headDis">Disapproved';
                                }
                            ?>
                            
                        </div>
                        <div class="col" style="width:20%; text-align:center;">
                            <p style="text-align:center"><strong>Branch Manager</strong></p>
                            <p style="margin:10px 0px;"><strong><?php echo $bManager; ?></strong></p>
                            <?php 
                                if(!empty($bManager)){
                                    if(array_key_exists($bManagerID,$signaturePaths))
                                        echo "<input type='hidden' id='bManStatus' value='".$signaturePaths[$bManagerID]."' />";
                                    else
                                        echo "<input type='hidden' id='bManStatus' value='' />";

                                    echo '<input type="checkbox" class="statBtn" name="" id="bManEndorse">Endorsed
                                        <input type="checkbox" class="statBtn" name="" id="bManDis">Disapproved';
                                }
                            ?>
                        </div>
                        <div class="col" style="width:20%; text-align:center;">
                            <p style="text-align:center"><strong>District Manager</strong></p>
                            <p style="margin:10px 0px;"><strong><?php echo $dManager; ?></strong></p>
                            <?php 
                                if(!empty($dManager)){
                                    if(array_key_exists($dManagerID,$signaturePaths))
                                        echo "<input type='hidden' id='dManStatus' value='".$signaturePaths[$dManagerID]."' />";
                                    else
                                        echo "<input type='hidden' id='dManStatus' value='' />";

                                    echo '<input type="checkbox" class="statBtn" name="" id="dManEndorse">Endorsed
                                        <input type="checkbox" class="statBtn" name="" id="dManDis">Disapproved';
                                }
                            ?>
                        </div>
                        <div class="col" style="width:20%; text-align:center;">
                            <p style="text-align:center"><strong>CAO/CFO/COO</strong></p>
                            <p style="margin:10px 0px;"><strong><?php echo $chief; ?></strong></p>
                            <?php 
                                if(!empty($chief)){
                                    if(array_key_exists($chiefID,$signaturePaths))
                                        echo "<input type='hidden' id='chiefStatus' value='".$signaturePaths[$chiefID]."' />";
                                    else
                                        echo "<input type='hidden' id='chiefStatus' value='' />";

                                    echo '<input type="checkbox" class="statBtn" name="" id="chiefAppr">Approved
                                        <input type="checkbox" class="statBtn" name="" id="chiefDis">Disapproved';
                                }
                            ?>
                        </div>
                        <div class="col" style="width:20%; text-align:center;">
                            <p style="text-align:center"><strong> BOD Chairperson</strong></p>
                            <p style="margin:10px 0px;"><strong><?php echo $bod; ?></strong></p>
                            <?php 
                                if(!empty($bod)){
                                    
                                }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="text-align:center">
                        <h3 class="leaveTitle" style="width:100%;">For HR Development Section</h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col" style="width:50%; border-right:1px solid;text-align:center;">
                            <p style="" ><strong>Remarks</strong></p>
                            <?php
                                if($status == "Approved"){
                            ?>
                                    
                                <p>
                                    <strong>Status: </strong><span><?php echo $status; ?></span>
                                </p>

                            <?php
                                }else if($status == "Disapproved"){
                            
                            ?>
                                <p>
                                    <strong>Status: </strong><span><?php echo $status; ?></span>
                                    <strong style="margin-left: 5em;">Reason: </strong> <span><?php echo $row["disAppReason"]; ?></span>
                                </p>

                            <?php
                                }

                                if(!empty($note)){
                                    echo "<p><strong>Note: </strong> <span>$note</span></p>";
                                }

                            ?>
                        </div>
                        <input type="hidden" name="" id="dataPay" value="<?php echo empty($row["pay"]) ? 0 : $row["pay"]; ?>">
                        <div class="col" style="width:16.66667%; border-right:1px solid;">
                            <input type="checkbox" name="" id="pay1" class="ifPay"><strong>With Pay</strong>
                            <br>
                            <br>
                            <input type="checkbox" name="" id="pay0" class="ifPay"><strong>Without Pay</strong>
                        </div>
                        <div class="col" style="width:16.66667%; text-align:center; border-right:1px solid;">
                            <p><strong>Received By</strong></p>
                        </div>
                        <div class="col" style="width:16.66667%; text-align:center;">
                            <p><strong>Certified By</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script>
        $(document).ready(function(){
            
            let leaveTypeHeight = $("#leaveType").innerHeight();
            let signatureHeight = leaveTypeHeight - (leaveTypeHeight * .3);
            let signPath        = $("#signaturePath").val();
            let approvalHeight  = leaveTypeHeight;
            let approvalSign    = approvalHeight - (approvalHeight * .58);
            let leaveType       = $("#leaveTypeVal").val();
            let dataPay         = $("#dataPay").val();
            let headStatus      = $("#headStatus").val();
            let bManStatus      = $("#bManStatus").val();
            let dManStatus      = $("#dManStatus").val();
            let chiefStatus     = $("#chiefStatus").val();

            if(headStatus == "Approved")
                $("#headEndorse").prop("checked",true);
            else if (headStatus == "Disapproved")
                $("#headDis").prop("checked",true);

            if(bManStatus == "Approved")
                $("#bManEndorse").prop("checked",true);
            else if (bManStatus == "Disapproved")
                $("#bManDis").prop("checked",true);

            if(dManStatus == "Approved")
                $("#dManEndorse").prop("checked",true);
            else if (dManStatus == "Disapproved")
                $("#dManDis").prop("checked",true);

            if(chiefStatus == "Approved")
                $("#chiefAppr").prop("checked",true);
            else if (chiefStatus == "Disapproved")
                $("#chiefDis").prop("checked",true);

            $("#user").css({ "height" : leaveTypeHeight + "px"});
            $("#signature").css({ "height" : signatureHeight + "px" });
            $("#approvals").css({ "height" : approvalHeight + "px" });
            $("#signature").attr("src",signPath);
            $("#headSignature,#branchSignature,#districtSignature,#chiefSignature,#bodSignature").css({ "height" : approvalSign + "px" });
            $("#leaveType" + leaveType).prop("checked",true);
            if(dataPay == 1){
                $("#pay1").prop("checked",true);
            }else if(dataPay == 2){
                $("#pay0").prop("checked",true);
            }

            $(document).on("click",".pay",function(){
                var box = $(this);
                $(".pay").prop("checked",false);
                box.prop("checked",true);
            });

            
            $(".btnPay").on("click",function(){
                let payVal = $(this).data("val");
                $("#payVal").val(payVal);
                $("#payForm").trigger("submit");
            })
            $(document).on("click",".leaveType,.ifPay,.statBtn",function(e){
                return false;
            })
        });
    </script>
</body>
</html>
<?php

    }

?>