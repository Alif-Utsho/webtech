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
    
    <?php
        session_start();
        if(!isset($_SESSION['adminEmail'])) header('Location: ./login.php');
        
        require_once '../api/users.php';
        require_once '../api/buses.php';
        require_once '../api/tickets.php';
        
    ?>

    <title>Admin Dashboard</title>

    <style>
        body {
            background-color: #f5f5f5;
        }

    </style>
</head>
<body>
    <nav class="alert-secondary alert mb-3">
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
                    <p class="text-success alert alert-secondary btn"><i class="fas fa-user text-danger"></i> &nbsp; <?php echo $_SESSION['adminEmail']; ?></p>
                </div>
                <div class="d-flex mt-md-2">
                    <!-- <a href="#">
                    <h4 class="btn btn-outline-primary mx-2"> <i class="fas fa-user-edit"></i> Edit Profile</h4>
                    </a> -->
                    <form action="../controllers/operatorDashboard.php" method="POST">
                        <button class="btn btn-outline-danger" type="submit" name="signout">Sign out <i class="fas fa-sign-out-alt"></i> </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <?php 
        $operatorAssoc = getAllOperators();
        $numOfOperators = mysqli_num_rows($operatorAssoc);
    ?>

    <div class="container">
        <div class="text-center d-flex justify-content-between">
            <div>
                <span class="fs-3">Operator<?php if($numOfOperators>1) echo "s"?>&nbsp; ·</span> <span class="fs-3 ms-3 fw-bold"><?=$numOfOperators;?></span>
            </div>
            <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <span class="btn btn-success"><i class="fas fa-plus"></i> &nbsp; Add <?php if($numOfOperators>0) echo "More"; ?> Operator</span>
            </a>
        </div>

        <!-- Add operator offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Operator Addition</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="../controllers/adminDashboard.php" method="POST">
                    <div>
                        <div class="form-floating my-3">
                            <input type="text" name="name" class="form-control bottomplain" id="name" placeholder="Name">
                            <label for="name"> <i class="fas fa-user text-success"></i> &nbsp; Name</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="phone" class="form-control bottomplain" id="phone" placeholder="phone">
                            <label for="phone"> <i class="fas fa-phone text-success"></i> &nbsp; Phone</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="email" class="form-control bottomplain" id="email" placeholder="email">
                            <label for="email"> <i class="fas fa-envelope text-success"></i> &nbsp; E-mail</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="password" name="password" class="form-control bottomplain" id="password" placeholder="password">
                            <label for="password"> <i class="fas fa-key text-success"></i> &nbsp; Password</label>
                        </div>

                        <button class="btn btn-success col-12 mt-2" type="submit" name="addOperator"><i class="fas fa-plus"></i> &nbsp; Add Operator</button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- add operator offcanvas end -->

        <?php if($numOfOperators>0){?>
        <div class="row mt-4">
        <?php 
            while($operator = mysqli_fetch_array($operatorAssoc, MYSQLI_ASSOC)){
        ?>
            

            <div class="card m-1" style="width: 20rem;">
                <img src="../images/operator.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-bus text-secondary"></i> &nbsp; <?= $operator['name']; ?></h5>
                    <p class="card-text">Phone <?=$operator['phone'];?> <br> E-mail: <?=$operator['email'];?> </p>
                    <div class="col-12">
                        <div class="d-flex">
                            <button class="btn btn-primary col-5 mx-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas<?=$operator['id'];?>" aria-controls="<?=$operator['id'];?>">
                                <i class="fas fa-edit"></i> &nbsp; Edit
                            </button>
                        
                            <button type="button" class="btn btn-danger col-5 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$operator['id'];?>">
                                <i class="fas fa-trash"></i> &nbsp; Delete
                            </button>
                        </div>

                        <button type="button" class="btn btn-success mt-1 col-12" data-bs-toggle="modal" data-bs-target="#exampleModaldetails<?=$operator['id'];?>">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- details modal start -->

            <div class="modal fade" id="exampleModaldetails<?=$operator['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?=$operator['name']?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php 
                            $busAssoc = getBusOfOperator($operator['email']);
                            $numOfBus = mysqli_num_rows($busAssoc);

                            $ticketAssoc = getAllTickets();
                            $totalFare = 0;
                            while($tickets = mysqli_fetch_array($ticketAssoc, MYSQLI_ASSOC)){
                                if($operator['name']==$tickets['operator']){
                                    $totalFare += $tickets['fare'];
                                }
                            }
                        ?>

                        <h4>Total bus : <?=$numOfBus;?></h4>
                        <h4>Total Revenue : <?=$totalFare;?></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>

            <!-- details modal end -->

            <!-- delete modal start -->
            <div class="modal fade" id="exampleModal<?=$operator['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deleting <?=$operator['name'];?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure want to Delete <strong><?=$operator['name'];?></strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="../controllers/adminDashboard.php" method="POST">
                            <input type="hidden" name="operatorid" value="<?=$operator['id'];?>">
                            <button type="submit" name="deleteOperator" class="btn btn-danger px-2 ms-2"><i class="fas fa-trash"></i> &nbsp; Delete</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- delete modal end -->

            <!-- Edit offcanvas start -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas<?=$operator['id'];?>" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel"><?=$operator['name']?></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="../controllers/adminDashboard.php" method="POST">
                        <div>
                            <div class="form-floating my-3">
                                <input type="text" name="name" class="form-control bottomplain" id="name" placeholder="Name" value="<?=$operator['name'];?>">
                                <label for="name"> <i class="fas fa-user text-success"></i> &nbsp; Name</label>
                            </div>
                            <div class="form-floating my-3"> 
                                <input type="text" name="phone" class="form-control bottomplain" id="phone" placeholder="phone" value="<?=$operator['phone'];?>">
                                <label for="phone"> <i class="fas fa-phone text-success"></i> &nbsp; Phone</label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="text" name="email" class="form-control bottomplain" id="email" placeholder="email" value="<?=$operator['email'];?>">
                                <label for="email"> <i class="fas fa-envelope text-success"></i> &nbsp; E-mail</label>
                            </div>

                            <input type="hidden" name="id" value="<?=$operator['id'];?>">
                            <button class="btn btn-success col-12 mt-2" type="submit" name="updateOperator"><i class="fas fa-save"></i> &nbsp; Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- edit offcanvas end -->

        <?php }} ?>

        </div>
    </div>

    <div class="container my-4">
        <form action="../controllers/reservation.php" method="POST">
            <div class="d-md-flex justify-content-between mb-5">
                <div class="fs-3 my-auto">Check Reservation &nbsp;·</div>
                <div class="col-md-3 col-12">
                    <select class="form-select form-floating py-3 <?php if(isset($coach_err)) echo 'is-invalid'; ?>" name="coach" aria-label="Default select example">
                        <option selected disabled>Select your coach</option>
                        <?php
                            if($numOfOperators>0){
                                $coachAssoc = getAllBus();
                                while($coach=mysqli_fetch_array($coachAssoc, MYSQLI_ASSOC)){
                                    ?>
                                        <option value="<?=$coach['coach'];?>"><?=$coach['coach']?></option>
                                    <?php
                                }
                            }
                            else{
                                echo "<option disabled>You have no Coach</option>";
                            }
                        ?>
                    </select>
                    <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                        <i class="fas fa-exclamation-triangle"></i> &nbsp;
                        <?php if(isset($coach_err)) echo $coach_err; ?>
                    </div>
                </div>

                <div class="form-floating col-md-3 my-3 my-md-0 col-12">
                    <input type="date" name="date" value="<?php if(isset($date)) echo $date; else echo date("Y-m-d") ?>" class="form-control" id="date" placeholder="Date">
                    <label for="date"> <i class="fas fa-clock text-success"></i> &nbsp; Date</label>
                </div>
                <div class="col-12 col-md-2 mt-md-1">
                    <button type="submit" name="check" class="btn btn-lg btn-success col-12" value="Check">Check &nbsp; <i class="fas fa-check"></i> </button>
                </div>
            </div>
        </form>

    </div>

</body>
</html>