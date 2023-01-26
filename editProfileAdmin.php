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
            $employeeID = $_GET["employeeID"];
            $sql = $conn->prepare("SELECT * FROM dbo.employee_info WHERE employeeID=:employeeID");
            $sql->execute([ "employeeID" => $employeeID]);
            $row = $sql->fetch();
        ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
        <form id="editEmployee" novalidate>
            <input type="hidden" name="employeeID" value=<?php echo $employeeID; ?>/>
            <div class="container-fluid">
                <h4 style="border-bottom: 2px solid;">Edit Profile</h4>
                <div id="accordion">
                    <!-- Employee Information -->
                    <div class="card">
                        <a class="card-link" data-toggle="collapse" href="#employeeInfo">
                            <div class="card-header">
                                Profile Information
                            </div>
                        </a>
                        <div id="employeeInfo" class="collapse show" data-parent="#accordion">
                            <div class="card-body">
                                <!-- Names -->
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="employeeID">Employee ID:</label>
                                        <input type="text" class="form-control" name="employeeID" id="employeeID" value="<?php echo $row["employeeID"];  ?>" placeholder="Ex: 010111-000" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="firstName">First Name:</label>
                                        <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $row["firstName"];  ?>" placeholder="Ex: Juan" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="lastName">Last Name:</label>
                                        <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $row["lastName"];  ?>" placeholder="Ex: Dela Cruz" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="middleName">Middle Name:</label>
                                        <input type="text" class="form-control" name="middleName" id="middleName" value="<?php echo $row["middleName"];  ?>" placeholder="Ex: Rizal" >
                                    </div>
                                </div>
                                <!-- Present Address -->
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        <label for="presentAddress">Present Address:</label>
                                        <input type="text" class="form-control" name="presentAddress" id="presentAddress" value="<?php echo $row["presentAddress"];  ?>" placeholder="Ex: Arradaza Street, Ormoc City, Leyte" >
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="presentContact">Contact Info:</label>
                                        <input type="text" class="form-control" name="presentContact" id="presentContact" value="<?php echo $row["presentContact"];  ?>" placeholder="Ex: 09123456789" >
                                    </div>
                                </div>
                                <!-- Home Address -->
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        <label for="homeAddress">Home Address:</label>
                                        <input type="text" class="form-control" name="homeAddress" id="homeAddress" value="<?php echo $row["homeAddress"];  ?>" placeholder="Ex: Arradaza Street, Ormoc City, Leyte">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="homeContact">Contact Info:</label>
                                        <input type="text" class="form-control" name="homeContact" id="homeContact" value="<?php echo $row["homeContact"];  ?>" placeholder="Ex: 09123456789">
                                    </div>
                                </div>
                                <!-- Birthday, Place Of Birth, Gender, Religion -->
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="birthday">Birthday:</label>
                                        <input type="text" class="form-control" name="birthday" id="birthday" value="<?php if(!empty($row["birthday"])) echo date("m-d-Y",strtotime($row["birthday"]));   ?>" placeholder="Ex: 01/01/1991" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="placeBirth">Place Of Birth:</label>
                                        <input type="text" class="form-control" name="placeBirth" id="placeBirth" value="<?php echo $row["placeBirth"];  ?>" placeholder="Ex: Ormoc City" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="gender">Gender:</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option hidden>Please Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="religion">Religion:</label>
                                        <input type="text" class="form-control" name="religion" id="religion" value="<?php echo $row["religion"];  ?>" placeholder="Ex: Roman Catholic" >
                                    </div>
                                </div>
                                <!-- Citizenship, Civil Status, Height, Weight -->
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="citizenship">Citizenship:</label>
                                        <input type="text" class="form-control" name="citizenship" id="citizenship" value="<?php echo $row["citizenship"];  ?>" placeholder="Ex: Filipino" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="civilStatus">Civil Status:</label>
                                        <select name="civilStatus" id="civilStatus" class="form-control">
                                            <option hidden>Please Select Civil Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Divorced">Divorced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="height">Height:</label>
                                        <input type="text" class="form-control" name="height" id="height" value="<?php echo $row["height"];  ?>" placeholder="Ex: 5'7 / 170 cm">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="weight">Weight:</label>
                                        <input type="text" class="form-control" name="weight" id="weight" value="<?php echo $row["weight"];  ?>" placeholder="Ex: 80 kg / 176 lbs">
                                    </div>
                                </div>
                                <!-- Hair Color, Eye Color, Dialect Spoken, Mark -->
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="hairColor">Hair Color:</label>
                                        <input type="text" class="form-control" name="hairColor" id="hairColor" value="<?php echo $row["hairColor"];  ?>" placeholder="Ex: White">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="eyeColor">Eye Color:</label>
                                        <input type="text" class="form-control" name="eyeColor" id="eyeColor" value="<?php echo $row["eyeColor"];  ?>" placeholder="Ex: Blue">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="dialectSpoken">Dialect Spoken:</label>
                                        <input type="text" class="form-control" name="dialectSpoken" id="dialectSpoken" value="<?php echo $row["dialectSpoken"];  ?>" placeholder="Ex: Bisaya, Ilocano, Waray">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="mark">Distinguished Mark:</label>
                                        <input type="text" class="form-control" name="mark" id="mark" value="<?php echo $row["mark"];  ?>" placeholder="Ex: Mole in the Nose">
                                    </div>
                                </div>
                                <!-- SSS, TIN, Philhealth, HDMF -->
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="sssNum">SSS Number:</label>
                                        <input type="text" class="form-control" name="sssNum" id="sssNum" value="<?php echo $row["sssNum"];  ?>" placeholder="Ex: 22-1213122-2" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="tinNum">TIN Number:</label>
                                        <input type="text" class="form-control" name="tinNum" id="tinNum" value="<?php echo $row["tinNum"];  ?>" placeholder="Ex: 123-456-789-000" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="philhealthNum">PHILHEALTH Number:</label>
                                        <input type="text" class="form-control" name="philhealthNum" id="philhealthNum" value="<?php echo $row["philhealthNum"];  ?>" placeholder="Ex: 01-123456789-0" >
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="hdmfNum">HDMF Number:</label>
                                        <input type="text" class="form-control" name="hdmfNum" id="hdmfNum" value="<?php echo $row["hdmfNum"];  ?>" placeholder="Ex: 1234-5678-9101" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        $sqlFam = $conn->prepare("SELECT * FROM dbo.family_background WHERE employeeID=:employeeID");
                                        $sqlFam->execute([ "employeeID" => $employeeID]);
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
                                    <div id="appendDependents"></div>
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