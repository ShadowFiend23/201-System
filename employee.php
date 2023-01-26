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
        <?php 
            
            $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
            $sql->execute([
                "employeeID"    => $_SESSION["employeeID"]
            ]);
            $row = $sql->fetch();
            $middleName     = empty($row["middleName"]) ? "" : ucwords($row["middleName"][0]);
            $fullName       = ucwords($row["lastName"]) . ", " . ucwords($row["firstName"]) . " " . $middleName . ".";
            $presentAddress = ucwords($row["presentAddress"]);
            $presentContact = $row["presentContact"];
            $homeAddress    = ucwords($row["homeAddress"]);
            $homeContact    = $row["homeContact"];
            $birthday       = empty($row["birthday"]) ? "" : date("M. d, Y",strtotime($row["birthday"]));
            $placeBirth     = empty($row["placeBirth"]) ?  "" : $row["placeBirth"];
            $gender         = $row["gender"];
            $religion       = $row["religion"];
            $citizenship    = $row["citizenship"];
            $civilStatus    = $row["civilStatus"];
            $height         = $row["height"];
            $weight         = $row["weight"];
            $hairColor      = $row["hairColor"];
            $eyeColor       = $row["eyeColor"];
            $dialectSpoken  = $row["dialectSpoken"];
            $mark           = $row["mark"];
            $sssNum         = $row["sssNum"];
            $tinNum         = $row["tinNum"];
            $philhealthNum  = $row["philhealthNum"];
            $hdmfNum        = $row["hdmfNum"]; 
            $acting         = $row["acting"] ? "checked" : "";
            $actingStyle    = $acting === "checked" ? " style='display:inline-block;'" : " style='display:none;'";
            $status         = "Current";
            $position       = "";
            $profile        = empty($row["profile"]) ? "img/undraw_profile_2.svg" : substr($row["profile"], 1);
           
            
            $sql = $conn->prepare("SELECT * FROM dbo.positions WHERE id=:position");
            $sql->execute([ "position" => $row["position"]]);
            $rowP = $sql->fetch();

            if($rowP["id"] == 12){
                $sql = $conn->prepare("SELECT * FROM dbo.districts WHERE manager=:employeeID");
                $sql->execute([
                    "employeeID"    => $_SESSION["employeeID"]
                ]);
                $rowP = $sql->fetch();
                $position = $rowP["district"] ." Manager";
            }else
                $position = $rowP["position"];

            $sql = $conn->prepare("SELECT * FROM dbo.departments WHERE id=:id");
            $sql->execute([ "id" => $row["department"]]);
            $rowD = $sql->fetch();
            if($rowD["type"] == "branch")
                $department = ucwords($rowD["name"]) ." Branch";
            else
                $department = ucwords($rowD["name"]);
            
        ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="row">
                <h4 class="col-md-6">Profile Information</h4>
                <div class="col-md-6 mb-1">
                    <a href="editProfile.php"><button class="btn btn-info float-right">Edit Profile</button></a>
                </div>
            </div>
            <div class="row align-items-center" style="border-top: 2px solid;">
                <div class="col-md-3 text-center">
                    <div class="card py-4 position-relative">
                        <p style="margin-bottom:10px !important; font-size:medium;"><strong><?php echo $department; ?></strong></p>
                        
                        <div class="justify-content-center">
                            <div id="edit-pencil">
                                
                                <form id='changeProfile' class='position-absolute'><input type='file' name='imgFile' style='visibility:hidden; position:absolute;' id='profileSelected' accept="image/*"/></form>
                                <button class='btn-default' style='border:0;' id='slctProfile'><i class='fa fa-pencil-alt'></i></button>
                            </div>
                            <img id="profileImg" src="<?php echo $profile; ?>" class="avatar rounded-circle img-thumbnail" alt="avatar" style="width:200px">
                        </div>
                        <p style="margin-bottom:0 !important; font-size:larger;"><strong><?php echo $fullName; ?></strong></p>
                        <p style="margin-bottom:0 !important; font-size:medium;"><strong><span class="acting" <?php echo $actingStyle; ?>>(Acting)&nbsp;</span><?php echo $position; ?></strong></p>
                        <p style="margin-bottom:0 !important; font-size:small;"><strong><?php echo $_SESSION["employeeID"]; ?></strong></p>
                    </div>
                </div>
                <div class="card col-md-9" id="profileInfo">
                    <ul class="nav nav-tabs card-header-tabs" style="margin-bottom:10px;">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#info" style="border-left:0;">Info</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#background">Background</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hobskill">Hobbies & Skills</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#educaward">Education, Exams & Awards</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#exptraining">Experience &Trainings</a></li>
                    </ul>

                    <div class="tab-content">
                        <!-- INFO -->
                        <div id="info" class="tab-pane fade-in active">
                            <div class="row">
                                <div class="col-md-12 row py-1">
                                    <div class="col-md-3">Present Address</div>
                                    <div class="col-md-9"><?php echo $presentAddress; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">Contact Info</div>
                                    <div class="col-md-6"><?php //echo $presentContact; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">Birthday</div>
                                    <div class="col-md-6"><?php echo $birthday; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">Place Of Birth</div>
                                    <div class="col-md-6"><?php echo $placeBirth; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">Gender</div>
                                    <div class="col-md-6"><?php echo $gender; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">Civil Status:</div>
                                    <div class="col-md-6"><?php echo $civilStatus; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">Citizenship</div>
                                    <div class="col-md-6"><?php echo $citizenship; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">Religion</div>
                                    <div class="col-md-6"><?php echo $religion; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">Height</div>
                                    <div class="col-md-6"><?php echo $height; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">Weight</div>
                                    <div class="col-md-6"><?php echo $weight; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">Hair Color</div>
                                    <div class="col-md-6"><?php echo $hairColor; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">Eye Color</div>
                                    <div class="col-md-6"><?php echo $eyeColor; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">Dialect Spoken</div>
                                    <div class="col-md-6"><?php echo $dialectSpoken; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">Distinguised Mark</div>
                                    <div class="col-md-6"><?php echo $mark; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">SSS</div>
                                    <div class="col-md-6"><?php echo $sssNum; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">TIN</div>
                                    <div class="col-md-6"><?php echo $tinNum; ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 row py-1">
                                    <div class="col-md-6">PHILHEALTH</div>
                                    <div class="col-md-6"><?php echo $philhealthNum; ?></div>
                                </div>
                                <div class="col-md-6 row py-1" style="border-left:2px solid;">
                                    <div class="col-md-6">HDMF</div>
                                    <div class="col-md-6"><?php echo $hdmfNum; ?></div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- BACKGROUND -->
                        <div id="background" class="tab-pane fade">
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Family Information</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-4 py1'><strong>Full Name</strong></div>
                                <div class='col-md-3 py1'><strong>Birthday</strong></div>
                                <div class='col-md-2 py1'><strong>Occupation</strong></div>
                                <div class='col-md-2 py1'><strong>Relation</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.family_background WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-4 py1'>$row[fullName]</div>
                                    <div class='col-md-3 py1'>$row[birthday]</div>
                                    <div class='col-md-2 py1'>$row[occupation]</div>
                                    <div class='col-md-2 py1'>$row[relation]</div>
                                </div><hr>";
                                }
                            
                            ?>
                            <hr>
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Beneficiaries</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-4 py1'><strong>Full Name</strong></div>
                                <div class='col-md-4 py1'><strong>Gender</strong></div>
                                <div class='col-md-3 py1'><strong>Birthday</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.beneficiaries WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status" => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-4 py1'>$row[fullName]</div>
                                    <div class='col-md-4 py1'>$row[gender]</div>
                                    <div class='col-md-3 py1'>$row[birthday]</div>
                                </div><hr>";
                                }
                            
                            ?>
                            <hr>
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Dependents</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-3 py1'><strong>Full Name</strong></div>
                                <div class='col-md-2 py1'><strong>Gender</strong></div>
                                <div class='col-md-3 py1'><strong>Birthday</strong></div>
                                <div class='col-md-3 py1'><strong>Relation</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.dependents WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-3 py1'>$row[fullName]</div>
                                    <div class='col-md-2 py1'>$row[gender]</div>
                                    <div class='col-md-3 py1'>$row[birthday]</div>
                                    <div class='col-md-3 py1'>$row[relation]</div>
                                </div><hr>";
                                }
                            
                            ?>
                        </div>
                        <!-- Hobbies And Skills -->
                        <div id="hobskill" class="tab-pane fade">
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Hobbies</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-2 py1'></div>
                                <div class='col-md-5 py1'><strong>Category</strong></div>
                                <div class='col-md-5 py1'><strong>Description</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.hobbies WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-2 py1'>". ++$count ."</div>
                                    <div class='col-md-5 py1'>$row[category]</div>
                                    <div class='col-md-5 py1'>$row[description]</div>
                                </div><hr>";
                                }
                            
                            ?>
                            <hr>
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Skills</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-2 py1'></div>
                                <div class='col-md-5 py1'><strong>Category</strong></div>
                                <div class='col-md-5 py1'><strong>Description</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.skills WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-2 py1'>". ++$count ."</div>
                                    <div class='col-md-5 py1'>$row[category]</div>
                                    <div class='col-md-5 py1'>$row[description]</div>
                                </div><hr>";
                                }
                            
                            ?>
                        </div>
                        <!-- Education And Awards -->
                        <div id="educaward" class="tab-pane fade">
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Education</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-2 py1'><strong>Level</strong></div>
                                <div class='col-md-4 py1'><strong>School Name</strong></div>
                                <div class='col-md-3 py1'><strong>Degree</strong></div>
                                <div class='col-md-2 py1'><strong>Degree</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.education WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                     "status"   => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-2 py1'>$row[lvl]</div>
                                    <div class='col-md-4 py1'>$row[schoolName]</div>
                                    <div class='col-md-3 py1'>$row[degree]</div>
                                    <div class='col-md-2 py1'>$row[schoolYear]</div>
                                </div><hr>";
                                }
                            
                            ?>
                            <hr>
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Licensure / Exams</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-2 py1'><strong>Exam Type</strong></div>
                                <div class='col-md-3 py1'><strong>Description</strong></div>
                                <div class='col-md-2 py1'><strong>Date</strong></div>
                                <div class='col-md-2 py1'><strong>Ratings</strong></div>
                                <div class='col-md-2 py1'><strong>Venue</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.exams WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-2 py1'>$row[examType]</div>
                                    <div class='col-md-3 py1'>$row[description]</div>
                                    <div class='col-md-2 py1'>$row[date]</div>
                                    <div class='col-md-2 py1'>$row[ratings]</div>
                                    <div class='col-md-2 py1'>$row[venue]</div>
                                </div><hr>";
                                }
                            
                            ?>
                            <hr>
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Awards / Recognition</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-2 py1'></div>
                                <div class='col-md-3 py1'><strong>Awards Type</strong></div>
                                <div class='col-md-4 py1'><strong>Description</strong></div>
                                <div class='col-md-3 py1'><strong>Date</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.awards WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-2 py1'>". ++$count ."</div>
                                    <div class='col-md-3 py1'>$row[awardType]</div>
                                    <div class='col-md-4 py1'>$row[description]</div>
                                    <div class='col-md-3 py1'>$row[date]</div>
                                </div><hr>";
                                }
                            
                            ?>
                            <hr>
                        </div>
                        <!-- Experience, Trainings And Org -->
                        <div id="exptraining" class="tab-pane fade">
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Job Experience</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-4 py1'><strong>Employer</strong></div>
                                <div class='col-md-2 py1'><strong>From</strong></div>
                                <div class='col-md-2 py1'><strong>To</strong></div>
                                <div class='col-md-3 py1'><strong>Position</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.experience WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-4 py1'>$row[employer]</div>
                                    <div class='col-md-2 py1'>$row[dateFrom]</div>
                                    <div class='col-md-2 py1'>$row[dateTo]</div>
                                    <div class='col-md-3 py1'>$row[position]</div>
                                </div><hr>";
                                }
                            
                            ?>                 
                            <hr>
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Trainings</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-3 py1'><strong>Host</strong></div>
                                <div class='col-md-3 py1'><strong>Description</strong></div>
                                <div class='col-md-2 py1'><strong>Date</strong></div>
                                <div class='col-md-3 py1'><strong>Venue</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.trainings WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-3 py1'>$row[host]</div>
                                    <div class='col-md-3 py1'>$row[description]</div>
                                    <div class='col-md-2 py1'>$row[date]</div>
                                    <div class='col-md-3 py1'>$row[venue]</div>
                                </div><hr>";
                                }
                            
                            ?>                 
                            <hr>
                            <h6 class="my-1" style="font-size:17px !important;font-weight:bolder;">Organizations</h6>
                            <hr>
                            <div class='row'>
                                <div class='col-md-1 py1'></div>
                                <div class='col-md-4 py1'><strong>Name</strong></div>
                                <div class='col-md-4 py1'><strong>Position</strong></div>
                                <div class='col-md-3 py1'><strong>Year Join</strong></div>
                            </div><hr>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.organizations WHERE employeeID=:employeeID AND status=:status");
                                $sql->execute([
                                    "employeeID" => $_SESSION["employeeID"],
                                    "status"    => $status
                                ]);
                                $count = 0;
                                while($row = $sql->fetch()){
                                echo "
                                <div class='row'>
                                    <div class='col-md-1 py1'>". ++$count ."</div>
                                    <div class='col-md-4 py1'>$row[name]</div>
                                    <div class='col-md-4 py1'>$row[position]</div>
                                    <div class='col-md-3 py1'>$row[yearJoin]</div>
                                </div><hr>";
                                }
                            
                            ?>                 
                            <hr>
                        </div>
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