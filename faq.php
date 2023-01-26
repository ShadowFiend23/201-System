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
        
        <div class="container-fluid">
            <div class="accordion mb-3" id="accordionExample">
                <div class="card">
                    <div class="card-header border border-info" id="headingOne">
                        <h2 class="mb-0">
                            <button class="accor btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne">
                            How To Edit Profile?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><h5 style='font-weight: bold'>Step 1 </h5>
                                    <div class="row">
                                        <p class='col-md-3'>Go To Your Dashboard</p>
                                        <img style="height:230px; float:left;" src='/img/faq/go-to-dashboard.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 2 </h5>
                                    <p>Click Edit Profile Button</p>
                                    <img class='col-md-8' src='/img/faq/click-edit-profile.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 3 </h5>
                                    <p>Select The Tab You Want To Edit. (Ex. Family Background, Dependents), Then Click The Add Button.</p>
                                    <img class='col-md-8' src='/img/faq/click-add.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 4 </h5>
                                    <p>Fill Up The Form.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 5 </h5>
                                    <p>Select Another Tabs and Click Add Button To Insert.</p>
                                    <img class='col-md-8' src='/img/faq/tabs.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 6 </h5>
                                    <p>Fill All The Forms.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 7 </h5>
                                    <p>Click Submit Button At Bottom Of The Page. (NOTE: HR Will Approve The Edit Profile Request)</p>
                                    <img class='col-md-8' src='/img/faq/click-submit.png' alt='Dashboard Image' />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border border-info" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="accor btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How To Update Profile Picture?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><h5 style='font-weight: bold'>Step 1 </h5>
                                    <div class="row">
                                        <p class='col-md-3'>Go To Your Dashboard</p>
                                        <img style="height:230px; float:left;" src='/img/faq/go-to-dashboard.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 2 </h5>
                                    <div class="row">
                                        <p>Click The Pencil Button Above The Image</p>
                                        <img style="height:230px; float:left;" src='/img/faq/click-the-pencil.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 3 </h5>
                                    <p>Select The Image You Want As A Profile</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 4 </h5>
                                    <p>If Successfully Saved, The Image Will Display Immediately.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border border-info" id="headingThree">
                        <h2 class="mb-0">
                            <button class="accor btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                How To Request Leave?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><h5 style='font-weight: bold'>Step 1 </h5>
                                    <div class="row">
                                        <p class='col-md-4'>Go To Request Tab Under The Leaves Option</p>
                                        <img style="height:230px; float:left;" src='/img/faq/request-leave.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 2 </h5>
                                    <p>Select The Type Of Leave</p>
                                    <img class='col-md-8' src='/img/faq/select-leave2.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 3 </h5>
                                    <p>Fill Up The Remaining Inputs In The Form.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 4 </h5>
                                    <p>Click The Add Signature Button.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 5 </h5>
                                    <p>Draw Your Signature Inside The Canvas.</p>
                                    <img class='col-md-8' src='/img/faq/add-signature.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 6 </h5>
                                    <p>Save Signature</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 7 </h5>
                                    <p>Submit Your Request.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 8 </h5>
                                    <div class="row">
                                        <p class='col-md-5'>Go To The Info Tab Under The Leaves Option</p>
                                        <img style="height:230px; float:left;" src='/img/faq/info-leaves.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 9 </h5>
                                    <p>You Can See Your Leave Request. You Can Click The View Button (Eye Symbol) To View Your Request.</p>
                                    <img class='col-md-8' src='/img/faq/request-list.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 10 </h5>
                                    <p>Wait For The Approval Of Your Request.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border border-info" id="headingFour">
                        <h2 class="mb-0">
                            <button class="accor btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                How to Request Hospitalization?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                        <div class="card-body border-bottom-1 border-info">
                            <ul>
                                <li><h5 style='font-weight: bold'>Step 1 </h5>
                                    <div class="row">
                                        <p class='col-md-4'>Go To Request Tab Under The MED-HAP Option.</p>
                                        <img style="height:230px; float:left;" src='/img/faq/request-med.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 2 </h5>
                                    <p>Select Hospitalization In The Type Of MED-HAP.</p>
                                    <img class='col-md-10' src='/img/faq/hospitalization.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 3 </h5>
                                    <p>Add Amount. (NOTE: First Request Maximum Amount For Hospitalization Is ₱ 10,000)</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 4 </h5>
                                    <p>Select If The Hospitalization Is For Yourself. (If For Dependents, Be Sure To Add Your Dependents In Your Profile Before Coming Back Here To Request.)</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img class="col-md-12" src='/img/faq/self.png' alt='Dashboard Image' />
                                        </div>
                                        <div class="col-md-6">
                                            <img class="col-md-12" src='/img/faq/dependents.png' alt='Dashboard Image' />
                                        </div>
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 5 </h5>
                                    <p>Submit Your Request</p>
                                </li>
                                <li><h5 style='font-weight: bold'>Step 6 </h5>
                                    <div class="row">
                                        <p class='col-md-5'>Go To The Info Tab Under The MED-HAP Option</p>
                                        <img style="height:230px; float:left;" src='/img/faq/info-med-hap.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 7 </h5>
                                    <p>Click Request List</p>
                                    <img class='col-md-10' src='/img/faq/click-request-list.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 8 </h5>
                                    <p>You Can See Your MED-HAP Request Status.</p>
                                    <img class='col-md-10' src='/img/faq/request-list-med.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 9 </h5>
                                    <p>Wait For The Approval Of Your Request.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border border-info" id="headingFive">
                        <h2 class="mb-0">
                            <button class="accor btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                How To Request Eye-Care?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><h5 style='font-weight: bold'>Step 1 </h5>
                                    <div class="row">
                                        <p class='col-md-4'>Go To Request Tab Under The MED-HAP Option.</p>
                                        <img style="height:230px; float:left;" src='/img/faq/request-med.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 2 </h5>
                                    <p>Select Eye Care In The Type Of MED-HAP.</p>
                                    <img class='col-md-10' src='/img/faq/eye-care2.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 3 </h5>
                                    <p>Add Amount.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 5 </h5>
                                    <p>Submit Your Request</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 6 </h5>
                                    <div class="row">
                                        <p class='col-md-5'>Go To The Info Tab Under The MED-HAP Option</p>
                                        <img style="height:230px; float:left;" src='/img/faq/info-med-hap.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 7 </h5>
                                    <p>Click Request List</p>
                                    <img class='col-md-10' src='/img/faq/click-request-list.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 8 </h5>
                                    <p>Click Eye Care Tab</p>
                                    <img class='col-md-10' src='/img/faq/eye-care-tab.png' alt='Dashboard Image' />
                                </li>
                                <li><h5 style='font-weight: bold'>Step 8 </h5>
                                    <p>You Can See Your Eye Care Request Status.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 9 </h5>
                                    <p>Wait For The Approval Of Your Request.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border border-info" id="headingSix">
                        <h2 class="mb-0">
                            <button class="accor btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                How To Request Check-Up?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><h5 style='font-weight: bold'>Step 1 </h5>
                                    <div class="row">
                                        <p class='col-md-4'>Go To Request Tab Under The MED-HAP Option.</p>
                                        <img style="height:230px; float:left;" src='/img/faq/request-med.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 2 </h5>
                                    <p>Select Check-up In The Type Of MED-HAP.</p>
                                    <img class='col-md-10' src='/img/faq/check-up2.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 3 </h5>
                                    <p>Add Amount.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 5 </h5>
                                    <p>Submit Your Request</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 6 </h5>
                                    <div class="row">
                                        <p class='col-md-5'>Go To The Info Tab Under The MED-HAP Option</p>
                                        <img style="height:230px; float:left;" src='/img/faq/info-med-hap.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 7 </h5>
                                    <p>Click Request List</p>
                                    <img class='col-md-10' src='/img/faq/click-request-list.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 8 </h5>
                                    <p>Click Check-Up Tab</p>
                                    <img class='col-md-10' src='/img/faq/check-up-tab.png' alt='Dashboard Image' />
                                </li>
                                <li><h5 style='font-weight: bold'>Step 8 </h5>
                                    <p>You Can See Your Check-Up Request Status.</p>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 9 </h5>
                                    <p>Wait For The Approval Of Your Request.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="card">
                    <div class="card-header border border-info" id="headingSeven">
                        <h2 class="mb-0">
                            <button class="accor btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                How To Approve/Disapproved?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                        <div class="card-body">
                            <ul>
                                <li><h5 style='font-weight: bold'>Step 1 </h5>
                                    <div class="row">
                                        <p class='col-md-4'>Go To Approvals Tab.</p>
                                        <img style="height:230px; float:left;" src='/img/faq/approval-tab.png' alt='Dashboard Image' />
                                    </div>
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 2 </h5>
                                    <p>Select The Request You Want To Approve or Disapprove.</p>
                                    <img class='col-md-10' src='/img/faq/click-eye.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 3 </h5>
                                    <p>Click Approve/Endorse or Disapprove Button</p>
                                    <img class='col-md-10' src='/img/faq/approve-disapproved.png' alt='Dashboard Image' />
                                </li>
                                <hr style='border-top:2px solid;'>
                                <li><h5 style='font-weight: bold'>Step 5 </h5>
                                    <p>If Success This Will Be The Final Output.</p>
                                    <img class='col-md-10' src='/img/faq/finish-approved.png' alt='Dashboard Image' />
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Begin Page Content -->
        
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
<?php 
    require "includes/footer.php";
?>