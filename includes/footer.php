
            </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-outline-danger" id="logoutBtn">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <form id="formAddUser">
                <div class="modal-body">
                    <div class="form-group d-flex">
                        <div class="col-md-4">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" name="firstName" id="firstName" required>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" name="lastName" id="lastName" required>
                        </div>
                        <div class="col-md-4">
                            <label for="middleName">Middle Name:</label>
                            <input type="text" class="form-control" name="middleName" id="middleName">
                        </div>
                    </div>
                    <div class="form-group d-flex">
                        <div class="col-md-6">
                            <label for="employeeID">Employee ID:</label>
                            <input type="text" class="form-control" name="employeeID" id="employeeID" required>
                        </div>
                        <div class="col-md-6">
                            <label for="department">Department:&nbsp;</label>
                            <select class="form-control" id="department" name="department">
                                <?php 
                                    
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-info" id="logoutBtn">Save</a>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete user?</div>
                <div class="modal-footer">  
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-outline-danger" id="deleteBtn">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="liquidateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="" id="liquiForm">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Liquidate</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" id='liquiModalBody'>
                        <div class="row justify-content-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" style='color:white'>Amount</label>
                                        <input class="form-control" name='amount' id="liquiAmount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="file-drop-area">
                                        <span class="choose-file-button">Choose files</span>
                                        <span class="file-message">or drag and drop files here</span>
                                        <input class="file-input" name='slctFiles[]' id='liquiFiles' type="file" multiple>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="filesSelected" class='col-md-12'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Confirm</a>
                        <button class="btn btn-secondary" id='cancelLiqui' type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="leaveImagesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/MonthPicker.min.js"></script>
    <script src="js/bootstrap4datepicker.min.js"></script>
    <script src="js/gijgo.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="swiper/swiper-bundle.min.js"></script>
    
    <script src="js/canvas.js?v=<?php echo rand(); ?>"></script>
    <!-- Function script for all pages -->
    <script src="js/functions.js?v=<?php echo rand(); ?>"></script>
</body>

</html>