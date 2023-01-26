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
            $employeeID = $_SESSION["employeeID"];
            $status = "Current";
        ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
        <form id="editSelf" novalidate>
            <div class="container-fluid">
                <h4 style="border-bottom: 2px solid;">Edit Profile</h4>
                <div id="accordion">
                    <!-- Family Background -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#familyBackground">
                            <div class="card-header">
                                Family Background
                            </div>
                        </a>
                        <div id="familyBackground" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendFamilymember">
                                    <?php 
                                        $sqlFam = $conn->prepare("SELECT * FROM dbo.family_background WHERE employeeID=:employeeID AND status=:status");
                                        $sqlFam->execute([ 
                                            "employeeID" => $employeeID,
                                            "status"    => $status
                                        ]);
                                        while($rowFam = $sqlFam->fetch()){
                                        echo "<div class='row appendFamRow' >
                                                <div class='col-md-3 form-group'>
                                                    <label for='fullName'>Full Name:</label>
                                                    <input type='text' class='form-control' name='famFullName[]' id='fullName' value='$rowFam[fullName]'/>
                                                </div>
                                                <div class='col-md-3 form-group'>
                                                    <label for='birthday'>Birthday:</label>
                                                    <input type='date' class='form-control' name='famBirthday[]' id='birthday' value='$rowFam[birthday]' />
                                                </div>
                                                <div class='col-md-3 form-group'>
                                                    <label for='occupation'>Occupation:</label>
                                                    <input type='text' class='form-control' name='famOccupation[]' id='occupation' value='$rowFam[occupation]' />
                                                </div>
                                                <div class='col-md-3 form-group'>
                                                    <label for='relation'>Relation:</label>
                                                    <input type='text' class='form-control' name='famRelation[]' id='relation' value='$rowFam[relation]' />
                                                </div>
                                                <input type='hidden' name='famID[]' value='$rowFam[id]'/>
                                            </div>";
                                        }
                                    ?>
                                    </div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addFamilyMember"><i class="fa fa-plus"></i>Add A Family Member</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dependents -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#dependents">
                            <div class="card-header">
                                Dependents
                            </div>
                        </a>
                        <div id="dependents" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendDependents">
                                        <?php 
                                            $sql = $conn->prepare("SELECT * FROM dbo.dependents WHERE employeeID=:employeeID AND status=:status");
                                            $sql->execute([ 
                                                "employeeID" => $employeeID,
                                                "status"    => $status
                                            ]);
                                            while($row = $sql->fetch()){
                                                $male = $row["gender"] === "Male" ? "selected" : "";
                                                $female = $row["gender"] === "Female" ? "selected" : "";
                                                $birthday = date("Y-m-d",strtotime($row["birthday"]));
                                                echo "<div class='row'>
                                                        <div class='col-md-3 form-group'>
                                                            <label for='fullName'>Full Name:</label>
                                                            <input type='text' class='form-control' name='depFullName[]' id='fullName' placeholder='Ex: Juan Dela Cruz' value='$row[fullName]'/>
                                                        </div>
                                                        <div class='col-md-3 form-group'>
                                                            <label for='gender'>Gender:</label>
                                                            <select class='form-control' name='depGender[]'>
                                                                <option value='Male' $male>Male</option>
                                                                <option value='Female' $female>Female</option>
                                                            </select>
                                                        </div>
                                                        <div class='col-md-3 form-group'>
                                                            <label for='occupation'>Birthday:</label>
                                                            <input type='date' class='form-control' name='depBirthday[]' id='birthday' placeholder='Ex: 01/01/1991' value='$birthday'/>
                                                        </div>
                                                        <div class='col-md-3 form-group'>
                                        
                                                        <label for='occupation'>Relationship:</label>
                                                            <input type='text' class='form-control' name='depRelation[]' id='relation' placeholder='Ex: Sister' value='$row[relation]'/>
                                                        </div>
                                                        <input type='hidden' name='depID[]' value='$row[id]'/>
                                                    </div>";
                                            }
                                        
                                        ?>
                                    </div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addDependents"><i class="fa fa-plus"></i>Add Dependents</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Beneficiaries -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#beneficiaries">
                            <div class="card-header">
                                Beneficiaries
                            </div>
                        </a>
                        <div id="beneficiaries" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendBeneficiaries"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addBeneficiaries"><i class="fa fa-plus"></i>Add Beneficiaries</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hobbies -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#hobbies">
                            <div class="card-header">
                                Hobbies
                            </div>
                        </a>
                        <div id="hobbies" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendHobbies"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addHobbies"><i class="fa fa-plus"></i>Add Hobbies</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Skills -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#skills">
                            <div class="card-header">
                                Skills
                            </div>
                        </a>
                        <div id="skills" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendSkills"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addSkills"><i class="fa fa-plus"></i>Add Skills</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Education Attainment -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#education">
                            <div class="card-header">
                                Education
                            </div>
                        </a>
                        <div id="education" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendEducation"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addEducation"><i class="fa fa-plus"></i>Add Education</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Licensure/Exams -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#exams">
                            <div class="card-header">
                                Licensure / Exams
                            </div>
                        </a>
                        <div id="exams" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendExams"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addExams"><i class="fa fa-plus"></i>Add Exams</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Awards -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#awards">
                            <div class="card-header">
                                Awards
                            </div>
                        </a>
                        <div id="awards" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendAwards"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addAwards"><i class="fa fa-plus"></i>Add Awards</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Job Experience -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#job">
                            <div class="card-header">
                                Job Experience
                            </div>
                        </a>
                        <div id="job" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendJob"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addJob"><i class="fa fa-plus"></i>Add Job</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Trainings / Seminar -->
                    <div class="card">
                        <a class="card-link collapsed" data-toggle="collapse" href="#trainings">
                            <div class="card-header">
                                Trainings / Seminar
                            </div>
                        </a>
                        <div id="trainings" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div id="appendTrainings"></div>
                                    <button class="btn btn-info float-right mb-3" type="button" id="addTrainings"><i class="fa fa-plus"></i>Add Trainings/Seminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-info float-right mt-3">Submit</button>
            </div> 
        </form>
        
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>