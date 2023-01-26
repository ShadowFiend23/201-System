$(function(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $("#sidebarToggleTop").trigger('click');
    }

    // const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)

    // if(vw < 768){
    //     $("#employeeLeaveTable,#employeeMedhapTable,#hospitalInfo,#eyecareInfo,#checkupInfo,#reRequestInfo").addClass('table-responsive');
    // }else{
    //     $("#employeeMedhapTable,#hospitalInfo,#eyecareInfo,#checkupInfo,#reRequestInfo").removeClass('table-responsive');
    // }
    let leavesTable,leaveSumTable,medhapSumTable,employeeTable,employeeLeaveTable,signatoryTable,tempImgPaths = [];

    $(".navlink").removeClass(".active");
    var path = window.location.pathname;
    var page = path.split("/"). pop();
    page = page.split(".")[0];

    let Base64 = {

        // private property
        _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    
        // public method for decoding
        decode : function (input) {
          var output = "";
          var chr1, chr2, chr3;
          var enc1, enc2, enc3, enc4;
          var i = 0;
    
          input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
    
          while (i < input.length) {
    
            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));
    
            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;
    
            output = output + String.fromCharCode(chr1);
    
            if (enc3 != 64) {
              output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
              output = output + String.fromCharCode(chr3);
            }
    
          }
    
          output = Base64._utf8_decode(output);
    
          return output;
    
        },
    
        // private method for UTF-8 decoding
        _utf8_decode : function (utftext) {
          var string = "";
          var i = 0;
          var c = c1 = c2 = 0;
    
          while ( i < utftext.length ) {
    
            c = utftext.charCodeAt(i);
    
            if (c < 128) {
              string += String.fromCharCode(c);
              i++;
            }
            else if((c > 191) && (c < 224)) {
              c2 = utftext.charCodeAt(i+1);
              string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
              i += 2;
            }
            else {
              c2 = utftext.charCodeAt(i+1);
              c3 = utftext.charCodeAt(i+2);
              string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
              i += 3;
            }
    
          }
    
          return string;
        }
    
      }
    
    $('[data-toggle="tooltip"]').tooltip()

    if(page == ""){
        $("#indexID").parent().addClass("active");
    }else{
        $("#" + page + "ID").parent().addClass("active");
    }

    function ajaxError(jqXHR, exception){
        if (jqXHR.status === 0) {
            Swal.fire('Failed', "No Internet Connection.", 'error');
        } else if (jqXHR.status == 404) {
            Swal.fire('Failed', "Server Error. Try Again later", 'error');
        } else if (jqXHR.status == 500) {
            Swal.fire('Failed', "Server Error. Try Again later", 'error');
        } else if (exception === 'parsererror') {
            Swal.fire('Failed', "Server Error. Try Again later", 'error');
        } else if (exception === 'timeout') {
            Swal.fire('Failed', "Very Slow Connection. Try Again Later.", 'error');
        } else if (exception === 'abort') {
            Swal.fire('Failed', "Connection Aborted.", 'error');
        } else {
            Swal.fire('Failed', 'Uncaught Error.\n' + jqXHR.responseText, 'error');
        }
    }
    
    function isValidDate(year, month, day) {
        var d = new Date(year, month, day);
        if (d.getFullYear() == year && d.getMonth() == month && d.getDate() == day) {
            return true;
        }
        return false;
    }

    $("#logoutBtn").on("click",function(){
        window.location.href = "http://201.occcicoop.com/logout.php"
    })
    $('.select2#slctPosition').select2({
        placeholder: "Please Select Position"
    });
    $('.select2#slctDepartment').select2({
        placeholder: "Please Select Department"
    });
    $('.select2#leaveType').select2({
        placeholder: "Please Select Leave Type"
    });
    $("#supervisor,#chief").select2();

    function leaveReportsTable(){
        $.ajax({
            url:"ajax/loadLeaveReports.php",
            type:"POST",
            success:function(data){
                let response = $.parseJSON(data);

                leaveSumTable = $('#leaveSumTable').DataTable({
                    "lengthChange": false,
                    "pageLength" : 5,
                    "language": {
                        "emptyTable": "No Data Found"
                    }
                });

                if(response["html"] == ""){
                    leaveSumTable.clear().draw();
                }else{
                    
                    $("#leaveSumTableList").children().remove();
                    leaveSumTable.clear().destroy();
                    $("#leaveSumTableList").html(response["html"]);
                    leaveSumTable = $('#leaveSumTable').DataTable({
                        "lengthChange": false,
                        "pageLength" : 5,
                        "language": {
                            "emptyTable": "No Data Found"
                        }
                    });

                }
                leaveSumTable.on('order.dt search.dt', function () {
                    let i = 1;
             
                    leaveSumTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                        this.data(i++);
                    });
                }).draw();
            }
        })
    }
    function medhapReportsTable(){
        $.ajax({
            url:"ajax/loadMedHapReports.php",
            type:"POST",
            success:function(data){
                let response = $.parseJSON(data);

                medhapSumTable = $('#medhapSumTable').DataTable({
                    "lengthChange": false,
                    "pageLength" : 5,
                    "language": {
                        "emptyTable": "No Data Found"
                    }
                });

                if(response["html"] == ""){
                    medhapSumTable.clear().draw();
                }else{
                    
                    $("#lmedhapSumTableList").children().remove();
                    medhapSumTable.clear().destroy();
                    $("#medhapSumTableList").html(response["html"]);
                    medhapSumTable = $('#medhapSumTable').DataTable({
                        "lengthChange": false,
                        "pageLength" : 5,
                        "language": {
                            "emptyTable": "No Data Found"
                        }
                    });

                }
                medhapSumTable.on('order.dt search.dt', function () {
                    let i = 1;
             
                    medhapSumTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                        this.data(i++);
                    });
                }).draw();
            }
        })
    }

    function adjustRepDate(month,day,year){
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];
        let today,endDay,dd,mm,yyyy;
        if(typeof month === "undefined" || typeof day === "undefined" || typeof year === "undefined")
            today = new Date();
        else
            today = new Date(year, month - 1, day);
        
        
        dd = String(today.getDate()).padStart(2, '0');
        mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        yyyy = today.getFullYear();
        
        
        $("#reportMonth option[value="+ mm+"]").prop("selected",true);

        if(dd > 15){
            $("#reportDay option[value='16']").prop("selected",true);
            endDay = new Date(yyyy, mm, 0).getDate();
        }else{
            $("#reportDay option[value='1']").prop("selected",true);
            endDay = 15;
        }
        
        
        $("#reportEndDate").html(monthNames[parseInt(mm)-1] + " " + endDay + ", " + yyyy);
    }

    function adjustRepDateMed(month,day,year){
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];
        let today,endDay,dd,mm,yyyy;
        if(typeof month === "undefined" || typeof day === "undefined" || typeof year === "undefined")
            today = new Date();
        else
            today = new Date(year, month - 1, day);
        
        
        dd = String(today.getDate()).padStart(2, '0');
        mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        yyyy = today.getFullYear();
        
        
        $("#reportMonthMed option[value="+ mm+"]").prop("selected",true);

        if(dd > 15){
            $("#reportDayMed option[value='16']").prop("selected",true);
            endDay = new Date(yyyy, mm, 0).getDate();
        }else{
            $("#reportDayMed option[value='1']").prop("selected",true);
            endDay = 15;
        }
        
        
        $("#reportEndDateMed").html(monthNames[parseInt(mm)-1] + " " + endDay + ", " + yyyy);
    }

    if(page == "index" || page == ""){
        adjustRepDate();
        adjustRepDateMed();
        leaveReportsTable();
        medhapReportsTable();
    }else if(page == "leaves"){
        $.ajax({
            url:"ajax/loadAllLeaves.php",
            type:"POST",
            success:function(data){
                let response = $.parseJSON(data);

                leavesTable = $('#leavesTable').DataTable({
                    "lengthChange": false,
                    "pageLength" : 5,
                    "language": {
                        "emptyTable": "No Data Found"
                    }
                });

                if(response["html"] == ""){
                    leavesTable.clear().draw();
                }else{
                    
                    $("#leavesTableList").children().remove();
                    leavesTable.clear().destroy();
                    $("#leavesTableList").html(response["html"]);
                    leavesTable = $('#leavesTable').DataTable({
                        "lengthChange": false,
                        "pageLength" : 5,
                        "language": {
                            "emptyTable": "No Data Found"
                        }
                    });

                }
            }
        })
    }else if(page == "med-hap"){
        med_hapTable = $('#med-hapTable').DataTable({
            "lengthChange": false,
            "pageLength" : 5,
            "language": {
                "emptyTable": "No Data Found"
            }
        });
    }else if(page == "employeeList"){   
        $.ajax({
            url:"ajax/loadEmployee.php",
            type:"POST",
            success:function(data){
                let response = $.parseJSON(data);

                employeeTable = $('#employeeTable').DataTable({
                    "lengthChange": false,
                    "pageLength" : 5,
                    "language": {
                        "emptyTable": "No Data Found"
                    }
                });

                if(response["html"] == ""){
                    employeeTable.clear().draw();
                }else{
                    
                    $("#employeeTableList").children().remove();
                    employeeTable.clear().destroy();
                    $("#employeeTableList").html(response["html"]);
                    employeeTable = $('#employeeTable').DataTable({
                        "lengthChange": false,
                        "pageLength" : 5,
                        "language": {
                            "emptyTable": "No Data Found"
                        }
                    });

                }
            }
        })
    }else if(page == "info-leaves"){   
        $.ajax({
            url:"ajax/loadEmployeeLeaves.php",
            type:"POST",
            success:function(data){
                let response = $.parseJSON(data);

                employeeLeaveTable = $('#employeeLeaveTable').DataTable({
                    "lengthChange": false,
                    "pageLength" : 5,
                    "language": {
                        "emptyTable": "No Data Found"
                    }
                });

                if(response["html"] == ""){
                    employeeLeaveTable.clear().draw();
                }else{
                    
                    $("#employeeLeaveTableList").children().remove();
                    employeeLeaveTable.clear().destroy();
                    $("#employeeLeaveTableList").html(response["html"]);
                    employeeLeaveTable = $('#employeeLeaveTable').DataTable({
                        "lengthChange": false,
                        "pageLength" : 5,
                        "language": {
                            "emptyTable": "No Data Found"
                        }
                    });

                }
            }
        })
    }else if(page == "approvals"){
        $.ajax({
            url:"ajax/loadApprovals.php",
            type:"POST",
            success:function(data){
                let response = $.parseJSON(data);

                signatoryTable = $('#signatoryTable').DataTable({
                    "lengthChange": false,
                    "pageLength" : 5,
                    "language": {
                        "emptyTable": "No Data Found"
                    }
                });

                if(response["html"] == ""){
                    signatoryTable.clear().draw();
                }else{
                    
                    $("#signatoryTableList").children().remove();
                    signatoryTable.clear().destroy();
                    $("#signatoryTableList").html(response["html"]);
                    signatoryTable = $('#signatoryTable').DataTable({
                        "lengthChange": false,
                        "pageLength" : 5,
                        "language": {
                            "emptyTable": "No Data Found"
                        }
                    });

                }
            }
        })
    }else if(page == "info-med-hap"){
        
        $('#employeeMedReqTable').DataTable({
            "lengthChange": false,
            "pageLength" : 5,
            "language": {
                "emptyTable": "No Data Found"
            }
        });
    }else if(page == "reqMed-hap"){
        
        $('#reqMedhapTable').DataTable({
            "lengthChange": false,
            "pageLength" : 5,
            "language": {
                "emptyTable": "No Data Found"
            }
        });
    }else if(page == "profiles"){

        $('#profilesTable').DataTable({
            "lengthChange": false,
            "pageLength" : 5,
            "language": {
                "emptyTable": "No Pending Profile Found."
            }
        });
    }

    $("#slctProfile").on("click",function(){
        $("#profileSelected").trigger("click");
    })

    $("#profileSelected").on("change",function(){
        $("#changeProfile").trigger("submit");
    })
    $("#changeProfile").on("submit",function(e){
        e.preventDefault();
        let frmData = new FormData($(this)[0]);
        $.ajax({
            url:"ajax/saveProfilePic.php",
            type:"POST",
            data: frmData,
            success:function(data){
                let response = $.parseJSON(data);
                if(response.result){
                    //$("#profileImg").prop("src",response.path);
                    Swal.fire('Success', response.msg, 'success').then(function() {
                        window.location.href='./employee.php';
                    });
                }else{
                    Swal.fire('Failed', response.msg, 'error');
                }
            },
            cache: false,
            contentType: false,
            processData: false,
            error: function (jqXHR, exception){
                ajaxError(jqXHR, exception)
            }
        })
    })

    $(".startChange").on("change",function(){
        let month = $("#reportMonth").val();
        let day = $("#reportDay").val();
        let year = $("#reportYear").val();
        adjustRepDate(month,day,year);
    })
    $(".startChangeMed").on("change",function(){
        let month = $("#reportMonthMed").val();
        let day = $("#reportDayMed").val();
        let year = $("#reportYearMed").val();
        adjustRepDateMed(month,day,year);
    })

    $(".card-link").on("click",function(){
        if($(".card-link.collapsed").length == $(".card-link").length)
            $("#editEmployee").removeAttr("novalidate");
        else
            $("#editEmployee").attr("novalidate","novalidate");
    });

    $("#editEmployee").on("submit",function(e){
        e.preventDefault();
        let thisForm = $(this);
        let fillCount = 0;
        if($(".card-link.collapsed").length == $(".card-link").length){
            thisForm.find("input").each(function(){
                if($(this).prop('required') && !$(this).val()){
                    Swal.fire('Failed', "Please Fill " + $(this).prev().html().slice(0,-1), 'warning');
                    fillCount++;
                    return false;
                }
            });
        }
        if(fillCount == 0){
            let frmData = new FormData(thisForm[0]);
            $.ajax({
                url:"ajax/saveEditEmployee.php",
                type:"POST",
                data: frmData,
                success:function(data){
                    let response = $.parseJSON(data);
                    if(response.result){
                        Swal.fire('Success', response.msg, 'success').then(function() {
                            window.location.href='/employeeList.php';
                        });
                    }else{
                        Swal.fire('Failed', response.msg, 'error');
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function (jqXHR, exception){
                    ajaxError(jqXHR, exception)
                }
            })
        }
        
    })

    $("#editSelf").on("submit",function(e){
        e.preventDefault();
        let thisForm = $(this);
        let fillCount = 0;
        if($(".card-link.collapsed").length == $(".card-link").length){
            thisForm.find("input").each(function(){
                if($(this).prop('required') && !$(this).val()){
                    Swal.fire('Failed', "Please Fill " + $(this).prev().html().slice(0,-1), 'warning');
                    fillCount++;
                    return false;
                }
            });
        }
        if(fillCount == 0){
            let frmData = new FormData(thisForm[0]);
            $.ajax({
                url:"ajax/saveEditSelf.php",
                type:"POST",
                data: frmData,
                success:function(data){
                    let response = $.parseJSON(data);
                    if(response.result){
                        Swal.fire('Success', response.msg, 'success').then(function() {
                            window.location.href='/employee.php';
                        });
                    }else{
                        Swal.fire('Failed', response.msg, 'error');
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function (jqXHR, exception){
                    ajaxError(jqXHR, exception)
                }
            })
        }
        
    })
    $("#addEmployee").on("submit",function(e){
        e.preventDefault();
        let frmData = new FormData($(this)[0]);
        let position = $("#slctPosition").val();

        if( position == ""){
            Swal.fire('Failed', "Please Select Position", 'warning');
        }else if($("#slctDepartment").val() == ""){
            Swal.fire('Failed', "Please Select Department", 'warning');
        }else if(position == 12){
            Swal.fire({
                title: '<strong>Please Select District</strong>',
                type: 'info',
                html:"\
                    <select class='form-control' id='districtOption'>\
                        <option value='1'>District 1</option>\
                        <option value='2'>District 2 </option>\
                        <option value='3'>District 3 </option>\
                        <option value='4'>District 4 </option>\
                        <option value='5'>District 5 </option>\
                    </select>\
                ",
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: true,
                preConfirm: function(){
                    return new Promise((resolve, reject) => {
                        // get your inputs using their placeholder or maybe add IDs to them
                        resolve({
                            district: $('#districtOption').val(),
                        });
        
                        // maybe also reject() on some condition
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((data) => {
                frmData.append("district",data.value.district);
                $.ajax({
                    url:"ajax/saveEmployee.php",
                    type:"POST",
                    data: frmData,
                    success:function(data){
                        let response = $.parseJSON(data);
                        if(response.result){
                            $("#addEmployee")[0].reset();
                            $('#slctPosition,#slctDepartment,#supervisor,#chief').prop('selectedIndex',-1);
                            $("#select2-slctPosition-container,#select2-slctDepartment-container,#select2-supervisor-container,#select2-chief-container").html("");
                            $("#hidden").html();
                            Swal.fire('Success', response.msg, 'success');
                        }else{
                            Swal.fire('Failed', response.msg, 'error');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: function (jqXHR, exception){
                        ajaxError(jqXHR, exception)
                    }
                })
            });
        }else{
            $.ajax({
                url:"ajax/saveEmployee.php",
                type:"POST",
                data: frmData,
                success:function(data){
                    let response = $.parseJSON(data);
                    if(response.result){
                        $("#addEmployee")[0].reset();
                        $('#slctPosition,#slctDepartment,#supervisor,#chief').prop('selectedIndex',-1);
                        $("#select2-slctPosition-container,#select2-slctDepartment-container,#select2-supervisor-container,#select2-chief-container").html("");
                        $("#hidden").html();
                        Swal.fire('Success', response.msg, 'success');
                    }else{
                        Swal.fire('Failed', response.msg, 'error');
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function (jqXHR, exception){
                    ajaxError(jqXHR, exception)
                }
            })
        }
        

    });
    /*$(document).on("click",".removeFamRow",function(){
        $(".appendFamRow").last().remove();
    });*/
    $("#addFamilyMember").on("click",function(){
        let html = "\
        <div class='row appendFamRow' >\
            <div class='col-md-3 form-group'>\
                <label for='fullName'>Full Name:</label>\
                <input type='text' class='form-control' name='famFullName[]' id='fullName' placeholder='Ex: Juan Dela Cruz' Requ/>\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='birthday'>Birthday:</label>\
                <input type='date' class='form-control' name='famBirthday[]' id='birthday' placeholder='Ex: 01/01/1991' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='occupation'>Occupation:</label>\
                <input type='text' class='form-control' name='famOccupation[]' id='occupation' placeholder='Ex: Farmer' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='relation'>Relation:</label>\
                <input type='text' class='form-control' name='famRelation[]' id='relation' placeholder='Ex: Father' />\
            </div>\
            <input type='hidden' name='famID[]' value='New'/>\
        </div>\
        ";
        $("#appendFamilymember").append(html);
    });
    $("#addDependents").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-3 form-group'>\
                <label for='fullName'>Full Name:</label>\
                <input type='text' class='form-control' name='depFullName[]' id='fullName' placeholder='Ex: Juan Dela Cruz' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='gender'>Gender:</label>\
                <select class='form-control' name='depGender[]'>\
                    <option value='Male'>Male</option>\
                    <option value='Female'>Female</option>\
                </select>\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='occupation'>Birthday:</label>\
                <input type='date' class='form-control' name='depBirthday[]' id='birthday' placeholder='Ex: 01/01/1991' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='occupation'>Relationship:</label>\
                <input type='text' class='form-control' name='depRelation[]' id='relation' placeholder='Ex: Sister' />\
            </div>\
            <input type='hidden' name='depID[]' value='New'/>\
        </div>\
        ";
        $("#appendDependents").append(html);
    });
    $("#addBeneficiaries").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-4 form-group'>\
                <label for='fullName'>Full Name:</label>\
                <input type='text' class='form-control' name='benFullName[]' id='fullName' placeholder='Ex: Juan Dela Cruz' />\
            </div>\
            <div class='col-md-4 form-group'>\
                <label for='gender'>Gender:</label>\
                <input type='text' class='form-control' name='benGender[]' id='gender' placeholder='Ex: Male' />\
            </div>\
            <div class='col-md-4 form-group'>\
                <label for='birthday'>Birthday:</label>\
                <input type='date' class='form-control' name='benBirthday[]' id='birthday' placeholder='Ex: 01/01/1991' />\
            </div>\
            <input type='hidden' name='benID[]' value='New'/>\
        </div>\
        ";
        $("#appendBeneficiaries").append(html);
    });
    $("#addHobbies").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-6 form-group'>\
                <label for='category'>Category:</label>\
                <input type='text' class='form-control' name='hobCategory[]' id='category' placeholder='Ex: Basketball' />\
            </div>\
            <div class='col-md-6 form-group'>\
                <label for='description'>Description:</label>\
                <input type='text' class='form-control' name='hobDescription[]' id='description' placeholder='' />\
            </div>\
            <input type='hidden' name='hobID[]' value='New'/>\
        </div>\
        ";
        $("#appendHobbies").append(html);
    });
    $("#addSkills").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-6 form-group'>\
                <label for='category'>Category:</label>\
                <input type='text' class='form-control' name='skillCategory[]' id='category' placeholder='' />\
            </div>\
            <div class='col-md-6 form-group'>\
                <label for='description'>Description:</label>\
                <input type='text' class='form-control' name='skillDescription[]' id='description' placeholder='' />\
            </div>\
            <input type='hidden' name='skillID[]' value='New'/>\
        </div>\
        ";
        $("#appendSkills").append(html);
    });
    $("#addEducation").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-3 form-group'>\
                <label for='lvl'>Level:</label>\
                <input type='text' class='form-control' name='educLvl[]' id='level' placeholder='Ex: Tertiary' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='schoolName'>School Name:</label>\
                <input type='text' class='form-control' name='educSchoolName[]' id='schoolName' placeholder='Ex: Western Leyte College' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='degree'>Degree:</label>\
                <input type='text' class='form-control' name='educDegree[]' id='degree' placeholder='Ex: Bachelor of Science in Information Technology' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='schoolYear'>School year:</label>\
                <input type='text' class='form-control' name='educSchoolYear[]' id='schoolYear' placeholder='Ex: 2016-2017' />\
            </div>\
            <input type='hidden' name='educID[]' value='New'/>\
        </div>\
        ";
        $("#appendEducation").append(html);
    });
    $("#addExams").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-3 form-group'>\
                <label for='examType'>Exam Type:</label>\
                <input type='text' class='form-control' name='examType[]' id='examType' placeholder='' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='schoolName'>Description:</label>\
                <input type='text' class='form-control' name='examDescription[]' id='description' placeholder='' />\
            </div>\
            <div class='col-md-2 form-group'>\
                <label for='date'>Date:</label>\
                <input type='date' class='form-control' name='examDate[]' id='date' placeholder='' />\
            </div>\
            <div class='col-md-2 form-group'>\
                <label for='ratings'>Ratings:</label>\
                <input type='text' class='form-control' name='examRatings[]' id='ratings' placeholder='' />\
            </div>\
            <div class='col-md-2 form-group'>\
                <label for='venue'>Venue:</label>\
                <input type='text' class='form-control' name='examVenue[]' id='venue' placeholder='' />\
            </div>\
            <input type='hidden' name='examID[]' value='New'/>\
        </div>\
        ";
        $("#appendExams").append(html);
    });
    $("#addAwards").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-3 form-group'>\
                <label for='awardType'>Awards Type:</label>\
                <input type='text' class='form-control' name='awardType[]' id='awardType' placeholder='' />\
            </div>\
            <div class='col-md-4 form-group'>\
                <label for='description'>Description:</label>\
                <input type='text' class='form-control' name='awardDescription[]' id='description' placeholder='' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='date'>Date:</label>\
                <input type='date' class='form-control' name='awardDate[]' id='date' placeholder=''/>\
            </div>\
            <div class='col-md-2 form-group'>\
                <input type='file' class='' name='awardAttach[]' id='img' multiple='multiple' accept='image/png, image/gif, image/jpeg, application/pdf'  hidden>\
                <label for='img' class='btn btn-primary rounded-pill p-2'><i class='fa fa-paperclip'></i></label>\
                <span class='attachments'></span>\
            </div>\
            <input type='hidden' name='awardID[]' value='New'/>\
        </div>\
        ";
        $("#appendAwards").append(html);
    });
    $("#addJob").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-3 form-group'>\
                <label for='employer'>Employer:</label>\
                <input type='text' class='form-control' name='jobEmployer[]' id='employer' placeholder='' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='dateFrom'>Date From:</label>\
                <input type='date' class='form-control' name='jobDateFrom[]' id='dateFrom' placeholder='' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='dateTo'>Date To:</label>\
                <input type='date' class='form-control' name='jobDateTo[]' id='dateTo' placeholder=''/>\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='position'>Position:</label>\
                <input type='text' class='form-control' name='jobPosition[]' id='position' placeholder=''/>\
            </div>\
            <input type='hidden' name='jobID[]' value='New'/>\
        </div>\
        ";
        $("#appendJob").append(html);
    });
    $("#addTrainings").on("click",function(){
        let html = "\
        <div class='row'>\
            <div class='col-md-3 form-group'>\
                <label for='description'>Description:</label>\
                <input type='text' class='form-control' name='trainDescription[]' id='description' placeholder='' />\
            </div>\
            <div class='col-md-2 form-group'>\
                <label for='host'>Host:</label>\
                <input type='text' class='form-control' name='trainHost[]' id='host' placeholder='' />\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='date'>Date:</label>\
                <input type='date' class='form-control' name='trainDate[]' id='date' placeholder=''/>\
            </div>\
            <div class='col-md-3 form-group'>\
                <label for='venue'>Venue:</label>\
                <input type='text' class='form-control' name='trainVenue[]' id='venue' placeholder=''/>\
            </div>\
            <div class='col-md-1 form-group'>\
                <input type='file' class='' name='trainAttach[]' id='img' multiple='multiple' accept='image/png, image/gif, image/jpeg, application/pdf'  hidden>\
                <label for='img' class='btn btn-primary rounded-pill p-2'><i class='fa fa-paperclip'></i></label>\
                <span class='attachments'></span>\
            </div>\
            <input type='hidden' name='trainID[]' value='New'/>\
        </div>\
        ";
        $("#appendTrainings").append(html);
    });

   $(".searchChief").on("change",function(){
        let position = $("#slctPosition").val();
        let department = $("#slctDepartment").val();
        
        if(position != "" && department != ""){
            $.ajax({
                url:"ajax/searchChief.php",
                type:"POST",
                data:{ position : position, department : department},
                success:function(data){
                    let response = $.parseJSON(data);
                    if(response.result){
                        if(response.rank < 2){

                            $("#hidden").html("");
                            let options = "";

                            for(let $i=0; $i<response.supervisor.length; $i++){
                                options +="\
                                    <option value='" + response.valueSup[$i] + "'>"+ response.supervisor[$i] +"</option>\
                                ";
                            }
                            $("#supervisor").prop("disabled",false);
                            $("#supervisor").html(options);
                            $("#hidden").html("\
                                <input type='hidden' name='chief' value='"+ response.valueChief + "'>\
                                <input type='hidden' name='rank' value='"+ response.rank + "'>\
                            ");
                            $("#chief").html("<option value='"+ response.valueChief +"' selected='selected'>"+ response.chief +"</option>");
                        }else{
                            $("#supervisor,#chief").prop("disabled","disabled");
                            $("#hidden").html("\
                                <input type='hidden' name='supervisor' value='"+ response.valueSup + "'>\
                                <input type='hidden' name='chief' value='"+ response.valueChief + "'>\
                                <input type='hidden' name='rank' value='"+ response.rank + "'>\
                            ");
                            $("#supervisor").html("<option selected='selected'>"+ response.supervisor +"</option>");
                            $("#chief").html("<option selected='selected'>"+ response.chief +"</option>");
                        }
                    }else{
                        $("#select2-supervisor-container,#select2-chief-container").html("");
                        $("#supervisor,#chief").prop("disabled","disabled");
                        $("#hidden").html("");
                        $("#supervisor").html("");
                        $("#chief").html("");
                    }
                    
                }
            })
        }
    })

    $("#signature").on("click",function(){
        $("#canvasContainer").show();
    });

    $("#signatureClose").on("click",function(){
        $("#canvasContainer").hide();
    });
    $(document).on("click",".addSignatory",function(){
        let id = $(this).data("id");
        $("#leaveID").val(id);
        $("#canvasContainer").show();
        
    });

    $("#signatureCloseSigna").on("click",function(){
        $("#canvasContainer").hide();
    });

    $("#signatoryForm").on("submit",function(e){
        e.preventDefault();
        let frmData = new FormData($(this)[0]);

        $.ajax({
            url:"ajax/saveSignatory.php",
            type:"POST",
            data: frmData,
            success:function(data){
                let response = $.parseJSON(data)
                if(response.result){
                    $("#canvasContainer").hide();
                    Swal.fire('Success', response.msg, 'success');
                }else{
                    Swal.fire('Failed', response.msg, 'error');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })
    })

    $("#numDays").on("keypress",function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if(charCode == 46)
            return $(this).val().includes(".") ? false : true;

        if($(this).val().includes(".")){
            let str = $(this).val().split(".");
            if(str[1].length == 1)
                return false;
            if(isNaN(String.fromCharCode(e.which)))
                return false;
            else
                return parseInt(String.fromCharCode(e.which)) % 5 == 0 ? true : false;
        }
        if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
            return false;

        return true;
    });

    $("#leaveForm").on("submit",function(e){
        e.preventDefault();
        if($("#select2-leaveType-container").html() == "Please Select Leave Type"){
            Swal.fire('Invalid', "Please Select Leave Type!", 'warning');
        }else if($("#signaturePic").val() == ""){
            Swal.fire('Invalid', "Please Add Your Signature!", 'warning');
        }else{
            let frmData = new FormData($(this)[0]);
            $.ajax({
                url:"ajax/saveLeaveReq.php",
                type:"POST",
                data: frmData,
                success:function(data){
                    let response = $.parseJSON(data)
                    if(response.result){
                        $("#select2-leaveType-container").html("Please Select Leave Type");
                        $("#leaveForm")[0].reset();

                        Swal.fire('Success', response.msg, 'success');
                    }else{
                        Swal.fire('Failed', response.msg, 'error');
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function (jqXHR, exception){
                    ajaxError(jqXHR, exception)
                }
            })
        }
    })

    $(document).on("click",".viewEmpLeave",function(){
        let id = $(this).data("id");
        window.open('viewEmployeeLeave.php?id='+id, 'name'); 
    });

    $("#medhapForm").on("submit",function(e){
        e.preventDefault();
        let frmData = new FormData($(this)[0]);
        $.ajax({
            url:"ajax/saveMedhapReq.php",
            type:"POST",
            data: frmData,
            success:function(data){
                let response = $.parseJSON(data)
                if(response.result){
                    $("#medhapForm")[0].reset();
                    $("#forHospital").html("");
                    $("#forDependents").html("");
                    Swal.fire('Success', response.msg, 'success');
                }else{
                    Swal.fire('Failed', response.msg, 'error');
                }
            },
            cache: false,
            contentType: false,
            processData: false,
            error: function (jqXHR, exception){
                ajaxError(jqXHR, exception)
            }
        })
    });

    $("#apprMedBtn").on("click",function(){
        Swal.fire({
            title: '<strong>Approve MedHAP Request?</strong>',
            type: 'warning',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((data) => {
            
            if(data.value){
                let medHapID = $("#medHapID").val();
                $.ajax({
                    url:"ajax/saveApprMedHap.php",
                    type:"POST",
                    data: {medHapID : medHapID},
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
                    error: function (jqXHR, exception){
                        ajaxError(jqXHR, exception)
                    }
                })
            }
        });
    })

    $("#medhapType").on("change",function(){
        let medhapType =  $(this).val();

        if(medhapType == 1){
            $("#forHospital").html("\
                <div class='form-group'>\
                    <label for='forRelation'>For:</label>\
                    <select class='form-control' name='for' id='forRelation'>\
                        <option value='self'>Self</option>\
                        <option value='dependents'>Dependents</option>\
                    </select>\
                </div>\
            ")
        }else
            $("#forHospital").html("");
    })
    
    $(document).on("change","#forRelation",function(){
        let relation = $(this).val();

        if(relation == "self"){
            $("#forDependents").html("");
        }else{
            $.ajax({
                url:"ajax/searchDependents.php",
                success:function(data){
                    $("#forDependents").html("\
                        <div class='form-group'>\
                            <label for='forDependents'>Dependents:</label>\
                            <select class='form-control' name='dependents' id='forDependents'>"+ data +"</select>\
                        </div>\
                    ")
                }
            })
        }
    });

    $(document).on("click","#reRequest",function(){
        let frmData = new FormData();
        let thisID = $(this).data("id")
        frmData.append("id",thisID);
        Swal.fire({
            title: '<strong>Re-request</strong>',
            text: 'Add More Amount',
            type: 'warning',
            input:'text',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((data) => {
            if (typeof data.value !== 'undefined'){
            
                if(data.value){
                    frmData.append("amount",data.value);
                    $.ajax({
                        url:"ajax/reRequest.php",
                        type:"POST",
                        data: frmData,
                        success:function(data){
                            let response = $.parseJSON(data);
                            if(response.result){
                                if(response.result == "Pending"){
                                    Swal.fire({
                                        title: 'Amount Exceeded',
                                        type: 'error',
                                        html: "<h6>Available amount to request is ₱ " + response.avail + "</h6>",
                                        showConfirmButton: true,
                                        showCancelButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    });
                                }else{
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
                                }
                            }else{
                                Swal.fire('Failed', response.msg, 'error');
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        error: function (jqXHR, exception){
                            ajaxError(jqXHR, exception)
                        }
                    })
                }else{
                    Swal.fire('Failed', "Invalid Amount.", 'error');
                }

            }
        });
    });

    $(document).on("click",".approveReRequest",function(){
        let thisID = $(this).data("id");
        let fullName = $(this).data("fullname");
        let newAmount = $(this).data("amount");
        let buttons = "<div class='row justify-content-center'>\
            <button class='btn btn-info mx-1' id='apprBtnReReq' data-id='" + thisID +"'>Approve&nbsp;</button>\
            <button class='btn btn-danger mx-1' id='disBtnReReq' data-id='" + thisID +"'>Disapprove</button>\
            <button class='btn btn-default mx-1' id='cancelReReq'>Cancel</button>\
        </div>";


        Swal.fire({
            title: 'Approve',
            html: '<h6>Approved The Application For MED-HAP Of '+ fullName + " with the amount of " + newAmount + "</h6><br>" + buttons,
            type: 'warning',
            showConfirmButton:false,
            allowOutsideClick: false,
        });
    })

    $(document).on("click","#cancelReReq",function(){
        Swal.close();
    })

    $(document).on("click","#apprBtnReReq",function(){
        let thisID = $(this).data("id");
        let frmData = new FormData();
        frmData.append("id",thisID);

        $.ajax({
            url:"ajax/approveReReq.php",
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
    })

    $(document).on("click","#disBtnReReq",function(){
        let thisID = $(this).data("id");
        let frmData = new FormData();
        frmData.append("id",thisID);
        Swal.close();

        Swal.fire({
            title: '<strong>Reason For Dissaproval</strong>',
            type: 'warning',
            input:'text',
            showCancelButton: true,
            confirmButtonText: "Confirm",
            focusConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((data) => {
            
            if(data.value){
                frmData.append("reason",data.value);
                $.ajax({
                    url:"ajax/disApproveReReq.php",
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
                    processData: false,
                    error: function (jqXHR, exception){
                        ajaxError(jqXHR, exception)
                    }
                })
            }
        });
    })

    $("#reportType").on("change",function(){
        let reportType = $(this).val();
        $.ajax({
            url:"ajax/loadRepCateg.php",
            type:"POST",
            data:{ "reportType" : reportType},
            success:function(data){
                $("#reportCateg").html("<option value='All'>All</option>" + data);
                $("#reportCateg").prop("disabled",false);
            },
            error: function (jqXHR, exception){
                ajaxError(jqXHR, exception)
            }
        })
    })

    $("#generateRep").on("click",function(){
        let msgStr = "";
        let startDate = $("#repStartD").val().split("-");
        let endDate = $("#repEndD").val().split("-");
        let reportType = $("#reportType").val();
        let repTypeF = "";
        let catName = $("#reportCateg option:selected").text();
        let catID = $("#reportCateg").val();
        let frmData = new FormData();

        startDate = isValidDate(startDate[0],startDate[1],startDate[2]) ? $("#repStartD").val() : false;
        endDate = isValidDate(endDate[0],endDate[1],endDate[2]) ? $("#repEndD").val() : false;

        if(!startDate){
            Swal.fire('Invalid', "Invalid Start Date.", 'error');
        }else if(!endDate){
            Swal.fire('Invalid', "Invalid End Date.", 'error');
        }else{
            if(reportType == "leave")
                repTypeF = catName + " Leave";
            else if(reportType == "medhap")
                repTypeF = catName + " MED-HAP";

            msgStr = "<p style='font-weight:600;'>Generate "+ repTypeF +" Report From "+ startDate + " To " + endDate +"<p>";
            Swal.fire({
                title: '<strong>Generate Report.</strong>',
                type: 'warning',
                html:msgStr,
                showCancelButton: true,
                confirmButtonText: "Confirm",
                focusConfirm: true,
                width:"450px",
                allowOutsideClick: () => !Swal.isLoading()
            }).then((data) => {
                frmData.append("reportType",reportType);
                frmData.append("catID",catID);
                frmData.append("startDate",startDate);
                frmData.append("endDate",endDate);

                //window.open('ajax/generateRep.php','_blank' );
                $.ajax({
                    url:"ajax/generateRep.php",
                    type: "POST",
                    data: frmData,
                    dataType:'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: function (jqXHR, exception){
                        ajaxError(jqXHR, exception)
                    }
                }).done(function(data){
                    var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download","file.xls");
                    $a[0].click();
                    $a.remove();
                })
                

            });
        }
    });

    $(document).on("click",".liquiBtn",function(){
        $("#liquiForm").data("id",$(this).data("id"));
        $("#liquidateModal").modal("show")
    })

    $(document).on('change', '.file-input', function() {

        let frmData = new FormData();
        let filesCount = $(this)[0].files.length;
        let textbox = $(this).prev();
        
        for(let i=0; i<filesCount; i++){
            frmData.append("files[]",$(this)[0].files[i])
        }

        if (filesCount === 1) {
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }

        $.ajax({
            url:"ajax/saveTempImg.php",
            data:frmData,
            type:"POST",
            data: frmData,
            success:function(data){
                let response = $.parseJSON(data);
                if(response.result){
                    for(let i=0; i<response.paths.length; i++){
                        $("#filesSelected").append("\
                            <div class='uploadLiqui'>\
                                <a target='_blank' href='"+ response.paths[i] +"'>\
                                    <img src='"+ response.paths[i] +"'>\
                                </a>\
                            </div>"
                        );
                        
                        tempImgPaths.push(response.paths[i]);
                    }
                }else{
                    Swal.fire('Failed', response.msg, 'error');
                }
            },
            cache: false,
            contentType: false,
            processData: false,
            error: function (jqXHR, exception){
                ajaxError(jqXHR, exception)
            }
        })
    });

    $('#liquidateModal').on('hide.bs.modal', function (e) {
        $("#filesSelected").html("");
        $.ajax({
            url:"ajax/cancelImgLiqui.php",
            type:"POST",
            data: { paths : tempImgPaths },
            success:function(data){

            }
        })
    })
    $("#liquiForm").on("submit",function(e){
        e.preventDefault();
        let frmData = new FormData();
        let liquiAmount = $("#liquiAmount").val();
        let liquiID = $(this).data("id")

        if(liquiAmount == "" || liquiAmount == 0){
            Swal.fire('Failed', "Invalid Amount", 'error');
        }else if($('#liquiFiles').get(0).files.length === 0){
            Swal.fire('Failed', "Please Select Files.", 'error');
        }else{
            frmData.append("id", liquiID);
            frmData.append("amount",liquiAmount)
            for (let i = 0; i < tempImgPaths.length; i++) {
                frmData.append('slctFiles[]', tempImgPaths[i]);
            }
            $.ajax({
                url:"ajax/saveLiquidate.php",
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
                processData: false,
                error: function (jqXHR, exception){
                    ajaxError(jqXHR, exception)
                }
            })
        }
    })

    $("#ifActing").on("change",function(){
        let check = $(this).is(":checked") ? 1 : 0;
        let employeeID = $(this).data('id');
        $.ajax({
            url:"ajax/acting.php",
            type:"POST",
            data: {check : check, employeeID : employeeID},
            success:function(data){
                let response = $.parseJSON(data)

                if(response.result){
                    Swal.fire({
                        title: 'Success',
                        type: 'success',
                        text: response.msg,
                        timer: 3000,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    })
                    if(check)
                        $(".acting").show();
                    else
                        $(".acting").hide();
                }else{

                    Swal.fire('Failed', response.msg, 'error');

                }
                
                
                
            },
            error: function (jqXHR, exception){
                ajaxError(jqXHR, exception)
            }
        })
    });

    $(".accor").on('click',function(){
        let targetID = $(this).data("target");
        $(".accor").parents('.card-header').removeClass('bg-gradient-primary');
        $(".accor").removeClass('text-white');
        if(!$(targetID).hasClass('show')){
            $(this).parents('.card-header').addClass('bg-gradient-primary');
            $(this).addClass('text-white');
        }
    });

    $(document).on('click','.viewLeaveImage',function(e){
        let leaveID = $(this).data('id');

        $.ajax({
            url:"ajax/loadImages.php",
            type:"POST",
            data: {leaveID : leaveID},
            success:function(data){
                let response = $.parseJSON(data)

                if(response.result){
                    let indicators = '';
                    let inner = '';
                    for(let i = 0; i<response.count; i++){
                        if(i == 0){
                            indicators += '<li data-target="#carouselExampleIndicators" data-slide-to="'+ i +'" class="active"></li>';
                            inner += '<div class="carousel-item active">\
                                        <img class="d-block w-100" src="./leaveImages/'+ response.paths[i] +'" alt="First slide">\
                                    </div>';
                        }else{
                            indicators += '<li data-target="#carouselExampleIndicators" data-slide-to="'+ i +'"></li>';
                            inner += '<div class="carousel-item">\
                                        <img class="d-block w-100" src="./leaveImages/'+ response.paths[i] +'" alt="Second slide">\
                                    </div>';
                        }
                    
                    }

                    let html='\
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">\
                            <ol class="carousel-indicators">\
                                '+ indicators +'\
                            </ol>\
                            <div class="carousel-inner">\
                                '+ inner +'\
                            </div>\
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">\
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>\
                                <span class="sr-only">Previous</span>\
                            </a>\
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">\
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>\
                                <span class="sr-only">Next</span>\
                            </a>\
                        </div>\
                    ';
                   
                    $("#leaveImagesModal .modal-content").html(html);
                    $("#leaveImagesModal").modal("toggle");
                }else{

                    Swal.fire('Failed', response.msg, 'error');

                }
                
                
                
            },
            error: function (jqXHR, exception){
                ajaxError(jqXHR, exception)
            }
        })
        
    });


    $("#leaveFileSlct").on("change",function(){
        let files = $(this)[0].files;
        if(files.length > 1){
            $("#numSelected").html( files.length + " Files Selected");
        }else if(files.length == 1){
            $("#numSelected").html("1 File Selected");
        }else{
            $("#numSelected").html("Select a File");
        }
    })
})