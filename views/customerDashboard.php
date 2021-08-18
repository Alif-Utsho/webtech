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

    <link rel="stylesheet" href="../styles/customerDashboard.css">

    <title>Customer Dashboard</title>

    <?php
        session_start();
        if(!isset($_SESSION['customerEmail'])) header('Location: ./login.php');

        require_once '../api/users.php';
        require_once '../api/buses.php';
        require_once '../api/tickets.php';

        $operatorName="";
    ?>

</head>
<body>
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
                    <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <h4 class="btn btn-outline-primary mx-2"> <i class="fas fa-ticket-alt"></i> Your Tickets</h4>
                    </a>
                    <form action="../controllers/customerDashboard.php" method="POST">
                        <button class="btn btn-outline-danger" type="submit" name="signout">Sign out <i class="fas fa-sign-out-alt"></i> </button>
                    </form>
                </div>
                
            </div>
        </div>
    </nav>



    <?php
        $numOfUserTickets = 0;
        $ticketOfUserAssoc = getTicketsOfUser($_SESSION['customerEmail']);
        $numOfUserTickets = mysqli_num_rows($ticketOfUserAssoc);

    ?>
    <div class="container">
        <div class="collapse mb-5 alert-secondary" id="collapseExample">
            <div class="card">
                <div class="card-header text-center d-flex justify-content-between">
                    <h4>
                        Your Tickets
                    </h4>
                    <h4>
                        <?=$numOfUserTickets?>
                    </h4>
                </div>
                <div class="card-body">
                    <?php

                        $today = date("Y-m-d");
                        $customer_email = $_SESSION['customerEmail'];
                        $todaystickets = getTicketsWithQuery("SELECT * FROM `tickets` WHERE customer='$customer_email' AND date='$today'");
                        if(mysqli_num_rows($todaystickets)>0){ ?>
                            <h4 class="text-center alert alert-primary">Today's Tickets &nbsp; <i class="fas fa-chevron-down"></i> </h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">id#</th>
                                        <th scope="col">Your Name</th>
                                        <th scope="col">Your E-mail</th>
                                        <th scope="col">Your Phone</th>
                                        <th scope="col">Reserved Seats</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Transaction Method</th>
                                        <th scope="col">Transaction Id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $username = $phone = "";
                                        $userAssoc = getUserOfEmail($_SESSION['customerEmail']);
                                        while($userDetails = mysqli_fetch_array($userAssoc, MYSQLI_ASSOC)){
                                            $username = $userDetails['name'];
                                            $phone = $userDetails['phone'];
                                        }
                                        while($ticketDetails = mysqli_fetch_array($todaystickets, MYSQLI_ASSOC)){ 
                                        
                                    ?>
                                        <tr>
                                            <th scope="row"><?=$ticketDetails['id'];?></th>
                                            <td><?=$username;?></td>
                                            <td><?=$ticketDetails['customer'];?></td>
                                            <td><?=$phone;?></td>
                                            <td><?= substr($ticketDetails['seats'], 1); ?></td>
                                            <td><?=$ticketDetails['fare'];?></td>
                                            <td><?=$ticketDetails['date'];?></td>
                                            <td><?=$ticketDetails['time'];?></td>
                                            <td><?=$ticketDetails['pmethod'];?></td>
                                            <td><?=$ticketDetails['txnid'];?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php }
                        else{ ?>
                            <h4 class="text-center alert-danger alert">No Tickets today</h4>
                        <?php } ?>


                    <?php
                        $upcomingTickets = getTicketsWithQuery("SELECT * FROM `tickets` WHERE customer='$customer_email' AND date>'$today'");
                        if(mysqli_num_rows($upcomingTickets)>0){ ?>
                            <h4 class="text-center alert-primary alert">Upcoming Tickets &nbsp; <i class="fas fa-chevron-down"></i> </h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">id#</th>
                                        <th scope="col">Your Name</th>
                                        <th scope="col">Your E-mail</th>
                                        <th scope="col">Your Phone</th>
                                        <th scope="col">Reserved Seats</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>                                        
                                        <th scope="col">Transaction Method</th>
                                        <th scope="col">Transaction Id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $username = $phone = "";
                                        $userAssoc = getUserOfEmail($_SESSION['customerEmail']);
                                        while($userDetails = mysqli_fetch_array($userAssoc, MYSQLI_ASSOC)){
                                            $username = $userDetails['name'];
                                            $phone = $userDetails['phone'];
                                        }
                                        while($ticketDetails = mysqli_fetch_array($upcomingTickets, MYSQLI_ASSOC)){ 
                                        
                                    ?>
                                        <tr>
                                            <th scope="row"><?=$ticketDetails['id'];?></th>
                                            <td><?=$username;?></td>
                                            <td><?=$ticketDetails['customer'];?></td>
                                            <td><?=$phone;?></td>
                                            <td><?= substr($ticketDetails['seats'], 1); ?></td>
                                            <td><?=$ticketDetails['fare'];?></td>
                                            <td><?=$ticketDetails['date'];?></td>
                                            <td><?=$ticketDetails['time'];?></td>
                                            <td><?=$ticketDetails['pmethod'];?></td>
                                            <td><?=$ticketDetails['txnid'];?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php }
                        else{ ?>
                            <h4 class="text-center alert-danger alert">No Upcoming Tickets</h4>
                    <?php } ?>


                    <?php
                        $prevTickets = getTicketsWithQuery("SELECT * FROM `tickets` WHERE customer='$customer_email' AND date<'$today'");
                        if(mysqli_num_rows($prevTickets)>0){ ?>
                            <h4 class="text-center alert alert-primary">Previous Tickets &nbsp; <i class="fas fa-chevron-down"></i> </h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">id#</th>
                                        <th scope="col">Your Name</th>
                                        <th scope="col">Your E-mail</th>
                                        <th scope="col">Your Phone</th>
                                        <th scope="col">Reserved Seats</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>                                        
                                        <th scope="col">Transaction Method</th>
                                        <th scope="col">Transaction Id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $username = $phone = "";
                                        $userAssoc = getUserOfEmail($_SESSION['customerEmail']);
                                        while($userDetails = mysqli_fetch_array($userAssoc, MYSQLI_ASSOC)){
                                            $username = $userDetails['name'];
                                            $phone = $userDetails['phone'];
                                        }
                                        while($ticketDetails = mysqli_fetch_array($prevTickets, MYSQLI_ASSOC)){ 
                                        
                                    ?>
                                        <tr>
                                            <th scope="row"><?=$ticketDetails['id'];?></th>
                                            <td><?=$username;?></td>
                                            <td><?=$ticketDetails['customer'];?></td>
                                            <td><?=$phone;?></td>
                                            <td><?= substr($ticketDetails['seats'], 1); ?></td>
                                            <td><?=$ticketDetails['fare'];?></td>
                                            <td><?=$ticketDetails['date'];?></td>
                                            <td><?=$ticketDetails['time'];?></td>
                                            <td><?=$ticketDetails['pmethod'];?></td>
                                            <td><?=$ticketDetails['txnid'];?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php }
                        else{ ?>
                            <h4 class="text-center alert-danger alert">No Previous Tickets</h4>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php if(!isset($count)){ ?>
            <h3 class="text-center mb-3">Seach Your Desired bus here</h3>
        <?php } ?>

    <div class="container">
        <form action="../controllers/customerDashboard.php" method="GET">
            <div class="d-md-flex justify-content-between mb-5">
                <div class="form-floating col-md-3 col-12">
                    <input type="text" name="source" class="form-control <?php if(strlen($source_err)>0) echo 'is-invalid';?>" id="email" placeholder="From" value="<?php if(isset($source)) echo $source; ?>">
                    <label for="source"> <i class="fas fa-location-arrow text-success"></i> &nbsp; Source</label>
                    <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                        <i class="fas fa-exclamation-triangle"></i> &nbsp;
                        <?php if(isset($source_err)) echo $source_err; ?>
                    </div>
                </div>
                <div class="form-floating col-md-3 my-3 my-md-0 col-12">
                    <input type="text" name="dest" class="form-control <?php if(strlen($dest_err)>0) echo 'is-invalid';?>" id="email" placeholder="From" value="<?php if(isset($dest)) echo $dest; ?>">
                    <label for="dest"> <i class="fas fa-map-marker-alt text-success"></i> &nbsp; Destination</label>
                    <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                        <i class="fas fa-exclamation-triangle"></i> &nbsp;
                        <?php if(isset($dest_err)) echo $dest_err; ?>
                    </div>
                </div>

                <div class="form-floating col-md-3 my-3 my-md-0 col-12">
                    <input type="date" name="date" value="<?php if(isset($date)) echo $date; else echo date("Y-m-d") ?>" min="<?=date("Y-m-d") ?>" class="form-control <?php if(strlen($date_err)>0) echo 'is-invalid';?>" id="date" placeholder="Date">
                    <label for="date"> <i class="fas fa-clock text-success"></i> &nbsp; Date</label>
                    <div id="validationServer05Feedback" class="invalid-feedback mb-2">
                        <i class="fas fa-exclamation-triangle"></i> &nbsp;
                        <?php if(isset($date_err)) echo $date_err; ?>
                    </div>
                </div>

                <div class="col-12 col-md-2 mt-md-1">
                    <button type="submit" name="search" class="btn btn-lg btn-success col-12" value="Search">Search &nbsp; <i class="fas fa-search"></i> </button>
                </div>

            </div>
        </form>


        <?php if(isset($count) && $count>0){ ?>
            <?php while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
            <?php
                $email = $operatorName = "";
                $busAssoc = getBusOfCoach($row['coach']);
                while($b = mysqli_fetch_array($busAssoc, MYSQLI_ASSOC)){
                    $email = $b['operator'];
                    
                }
                $userAssoc = getUserOfEmail($email);
                while($users = mysqli_fetch_array($userAssoc, MYSQLI_ASSOC)){
                    $operatorName = $users['name'];
                }

            ?>
            <div class="accordion my-2" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $row['coach'] ?>" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-bus fs-4 text-secondary">&nbsp; &nbsp;</i> 
                        <div class="ms-2 col-md-4 col-3">
                            <div class="fw-bold mb-1"> <?php echo $operatorName; ?> </div>
                            Coach #<?php echo $row['coach'] ?>
                        </div>
                        <div class="ms-2 me-auto my-auto">
                            <?php echo $row['time'] ?>
                        </div>

                        <?php
                        
                            $seats=$ticketcoach=$ticketdate='';
                            $seatAssoc = getAllTickets();
                            while($ticket=mysqli_fetch_array($seatAssoc, MYSQLI_ASSOC)){
                                if($ticket['coach']==$row['coach'] && $date == $ticket['date']){
                                    $seats .= $ticket['seats'];
                                }
                            }
                            $seatcount = 0;
                            for($j=0; $j<strlen($seats); $j++){
                                if($seats[$j]==','){
                                    $seatcount++;
                                }
                            }

                        ?>
                        <span class="badge bg-success rounded-pill my-auto"> <?php echo number_format($row['seat'])-$seatcount; ?> </span>
                        <div class="ms-2 ms-auto my-auto fw-bold fs-5">
                            <span class="fs-3">৳</span> <?php echo $row['fare'] ?>  
                        </div>
                    </button>
                    </h2>
                    <div id="<?php echo $row['coach'] ?>" class="accordion-collapse collapse" aria-labelledby="collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- <h3>This space will be used for seat selection and booking</h3> -->
                            <div class="row">
                                <div class="col-12 col-md-3 offset-md-1 my-md-auto pb-md-5 me-md-5">
                                    <p class="alert alert-secondary">Select your desired seat and book</p>
                                </div>
                                <div class="col-12 col-md-7">            <!-- style="background-image: url('../images/bus.png');" -->
                                    <form action="../views/checkout.php" method="POST">
                                        
                                    <?php
                                        // for($i=1; $i<=10; $i++){
                                        //     echo '<input type="checkbox" class="btn-check" name="A'.$i.'" id="A'.$i.$row['coach'].'" autocomplete="off"> <label class="mx-1 col-1 my-1 btn btn-outline-success" for="A'.$i.$row['coach'].'">A'.$i.'</label>';
                                        // } echo '<br>';
                                        // for($i=1; $i<=10; $i++){
                                        //     echo '<input type="checkbox" class="btn-check" name="B'.$i.'" id="B'.$i.$row['coach'].'" autocomplete="off"> <label class="mx-1 col-1 my-1 btn btn-outline-success" for="B'.$i.$row['coach'].'">B'.$i.'</label>';
                                        // } echo '<br> <br>';
                                        // for($i=1; $i<=10; $i++){
                                        //     echo '<input type="checkbox" class="btn-check" name="C'.$i.'" id="C'.$i.$row['coach'].'" autocomplete="off"> <label class="mx-1 col-1 my-1 btn btn-outline-success" for="C'.$i.$row['coach'].'">C'.$i.'</label>';
                                        // } echo '<br>';
                                        // for($i=1; $i<=10; $i++){
                                        //     echo '<input type="checkbox" class="btn-check" name="D'.$i.'" id="D'.$i.$row['coach'].'" autocomplete="off"> <label class="mx-1 col-1 my-1 btn btn-outline-success" for="D'.$i.$row['coach'].'">D'.$i.'</label>';
                                        // }

                                        // echo '<br> <br>';

                                        
                                        // $seats = "";
                                        $k=1;
                                        $seat='A';
                                        for($i=1; $i<=40; $i++){

                                            if($i<=10){
                                                $seat='A';
                                            }
                                            elseif($i>10 && $i<=20){
                                                $seat='B';
                                            }
                                            elseif($i>20 && $i<=30){
                                                $seat='C';
                                            }
                                            elseif($i>30 && $i<=40){
                                                $seat='D';
                                            }


                                            ?>
                                            <input type="checkbox" class="btn-check" name="seats[]" id="<?=$seat.$k.$row['coach'] ?>" value="<?=$seat.$k?>" autocomplete="off" <?php if(strpos($seats, $seat.$k)) echo "disabled checked"; ?> > 
                                            <label class="mx-1 col-1 my-1 btn btn-outline-success" for="<?= $seat.$k.$row['coach'] ?>"> <?= $seat.$k ?></label>
                                            
                                            <?php
                                            if($k%10==0){
                                                echo '<br>';
                                                if($i==20){
                                                    echo '<br>';
                                                }
                                                $k=1;
                                                continue;
                                            }
                                            $k++;
                                        }
                                    ?>

                                    <input type="hidden" name="coach" value="<?=$row['coach'];?>">
                                    <input type="hidden" name="date" value="<?php if(isset($date)) echo $date; else echo date("Y-m-d")?>">
                                    <input type="hidden" name="customer" value="<?=$_SESSION['customerEmail']?>">
                                    <input type="hidden" name="fare" value="<?= $row['fare']?>">
                                    <input type="hidden" name="operator" value="<?= $operatorName?>">
                                    <input type="hidden" name="time" value="<?= $row['time'] ?>">
                                    <button class="offset-md-9 offset-6 btn btn-success mt-4 btn-lg col-md-3 col-6" name="book" type="submit" >Book &nbsp; <i class="fas fa-calendar-check"></i> </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="mb-5"></div>
        <?php } elseif(isset($count) && $count==0) { ?>
            <h3 style="text-align: center;">Oops, No bus Available :(</h3>
        <?php } ?>
               

    </div>
</body>
</html>