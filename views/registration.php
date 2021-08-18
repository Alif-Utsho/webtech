<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Coda+Caption:wght@800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/38b09dcc3b.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../styles/registration.css">

    <?php
        session_start();
        if(isset($_SESSION['customerEmail'])) header('Location: ../views/customerDashboard.php');
        if(isset($_SESSION['operatorEmail'])) header('Location: ../views/operatorDashboard.php');
        if(isset($_SESSION['adminEmail'])) header('Location: ../views/adminDashboard.php');
    ?>

</head>
<body class="container" style="height: 100%;">
    <div class="mx-auto col-md-6 col-12">
        
        <h1 class="text-center mb-4 alert-secondary alert" style="font-family: 'Coda Caption';">
            <i class="fas fa-bus"></i>
            eTickets
        </h1>
        <h4 class="text-center mb-3">Register here <i class="fas fa-sign-in-alt"></i> </h4>
        
        
        <form action="../controllers/registration.php" method="POST">
            <div class="form-floating">
                <input type="text" name="name" class="form-control my-1 <?php if(strlen($name_err)>0) echo 'is-invalid';?>" id="name" placeholder="E-mail address" value="<?php if(isset($name)) echo $name; ?>">
                <label for="name"> <i class="fas fa-user text-success"></i> &nbsp; Name</label>
                <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                    <i class="fas fa-exclamation-triangle"></i> &nbsp;
                    <?php if(isset($name_err)) echo $name_err; ?>
                </div>
            </div>
            <div class="form-floating">
                <input type="text" name="phone" class="form-control my-1 <?php if(strlen($phone_err)>0) echo 'is-invalid';?>" id="phone" placeholder="E-mail address" value="<?php if(isset($phone)) echo $phone; ?>">
                <label for="phone"> <i class="fas fa-phone text-success"></i> &nbsp; Phone</label>
                <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                    <i class="fas fa-exclamation-triangle"></i> &nbsp;
                    <?php if(isset($phone_err)) echo $phone_err; ?>
                </div>
            </div>
            <div class="form-floating">
                <div class="btn-group col-12 my-2" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="gender" id="btnradio1" value="male" autocomplete="off" checked>
                    <label class="btn btn-outline-success" for="btnradio1">Male</label>

                    <input type="radio" class="btn-check" name="gender" id="btnradio3" value="female" autocomplete="off">
                    <label class="btn btn-outline-success" for="btnradio3">Female</label>
                </div>
            </div>
            <div class="form-floating">
                <input type="text" name="email" class="form-control my-1 <?php if(strlen($email_err)>0) echo 'is-invalid';?>" id="email" placeholder="E-mail address" value="<?php if(isset($email)) echo $email; ?>">
                <label for="email"> <i class="fas fa-envelope text-success"></i> &nbsp; E-mail</label>
                <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                    <i class="fas fa-exclamation-triangle"></i> &nbsp;
                    <?php if(isset($email_err)) echo $email_err; ?>
                </div>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control my-1 <?php if(strlen($pass_err)>0) echo 'is-invalid'; ?>" id="password" placeholder="Password">
                <label for="password"> <i class="fas fa-key text-success"></i> &nbsp; Password</label>
                <div id="validationServer0Feedback" class="invalid-feedback mb-2">
                    <i class="fas fa-exclamation-triangle"></i> &nbsp;
                    <?php if(isset($pass_err)) echo $pass_err; ?>
                </div>
            </div>
            <div class="form-floating">
                <input type="password" name="repass" class="form-control my-1 <?php if(strlen($repass_err)>0) echo 'is-invalid'; ?>" id="password" placeholder="Password">
                <label for="password"> <i class="fas fa-key text-success"></i> &nbsp; Re-type Password</label>
                <div id="validationServer0Feedback" class="invalid-feedback mb-2">
                    <i class="fas fa-exclamation-triangle"></i> &nbsp;
                    <?php if(isset($repass_err)) echo $repass_err; ?>
                </div>
            </div>
            
            <div class="my-3 d-flex">
                <div class="col-md-6">
                    Already Registered?
                    <a class="" href="http://localhost/eTickets/views/login.php" style="text-decoration: none;">
                    Login Here
                    </a>
                </div>
            </div>

            <div class="mb-md-5">
                <input type="submit" class="btn btn-lg btn-primary col-12" value="Register">
            </div>
        </form>
    </div>
</body>
</html>