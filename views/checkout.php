<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Coda+Caption:wght@800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/38b09dcc3b.js" crossorigin="anonymous"></script>


    <style>
        body {
            background-color: #f5f5f5;
        }

    </style>

    <title>Checkout</title>
</head>
<body>
    <?php

        session_start();
        if(!isset($_SESSION['customerEmail'])) header('Location: ./login.php');

        $coach = $date = $seats = $fare = $operatorname = $time = '';
        $seatcount = 0;
        if(isset($_POST['book'])){
            $coach = $_POST['coach'];
            $date = $_POST['date'];
            $customer = $_POST['customer'];
            $fare = $_POST['fare'];
            $operatorname = $_POST['operator'];
            $time = $_POST['time'];

            if(isset($_POST['seats'])){
                $s = $_POST['seats'];
                
                foreach($s as $seat){
                    $seats .= ",".$seat;
                    $seatcount++;
                }
            }
            else{ ?>

            <h2 class="display-1 text-center mt-5"> <i class="fas fa-exclamation-triangle text-danger"></i> Please select at least one seat <i class="fas fa-exclamation-triangle text-danger"></i> </h2>

            <?php
                // include '../views/customerDashboard.php';
                return;
            }

            
        }
        else{
            header('location: ./customerDashboard.php');
        }

    ?>


    <nav class="alert-secondary alert mb-5">
        <div class="container d-md-flex">
            <div class="my-auto">
                <a href="http://localhost/eTickets/" style="text-decoration: none;" class="alert-secondary">
                    <h1 class="mb-3 mb-md-0 text-center" style="font-family: 'Coda Caption';">
                        <i class="fas fa-bus"></i>
                        eTickets
                    </h1>
                </a>
            </div>
            <div class="ms-auto d-md-flex">
                <div class="me-md-4 my-auto">
                    <p class="text-success alert alert-secondary btn"><i class="fas fa-user text-danger"></i> &nbsp; <?php echo $_SESSION['customerEmail']; ?></p>
                </div>
                <div class="d-flex mt-md-2">
                    <!-- <a href="#">
                    <h4 class="btn btn-outline-primary mx-2"> <i class="fas fa-user-edit"></i> Edit Profile</h4>
                    </a> -->
                    <form action="../controllers/customerDashboard.php" method="POST">
                        <button class="btn btn-outline-danger" type="submit" name="signout">Sign out <i class="fas fa-sign-out-alt"></i> </button>
                    </form>
                </div>
                
            </div>
        </div>
    </nav>

    <div class="container">
    <form action="../controllers/checkout.php" method="POST">
        <div class="row justify-content-between">
            <div class="col-md-5 col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> <i class="fas fa-university"></i> Mobile Banking</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"> <i class="fas fa-credit-card"></i> Credit Card</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false"> <i class="fas fa-truck"></i> Cash on Delivery</button>
                </li>
                </ul>
                
                <div class="tab-content mt-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="mb-4">
                            <h5>Send <span class="fs-5 badge bg-danger"><?=$fare*$seatcount;?></span> to <span class="fs-6 badge bg-secondary">+8801770900478</span> (bKash/Nagad)</h5>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="text" name="txnid" class="form-control bottomplain" id="txnid" placeholder="Transaction id">
                            <input type="hidden" name="pmethod" value="Mobile Banking">
                            <label for="txnid"> <i class="fas fa-thumbtack"></i> &nbsp; Transaction Id</label>
                        </div>
                        <button type="submit" name="confirmbook" class="btn btn-success btn-lg float-end">Confirm Booking &nbsp; <i class="fas fa-clipboard-check"></i> </button>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="fs-1 text-center text-secondary">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-amex"></i>
                        </div>

                        <div>
                            <h5 class="text-center mt-3">This method will be added soon...</h5>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div>
                            <h5 class="text-center mt-3">This method will be added soon...</h5>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 col-12">
                <ul class="list-group">
                    <li class="list-group-item text-center bg-secondary text-light">Ticket Details</li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Operator <span> <strong><?= $operatorname?></strong></span> </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Coach <span><?= $coach?></span> </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Author <span><?= $customer?></span> </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Date <span><?= $date?></span> </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Time <span><?= $time?></span> </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Seats <span><strong><?= substr($seats, 1) ?></strong></span> </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">Fare <span><?= $seatcount .' x '. $fare?></span> <strong><span><?= $fare* $seatcount?></span></strong> </li>
                </ul>
            </div>
        </div>

        <input type="hidden" name="operator" value="<?=$operatorname?>">
        <input type="hidden" name="coach" value="<?=$coach?>">
        <input type="hidden" name="customer" value="<?=$customer?>">
        <input type="hidden" name="date" value="<?=$date?>">
        <input type="hidden" name="time" value="<?=$time?>">
        <input type="hidden" name="seats" value="<?=$seats?>">
        <input type="hidden" name="fare" value="<?=$fare*$seatcount?>">
    </form>
    </div>
</body>
</html>