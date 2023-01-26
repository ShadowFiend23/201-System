<?php 



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>201</title>
    <link rel="icon" href="img/loader.ico">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!--<link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">-->

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/paper-dashboard.css" rel="stylesheet">
    <link href="css/themify-icons.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #17a2b8;
        height: 100vh;
    }
    #login .container #login-row #login-column #login-box {
        margin-top: 50px;
        max-width: 600px;
        height: 320px;
        border: 1px solid #9C9C9C;
        background-color: #EAEAEA;
        }
    #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
    }
    #login .container #login-row #login-column #login-box #login-form #register-link {
        margin-top: -85px;
    }
    #changePass{
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        width:500px;
        height: 430px;
        background-color: #17a2b8;
        z-index:1000;
        display:none;
    }
    h4,h6{
        color:white;
        text-align:center;
    }
    h6{
        font-size: 11px;
    }
    .form-container{
        margin:15px;
        border: 2px solid white;
        padding:30px;
    }
   .form-container label{
       color:white;
   }
   #newPassSpin{
       display:none;
   }
    </style>
</head>

<body class="bg-gradient-primary">

<div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md float-right" value="submit">
                            </div>
                            <!--<div id="register-link" class="text-right">
                                <a href="#" class="text-info">Register here</a>
                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="" id="changePass">
        <div class="container-fluid">
            <div class="form-container">
                <form class="form-group" id="newPassForm">
                    <h4 class="text-align-center">New Password</h4>
                    <h6 class="text-align-center">Need To Register New Password</h6>
                    <hr>
                    <div class="form-group">
                        <label for="newPass">New Password</label>
                        <input type="password" class="form-control" name="newPass" id="newPass">
                    </div>
                    <div class="form-group">
                        <label for="reType">Re-type Password</label>
                        <input type="password" class="form-control" name="reType" id="reType">
                        <span id='message'></span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-secondary" type="button" id="reTypeCancel">Cancel</button>
                        <button class="btn btn-primary float-right" type="submit" id="submitNewPass" disabled>Submit &nbsp;<div class="spinner-border spinner-border-sm text-light" id="newPassSpin" role="status"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/sweetalert2.js"></script>

    <script type="text/javascript">
        
    $(function(){

        let userID;
        $("#login-form").on("submit",function(e){
            e.preventDefault();
            let frmData = new FormData($(this)[0]);
            $.ajax({
                    url:"ajax/login.php",
                    type:"POST",
                    data: frmData,
                    success:function(data){
                       let response = $.parseJSON(data)

                       if(response["result"]){
                           if(response["changePass"]){
                            userID = response["userID"];
                            let timerInterval
                            Swal.fire({
                                title: 'Success',
                                html: '<b>Default Password has been found. Need to Change Password.<b>',
                                timer: 5000,
                                type:"success",
                                timerProgressBar: true,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                                }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    $("#changePass").show();
                                }
                            })
                           }else{
                                let type = response["type"];
                                if(type == "admin"){
                                    Swal.fire({
                                        title: 'Success',
                                        html: 'Welcome Administrator. Redirecting to Page.',
                                        timer: 3000,
                                        type:"success",
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    }).then(function() {
                                        window.location.href = "http://201.occcicoop.com/";
                                    });
                                   
                                }else{
                                    Swal.fire({
                                        title: 'Success',
                                        html: 'Welcome. Redirecting to Page.',
                                        timer: 3000,
                                        type:"success",
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    }).then(function() {
                                        window.location.href = "http://201.occcicoop.com/employee.php";
                                    });
                                    
                                }
                           } 
                       }else{
                            Swal.fire({
                                title: 'Error',
                                html: response['msg'],
                                type:"error",
                                timerProgressBar: true,
                                showConfirmButton: true,
                                allowOutsideClick: false
                            })
                       }

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
        })


        $(document).on("submit","#newPassForm",function(e){

            e.preventDefault();
            $("#newPassSpin").css("display", "inline-block");

            let frmData = new FormData($(this)[0]);
            frmData.append("userID",userID);
            $.ajax({
                    url:"ajax/saveNewPass.php",
                    type:"POST",
                    data: frmData,
                    dataType: 'json',
                    success:function(data){
                       let response = data

                       if(response["result"]){
                            Swal.fire({
                                title: 'Success',
                                html: 'Welcome. Redirecting to Page.',
                                timer: 3000,
                                type:"success",
                                timerProgressBar: true,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            }).then(function() {
                                if(response["permission"] == "admin"){
                                    window.location.href = response["link"];
                                }else{
                                    window.location.href = response["link"];
                                }
                            });
                            
                       }else{
                        Swal.fire(
                            'Failed',
                            response["msg"],
                            'error'
                        )
                       }
                        
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
        })
        $(document).ready(function () {
            $("#newPass, #reType").keyup(checkPasswordMatch);
        });

        function checkPasswordMatch() {
            var password = $("#newPass").val();
            var confirmPassword = $("#reType").val();

            if (password !== confirmPassword){ 
                $('#message').html('Not Match').css('color', 'red');
                $("#submitNewPass").prop("disabled", "true");
            }else if(password === "" && confirmPassword === ""){
                $('#message').html('Please Input Passwords').css('color', 'red');
                $("#submitNewPass").prop("disabled", "true");
            }else{
                $('#message').html('Matched').css('color', 'green');
                $("#submitNewPass").removeAttr("disabled");
            }
        }

        $(document).on("click","#reTypeCancel",function(){
            $('#newPassForm').trigger("reset");
            $("#changePass").hide();
        })

        
    })
    
    </script>
</body>

</html>