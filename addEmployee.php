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
        <form id="addEmployee">
            <div class="container-fluid">
                <h4 style="border-bottom: 2px solid;">Add New Employee</h4>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="employeeID">Employee ID:</label>
                        <input type="text" class="form-control" name="employeeID" id="employeeID" placeholder="Ex: 010111-000" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Ex: Juan" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Ex: Dela Cruz" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="middleName">Middle Name:</label>
                        <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Ex: Rizal">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="dateHired">Date Hired:</label>
                        <input type="date" class="form-control" name="dateHired" id="dateHired" placeholder="01/09/2011">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="slctPosition">Position:</label>
                        <select class="form-control select2 searchChief" name="position" id="slctPosition">
                            <option></option>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.positions");
                                $sql->execute();
                                while($row = $sql->fetch()){
                                    echo "<option value='$row[id]'>$row[position]</option>";
                                }
                            
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="slctDepartment">Department:</label>
                        <select class="form-control select2 searchChief" name="department" id="slctDepartment">
                            <option></option>
                            <?php 

                                $sql = $conn->prepare("SELECT * FROM dbo.departments ORDER BY name");
                                $sql->execute();
                                while($row = $sql->fetch()){
                                    $name = ucwords($row["name"]);
                                    echo "<option value='$row[id]'>$name</option>";
                                }
                            
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="supervisor">Supervisor:</label>
                        <select class="form-control select2" name="supervisor" id="supervisor" disabled>
                            <?php 

                            
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="chief">Chief:</label>
                        <select class="form-control select2" name="chief" id="chief" disabled>
                            <?php 

                                
                            ?>
                        </select>
                    </div>
                </div>
                <div id="hidden">

                </div>
                <button type="submit" class="btn btn-info float-right mt-3">Submit</button>
            </div> 
        </form>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>