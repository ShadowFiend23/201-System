<?php 

    if(isset($_GET['id'])){
        require "includes/connection.php";

        session_start();
        $employeeID = $_SESSION["employeeID"];
        $id         = $_GET['id'];
        $hr         = "";
        $cfo        = "";
        $cao       = "";

        $sql = $conn->prepare("SELECT * FROM dbo.medhapReq WHERE id=:id");
        $sql->execute([ "id"    => $id]);
        $row = $sql->fetch();
        $status = $row["status"];
        $approvalsID = unserialize($row["approvalsID"]);
        $approvalsStatus = empty($row["approvalsStatus"]) ? array() : unserialize($row["approvalsStatus"]);
        $payVal = $row["pay"];
        $medhapType = $row["medhapType"];
        
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

        if($row["relation"] == "self"){
            $relation = "Self";
            $gender = $row["gender"];
        }else{
            $sqlDep = $conn->prepare("SELECT * FROM dbo.dependents WHERE id=:id");
            $sqlDep->execute([
                "id" => $row["relation"]
            ]);
            $rowDep = $sqlDep->fetch();
            $relation = ucwords($rowDep["fullName"]) . " ($rowDep[relation])";
            $gender = $rowDep["gender"];
        }

        

        $sqlCAO = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
        $sqlCAO->execute([
            "employeeID" => $approvalsID[1]
        ]);
        $rowCAO = $sqlCAO->fetch();
        $middleName = empty($rowCAO["middleName"]) ? "" : ucwords($rowCAO["middleName"][0]);
        $caoName = ucwords($rowCAO["lastName"]) . ", " . ucwords($rowCAO["firstName"]) . " " . $middleName . ".";


        $sqlCFO = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
        $sqlCFO->execute([
            "employeeID" => $approvalsID[2]
        ]);
        $rowCFO = $sqlCFO->fetch();
        $middleName = empty($rowCFO["middleName"]) ? "" : ucwords($rowCFO["middleName"][0]);
        $cfoName = ucwords($rowCFO["lastName"]) . ", " . ucwords($rowCFO["firstName"]) . " " . $middleName . ".";
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
        .medhapform{
            border:2px solid;
        }
        .heading{
            display:flex;
            justify-content: center;
            align-items: center;
        }
        
        .medhapTitle{
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
        .col-md-4 {
            flex: 0 0 33.33333%;
            max-width: 33.33333%;
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
        <div class="buttons" style="height:20px;">
            <?php 
                 if($row["status"] == "Pending"){
                    if(!array_key_exists($employeeID,$approvalsStatus)){
            ?>
            <form id="approveMedhap" >
                <div style="display:flex; float:right; margin-top:-10px;">
                    <input type="hidden" name="" id="fullName" value="<?php echo ucwords(strtolower($fullName2)); ?>">
                    <input type="hidden" name="medhapID" value="<?php echo $id; ?>">
                    <button type="submit" id="approve" class="btn btn-info">Approve</button>
                    <button type="button" id="disapprove" class="btn btn-danger">Disapprove</button>
                </div>
            </form>
            <?php }} 
                
        
                if(!empty($approvalsStatus)){
                    if($approvalsStatus[$approvalsID[0]] == "Approved"){
                        
                        $hr = "<input type='checkbox' class='statBtn' name='' checked />Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";
                    }else if($approvalsStatus[$approvalsID[0]] == "Disapproved"){
                        $hr = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name='' checked>Disapproved";
                    }else{
                        
                        $hr = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";
                    }

                    if($approvalsStatus[$approvalsID[1]] == "Approved"){

                        $cao = "<input type='checkbox' class='statBtn' name='' checked>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";
                    }else if($approvalsStatus[$approvalsID[1]] == "Disapproved"){
                        $cao = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name='' checked>Disapproved";
                    }else{
                        $cao = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";
                    }

                    if($approvalsStatus[$approvalsID[2]] == "Approved"){
                        $cfo= "<input type='checkbox' class='statBtn' name='' checked>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";
                    }else if($approvalsStatus[$approvalsID[2]] == "Disapproved"){
                        $cfo = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name='' checked>Disapproved";
                    }else{
                        $cfo = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";
                    }
                }else{
                    $hr = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";

                    $cao = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";

                    $cfo = "<input type='checkbox' class='statBtn' name=''>Approved
                        <input type='checkbox' class='statBtn' name=''>Disapproved";
                        
                }
            ?>
        </div>
        <div class="medhapform">
            <div class="heading">
                <img src="img/loader.jpg" alt="">
                <h4>METRO ORMOC COMMUNITY MULTI-PURPOSE COOPERATICE (OCCCI)</h4>
            </div>
            <h2 class="medhapTitle">Application For MED-HAP</h2>
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
                        <p><strong>Date Requested:</strong> <?php echo date("Y-m-d",strtotime($row["dateRequest"])); ?></p>
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
                        <p style="text-align:center;"><strong>Gender</strong></p>
                        <div style="display:flex; J">
                            <p style="text-align:center; width:100%;"><strong><?php echo $gender; ?></strong></p>
                            
                        </div>
                    </div>
                    <div class="col" style="width:25%; text-align:center;">
                        <p><strong>Amount</strong></p>
                        <p><?php echo "₱ ".number_format((float)$row["amount"], 2,".",","); ?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div id="medhapType" style="width:50%; border-bottom:1px solid;">
                        <p style="text-align:center;"><strong>MED-HAP Type</strong></p>
                        <input type="hidden" id="medhapTypeVal" value='<?php  ?>'>
                        <div style="display:flex;">
                            <?php 
                                $hospitalChecked = $medhapType == 1 ? "checked" : "";
                                $eyeCareChecked = $medhapType == 2 ? "checked" : "";
                                $generalChecked = $medhapType == 3 ? "checked" : "";

                            ?>
                            <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                <input type="checkbox" name="" id="medhapType1" value="1" class="medhapType" <?php echo $hospitalChecked; ?>>Hospitalization
                            </div>
                            <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                <input type="checkbox" name="" id="medhapType2" value="4" class="medhapType" <?php echo $eyeCareChecked; ?>>Eye Care
                            </div>
                            <div style="flex: 0 0 33.33333%; max-width: 33.33333%;">
                                <input type="checkbox" name="" id="medhapType3" value="7" class="medhapType" <?php echo $generalChecked; ?>>General Check-up
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="signaturePath" value="<?php echo str_replace("../","",$row["userSignature"]); ?>">
                    <div id="user" style="width:50%; border: 1px solid;text-align:center;">
                        <div id="userSignature">
                            <img src="" alt="" id="signature" style="margin:0 auto;">
                        </div>
                        <strong style="margin:0;"><?php  ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p style="padding: 2px 0; "><strong>For: <?php echo $relation; ?></strong> <?php  ?></p>
                    </div>
                </div>
                <hr>
                <div class="row" style="text-align:center;">
                    <div style="width:100%;">
                        <h3 class="medhapTitle" style="width:100%;">Approvals</h3>
                    </div>
                </div>
                <hr>
                
                <div class="row" id="approvals">
                    <div class="col-md-4" style="text-align:center;">
                        <p style="text-align:center"><strong>HR Admin</strong></p>
                        <p style="margin:10px 0px; visibility:hidden;"><strong><?php echo "HIDDEN"; ?></strong></p>
                        <?php 
                            echo $hr;
                        ?>
                    </div>
                    <div class="col-md-4" style="text-align:center;">
                        <p style="text-align:center"><strong>CAO</strong></p>
                        <p style="margin:10px 0px;"><strong><?php echo $caoName; ?></strong></p>
                        <?php 
                            echo $cao;
                        ?>
                    </div>
                    <div class="col-md-4" style="text-align:center;">
                        <p style="text-align:center"><strong>CFO</strong></p>
                        <p style="margin:10px 0px;"><strong><?php echo $cfoName; ?></strong></p>
                        <?php 
                           echo $cfo;
                        ?>
                    </div>
                </div>
                <hr>
                <div class="row" style="text-align:center">
                    <h3 class="medhapTitle" style="width:100%;">For HR Development Section</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col" style="width:50%; border-right:1px solid;text-align:center;">
                        <p style="" ><strong>Remarks</strong></p>
                        
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
            
            let medhapTypeHeight = $("#medhapType").innerHeight();
            let signatureHeight = medhapTypeHeight - (medhapTypeHeight * .3);
            let signPath        = $("#signaturePath").val();
            let medhapType       = $("#medhapTypeTypeVal").val();
            let approvalHeight  = medhapTypeHeight;
            let approvalSign    = approvalHeight - (approvalHeight * .58);
            

            $("#user").css({ "height" : medhapTypeHeight + "px"});
            $("#signature").css({ "height" : signatureHeight + "px" });
            $("#signature").attr("src",signPath);
            $("#headSignature,#branchSignature,#districtSignature,#chiefSignature,#bodSignature").css({ "height" : approvalSign + "px" });
            $("#medhapType" + medhapType).prop("checked",true);
           

            $(document).on("click",".medhapType,.statBtn",function(e){
                return false;
            })

            $("#approveMedhap").on("submit",function(e){
                e.preventDefault();
                
                let fullName = $("#fullName").val();
                let frmData = new FormData($(this)[0]);

                Swal.fire({
                    title: 'Approve MED-HAP',
                    text: 'Approved The Application For MED-HAP Of '+ fullName,
                    type: 'warning',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((data) => {
                    if(data.value){
                        $.ajax({
                            url:"ajax/approveMedhap.php",
                            type:"POST",
                            data: frmData,
                            success:function(data){
                                let response = $.parseJSON(data);
                                if(response.result){
                                    Swal.fire({
                                        title: 'Success',
                                        type: 'success',
                                        text: response.msg,
                                        timer: 3000,
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then(() => {
                                        location.reload();
                                    })
                                }else{
                                    Swal.fire('Failed', response.msg, 'error');
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                    }
                });
            });
            
            $("#disapprove").on("click",function(){
                let frmData = new FormData($("#approveMedhap")[0]);
                Swal.fire({
                    title: '<strong>Reason For Dissaproval</strong>',
                    type: 'warning',
                    input:'text',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((data) => {
                    
                    if(data.value){
                        frmData.append("reason",data.value);
                        $.ajax({
                            url:"ajax/disApproveMEDHAP.php",
                            type:"POST",
                            data: frmData,
                            success:function(data){
                                let response = $.parseJSON(data);
                                if(response.result){
                                    Swal.fire({
                                        title: 'Success',
                                        type: 'success',
                                        text: response.msg,
                                        timer: 3000,
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then(() => {
                                        location.reload();
                                    })
                                }else{
                                    Swal.fire('Failed', response.msg, 'error');
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                    }
                });
            })
        });
    </script>
</body>
</html>
<?php

    }

?>