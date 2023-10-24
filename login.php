<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup Form</title>
    
    <!-- Bootstrap CSS Link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div id="login" class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Login Card -->
                <div class="card mt-5">
                    <div class="card-header">
                        Login <button class="float-end btn btn-secondary text-white" id="showRegister">Register <i class="bi bi-arrow-right-circle-fill"></i></button>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div id="login-result"></div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend1"><i class="bi bi-envelope-at-fill"></i></span>
                                    <input type="text" class="form-control" name="mail" id="mail" placeholder="Enter Email" aria-describedby="inputGroupPrepend1" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend2"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Enter Passcode" aria-describedby="inputGroupPrepend2" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="register" class="container" style="display: none;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Register Card -->
                <div class="card mt-5">
                    <div class="card-header">
                        Signup <button class="float-end btn btn-secondary text-white" id="showLogin">Login <i class="bi bi-arrow-right-circle-fill"></i></button>
                    </div>
                    <div class="card-body">
                        <form id="registrationForm">
                            <div id="registration-result"></div>
                            <div class="mb-3">
                                 <div class="input-group">
                                  <span class="input-group-text" id="input1"><i class="bi bi-envelope-at-fill"></i></span>
                                  <input type="text" class="form-control" name="mail" id="rmail" placeholder="Enter Email" aria-describedby="input1" required>
                                </div>
                                
                            </div>
                            <div class="mb-3">
                                 <div class="input-group">
                                  <span class="input-group-text" id="input2"><i class="bi bi-person-circle"></i></span>
                                  <input type="text" class="form-control" name="uname" id="runame" placeholder="Enter Name" aria-describedby="input2" required>
                                </div>
                                
                            </div>
                            <div class="mb-3">
                                 <div class = "input-group">
                                  <span class="input-group-text" id="input3"><i class="bi bi-person-lock"></i></span>
                                  <input type="password" class="form-control" name="pass" id="rpass" placeholder="Enter password" aria-describedby="input3" required>
                                </div>
                            </div>
                             <div class="mb-3">
                                 <div class="input-group">
                                  <span class="input-group-text" id="input4"><i class="bi bi-person-fill-lock"></i></span>
                                  <input type="password" class="form-control" name="cpass" id="rcpass" placeholder="Confirm password" aria-describedby="input4" required>
                                </div>
                                
                            </div>
                            <button type="submit" name="register" class="btn btn-primary w-100">REGISTER</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Link (for Bootstrap functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById("showRegister").addEventListener("click", function() {
            document.getElementById("login").style.display = "none";
            document.getElementById("register").style.display = "block";
        });

        document.getElementById("showLogin").addEventListener("click", function() {
            document.getElementById("register").style.display = "none";
            document.getElementById("login").style.display = "block";
        });
    </script>

    <script>
        $(document).ready(function() {
    
            $("#registrationForm").on("submit", function(event) {
                event.preventDefault(); 
                var mail = $("#rmail").val();
                var uname = $("#runame").val();
                var pass = $("#rpass").val();
                var cpass = $("#rcpass").val();

            
                $.ajax({
                    type: "POST",
                    url: "api/registerapi.php",
                    data: {
                        mail: mail,
                        uname: uname,
                        pass: pass,
                        cpass: cpass
                    },
                    success: function(response) {
                    
                        if (response.message === "Registration successful.") {
                            
                            $("#registration-result").html('<div class="alert alert-success">' + response.message + '</div>');

                            $("#rmail, #runame, #rpass, #rcpass").val("");
                        } else {
                    
                            $("#registration-result").html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    }
                });
            });
        });
    </script>

   <script>
    $(document).ready(function() {
        $("#loginForm").on("submit", function(event) {
            event.preventDefault(); 

            var mail = $("#mail").val();
            var pass = $("#pass").val();



            $.ajax({
                type: "POST",
                url: "api/loginapi.php", 
                data: {
                    mail: mail,
                    pass: pass
                },
                success: function(response) {
                    if (response.loggedIn) {
                        $("#login-result").html('<div class="alert alert-success" role="alert">' + response.message + '</div>');
                        
                        window.location.href = "index.php";
                    } else {
                        $("#login-result").html('<div class="alert alert-danger" role="alert">' + response.message + '</div>');
                    }
                }
            });
        });
    });
</script>


</body>
</html>
