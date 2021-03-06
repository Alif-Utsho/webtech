<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Coda+Caption:wght@800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/38b09dcc3b.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../styles/login.css">

    <?php
        session_start();
        if(isset($_SESSION['customerEmail'])) header('Location: ../views/customerDashboard.php');
        if(isset($_SESSION['operatorEmail'])) header('Location: ../views/operatorDashboard.php');
        if(isset($_SESSION['adminEmail'])) header('Location: ../views/adminDashboard.php');
    ?>

</head>
<body class="container" style="height: 100%;">
    <div class="mx-auto col-md-4 col-12">
        
        <h1 class="text-center mb-4 alert-secondary alert" style="font-family: 'Coda Caption';">
            <i class="fas fa-bus"></i>
            eTickets
        </h1>
        <h4 class="text-center mb-3">Sign in here <i class="fas fa-sign-in-alt"></i> </h4>
        
        
        <form action="../controllers/loginProcess.php" method="POST">
            <div class="form-floating">
                <input type="text" name="email" class="form-control bottomplain <?php if(strlen($email_err)>0) echo 'is-invalid';?>" id="email" placeholder="E-mail address" value="<?php if(isset($email)) echo $email; ?>">
                <label for="email"> <i class="fas fa-envelope"></i> &nbsp; E-mail address</label>
                <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                    <i class="fas fa-exclamation-triangle"></i> &nbsp;
                    <?php if(isset($email_err)) echo $email_err; ?>
                </div>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control <?php if(strlen($pass_err)>0) echo 'is-invalid'; ?>" id="password" placeholder="Password">
                <label for="password"> <i class="fas fa-key"></i> &nbsp; Password</label>
                <div id="validationServer0Feedback" class="invalid-feedback mb-2">
                    <i class="fas fa-exclamation-triangle"></i> &nbsp;
                    <?php if(isset($pass_err)) echo $pass_err; ?>
                </div>
            </div>
            
            <div class="checkbox my-3 d-flex">
                <div class="col-md-6">
                    <label>
                        <input type="checkbox" value="remember-me" checked disabled> Remember me
                    </label>
                </div>
                <div class="col-md-6">
                    
                    <a class="ms-5 ms-md-0 float-end" style="text-decoration: none;" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Forgot Password?
                    </a>

                    <!-- forgot pass modal  -->
                
                    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Forgot Password</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body text-center">
                            <div>
                                Your Password has been Hashed, So we also not able to recover. 
                                <h3>Please Try to Remember Your Password</h3>
                            </div>
                            
                        </div>
                    </div>

                    <!--  -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        Your Password has been Hashed, So we also not able to recover. 
                                        <h4>Please Try to Remember Your Password</h4>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->

                </div>
            </div>

            <div class="">
                <input type="submit" class="btn btn-lg btn-primary col-12" value="Sign in">
            </div>
        </form>
        <div class="my-3 d-flex mb-md-5">
                <div class="col-md-6">
                    Not Registered?
                    <a class="" href="http://localhost/eTickets/views/registration.php" style="text-decoration: none;">
                    Register Here
                    </a>
                </div>
            </div>
    </div>


    
</body>
</html>