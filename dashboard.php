<?php session_start();
require 'config.php'; 

if (isset($_SESSION['sess_authed']) && $_SESSION['sess_authed'] == "true") {
    #good
} else {
    header("Location: index.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Dashboard - <?php echo $site_name; ?></title>
</head>
<body>
<main>
   <section class="py-5 text-center container">
      <div class="row py-lg-5">
         <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Dine licenser - <?php echo $site_name; ?></h1>
            <p class="lead text-muted">Velkommen her kan du se alle licenser i databasen!</p>
            <p> <a href="nynoegle.php" class="btn btn-sm btn-success">Opret en ny licens </a> <a href="logout.php" class="btn btn-sm btn-warning">Logud af panelet </a></p>
            <?php
                if(isset($_GET['msg'])) {
                    $get_msg=$_GET['msg'];
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"> '. $get_msg .' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
                }
            ?>
         </div>
      </div>
   </section>
   <div class="album py-5 bg-light">
      <div class="container">
         <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

            <?php

                require 'dbconn.php';
                    
                $sql = "SELECT * FROM licenses";
                $stmt = $conn->prepare($sql); 
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $lic_id = $row['id'];
                    $license = $row['license-key'];
                    $beskrivelse = $row['description'];
                    $oprettet = $row['date'];
                    echo '<div class="col"> <div class="card shadow-sm"> <h3 class="display-6 fw-normal text-center">Licens nr. '. $lic_id .'</h3> <div class="card-body"> <p class="card-text"> Licens nøgle: <code>'. $license .'</code><br>Oprettet: '. $oprettet .'<br> Beskrivelse: '. $beskrivelse .'<br> </p> <div class="d-flex justify-content-between align-items-center"> <div class="btn-group"> <a href="sletnoegle.php?id='. $lic_id .'" class="btn btn-sm btn-danger">Slet Licens Nøgle </a> </div> </div> </div> </div> </div>';
                }

            ?>            
            
         </div>
      </div>
   </div>
</main>


    
</body>
</html>