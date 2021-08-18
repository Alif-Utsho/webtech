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
        if(!isset($_SESSION['operatorEmail'])) header('Location: ../views/login.php');
        
        require_once '../api/users.php';
        require_once '../api/buses.php';
        require_once '../api/tickets.php';
        
    ?>
    
    <title>Operator Dashboard</title>

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
                    <p class="text-success alert alert-secondary btn"><i class="fas fa-user text-danger"></i> &nbsp; <?php echo $_SESSION['operatorEmail']; ?></p>
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
        $busAssoc = getBusOfOperator($_SESSION['operatorEmail']);
        $numOfBus = mysqli_num_rows($busAssoc);

        $ticketAssoc = getAllTickets();
        
        $operator_name = "";
        $operaorDetailsAssoc = getUserOfEmail($_SESSION['operatorEmail']);
        while($operatorDetails = mysqli_fetch_array($operaorDetailsAssoc, MYSQLI_ASSOC)){
            $operator_name = $operatorDetails['name'];
        }

        $today = date("Y-m-d");
        $todaysticketAssoc = getTicketsWithQuery("SELECT * FROM `tickets` WHERE operator='$operator_name' AND date='$today'");
        $numOftodaysTicket = mysqli_num_rows($todaysticketAssoc);
    ?>

    <!-- <div>
        <h1 class="text-center mb-4 display-5 fw-normal" ><?=$operator_name?></h1>
    </div> -->

    <?php
    
        $totalFare = 0;
        while($tickets = mysqli_fetch_array($ticketAssoc, MYSQLI_ASSOC)){
            if($operator_name==$tickets['operator']){
                $totalFare += $tickets['fare'];
            }
        }
    
    ?>

    <div class="my-5">
        <div class="d-flex text-center container">
            <div class="card col-3 mx-auto">
                <h1 class="card-header text-muted"><i class="fas fa-bus">&nbsp; Total Bus</i></h1>
                <div class="card-body">
                    <h1 class="card-text"><?= $numOfBus; ?></h1>
                </div>
            </div>

            <div class="my-auto" style="font-family: 'Coda Caption';">
                <h1 class="text-muted"><?=$operator_name?></h1>
            </div>

            <div class="card col-3 mx-auto">
                <h1 class="card-header text-muted"><i class="fas fa-dollar-sign">&nbsp; Total Revenue</i></h1>
                <div class="card-body">
                    <h1 class="card-title"> <?= $totalFare; ?></h1>
                </div>
            </div>

            <!-- <div class="card col-3 mx-auto">
                <h1 class="card-header text-muted"><i class="fas fa-calendar-alt">&nbsp; Date</i></h1>
                <div class="card-body">
                    <h2 class="card-title"><?= "321"?></h2>
                </div>
            </div> -->
        </div>

    </div>
    
    <hr class="text-success container">


    <div class="container my-5">
        <div class="text-center d-flex justify-content-between">
            <div>
                <span class="fs-3">Your Bus<?php if($numOfBus>1) echo "es"?>&nbsp; ·</span> <span class="fs-3 ms-3 fw-bold"><?=$numOfBus;?></span>
            </div>
            <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <span class="btn btn-success"><i class="fas fa-plus"></i> &nbsp; Add <?php if($numOfBus>0) echo "More"; ?> Bus</span>
            </a>
        </div>

        <!-- Add bus offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bus Addition</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="../controllers/operatorDashboard.php" method="POST">
                    <div>
                        <div class="form-floating my-3">
                            <input type="text" name="coach" class="form-control bottomplain" id="coach" placeholder="Coach name">
                            <label for="coach"> <i class="fas fa-bus text-success"></i> &nbsp; Coach</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="source" class="form-control bottomplain" id="source" placeholder="Source">
                            <label for="source"> <i class="fas fa-location-arrow text-success"></i> &nbsp; Source</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="dest" class="form-control bottomplain" id="dest" placeholder="Destination">
                            <label for="dest"> <i class="fas fa-map-marker-alt text-success"></i> &nbsp; Destination</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="time" class="form-control bottomplain" id="time" placeholder="Time">
                            <label for="time"> <i class="fas fa-clock text-success"></i> &nbsp; Time</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="fare" class="form-control bottomplain" id="fare" placeholder="Fare">
                            <label for="fare"> <i class="fas fa-dollar-sign text-success"></i> &nbsp; Fare</label>
                        </div>

                        <input type="hidden" name="operator" value="<?=$_SESSION['operatorEmail'];?>">
                        <button class="btn btn-success col-12 mt-2" type="submit" name="addbus"><i class="fas fa-plus"></i> &nbsp; Add Bus</button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- add bus offcanvas end -->

    <?php if($numOfBus>0){?>
        <div class="row mt-4">
        <?php 
            while($bus = mysqli_fetch_array($busAssoc, MYSQLI_ASSOC)){
        ?>
            

            <div class="card m-1" style="width: 20rem;">
                <img src="../images/bus_img.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-route"></i> &nbsp; <?= $bus['source']; ?> to <?=$bus['dest'];?> </h5>
                    <p class="card-text">Coach #<?=$bus['coach'];?> <br> Time: <?=$bus['time'];?> <br>Fare <strong>৳<?=$bus['fare'];?></strong></p>
                    <div class="col-12">
                        <div class="d-flex">
                            
                            <button class="btn btn-primary col-5 mx-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas<?=$bus['id'];?>" aria-controls="<?=$bus['id'];?>">
                                <i class="fas fa-edit"></i> &nbsp; Edit
                            </button>
                        
                            <button type="button" class="btn btn-danger col-5 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$bus['id'];?>">
                                <i class="fas fa-trash"></i> &nbsp; Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- delete modal start -->
            <div class="modal fade" id="exampleModal<?=$bus['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deleting <?=$bus['coach'];?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure want to Delete <strong><?=$bus['coach'];?></strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="../controllers/operatorDashboard.php" method="POST">
                            <input type="hidden" name="coachid" value="<?=$bus['id'];?>">
                            <button type="submit" name="deletebus" class="btn btn-danger px-2 ms-2"><i class="fas fa-trash"></i> &nbsp; Delete</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- delete modal end -->

            <!-- Edit offcanvas start -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas<?=$bus['id'];?>" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Coach #<?=$bus['coach']?></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="../controllers/operatorDashboard.php" method="POST">
                        <div>
                            <div class="form-floating my-3">
                                <input type="text" name="source" class="form-control bottomplain" id="source" placeholder="Source" value="<?=$bus['source'];?>">
                                <label for="source"> <i class="fas fa-location-arrow text-success"></i> &nbsp; Source</label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="text" name="dest" class="form-control bottomplain" id="dest" placeholder="Destination" value="<?=$bus['dest'];?>" >
                                <label for="dest"> <i class="fas fa-map-marker-alt text-success"></i> &nbsp; Destination</label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="text" name="time" class="form-control bottomplain" id="time" placeholder="Time" value="<?=$bus['time'];?>" >
                                <label for="time"> <i class="fas fa-clock text-success"></i> &nbsp; Time</label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="text" name="fare" class="form-control bottomplain" id="fare" placeholder="Fare" value="<?=$bus['fare'];?>" >
                                <label for="fare"> <i class="fas fa-dollar-sign text-success"></i> &nbsp; Fare</label>
                            </div>

                            <input type="hidden" name="busid" value="<?=$bus['id'];?>">
                            <button class="btn btn-success col-12 mt-2" type="submit" name="editbus"><i class="fas fa-save"></i> &nbsp; Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- edit offcanvas end -->

            <?php } ?>

            
        </div>

        <hr class="text-success container my-5">

        <div class="container">
            <form action="../controllers/reservation.php" method="POST">
                <div class="d-md-flex justify-content-between mb-5">
                    <div class="fs-3 my-auto">Check Reservation &nbsp;·</div>
                    <div class="col-md-3 col-12">
                        <select class="form-select form-floating py-3 <?php if(isset($coach_err)) echo 'is-invalid'; ?>" name="coach" aria-label="Default select example">
                            <option selected disabled>Select your coach</option>
                            <?php
                                if($numOfBus>0){
                                    $coachAssoc = getBusOfOperator($_SESSION['operatorEmail']);
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
        
        <hr class="text-success container my-5">

            <div class="text-center d-flex justify-content-between">
                <div>
                    <span class="fs-3">Today's Ticket<?php if($numOftodaysTicket>1) echo "s"?>&nbsp; ·</span> <span class="fs-3 ms-3 fw-bold"><?=$numOftodaysTicket;?></span>
                </div>
                <div>

                    <?php

                        $todays_revenue = 0;
                        while($ticketRev = mysqli_fetch_array($todaysticketAssoc, MYSQLI_ASSOC)){
                            $todays_revenue += $ticketRev['fare'];
                        }

                    ?>
                    <span class="fs-3">Today's Revenue&nbsp; ·</span> <span class="fs-3 ms-3 fw-bold"><?=$todays_revenue;?></span>

                </div>
            </div>

            <?php

                if($numOftodaysTicket>0){
            ?>
            <div class="mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">id#</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Customer E-mail</th>
                            <th scope="col">Customer Phone</th>
                            <th scope="col">Coach</th>
                            <th scope="col">Reserved Seats</th>
                            <th scope="col">Paid Amount</th>
                            <th scope="col">Transaction Method</th>
                            <th scope="col">Transaction Id</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            $todaystickets = getTicketsWithQuery("SELECT * FROM `tickets` WHERE operator='$operator_name' AND date='$today'");
                            while($ticketDetails = mysqli_fetch_array($todaystickets, MYSQLI_ASSOC)){
                                
                                $username = $phone = "";
                                $userAssoc = getUserOfEmail($ticketDetails['customer']);
                                while($userDetails = mysqli_fetch_array($userAssoc, MYSQLI_ASSOC)){
                                    $username = $userDetails['name'];
                                    $phone = $userDetails['phone'];
                                }
                            
                        ?>
                            <tr>
                                <th scope="row"><?=$ticketDetails['id'];?></th>
                                <td><?=$username;?></td>
                                <td><?=$ticketDetails['customer'];?></td>
                                <td><?=$phone;?></td>
                                <td><?=$ticketDetails['coach']?></td>
                                <td><?= substr($ticketDetails['seats'], 1); ?></td>
                                <td><?=$ticketDetails['fare'];?></td>
                                <td><?=$ticketDetails['pmethod'];?></td>
                                <td><?=$ticketDetails['txnid'];?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>

        <div>
            
        </div>
    </div>
    <?php } else{?>
    <div>
        <h3 class="">You have no bus</h3>
    </div>
    <?php } ?>





</body>
</html>