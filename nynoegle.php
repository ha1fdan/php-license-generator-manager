<?php session_start();
require 'config.php'; 

if (isset($_SESSION['sess_authed']) && $_SESSION['sess_authed'] == "true") {
    #good
} else {
    header("Location: index.php");
}

$dato = date("Y-m-d");
function generate_license() {
    $h_i = date("H-i-s");
    $activationCode = sha1($h_i . 'ActivationCode'); #FJERN IKKE 'ActivationCode' fra koden eller skift den!
    $finalCode = substr($activationCode, 1, 5) . "-" .substr($activationCode, 4, 5) . "-" .substr($activationCode, 9, 5) . "-" .substr($activationCode, 14, 5) . "-".substr($activationCode, 19, 5) . "";
    return strtoupper($finalCode);

}


if(isset($_POST['submit'])) {
    $noegle = $_POST['licenskey'];
    $description = $_POST['description'];
    $new_date = date('d-m-Y', strtotime($_POST['entry_date']));
    $new_new_date = $new_date ." ".date("H:i");

    require 'dbconn.php';
    $stmt = $conn->prepare("INSERT INTO licenses (`id`, `license-key`, `description`, `date`) VALUES (NULL, ?, ?, ?)");
    $stmt->bind_param("sss", $noegle, $description, $new_new_date);
    if ($stmt->execute()) { 
        header("Location: dashboard.php?msg=En ny nøgle blev oprettet!");
    } else {
        header("Location: dashboard.php?msg=Nøglen blev ikke oprettet, der skete en fejl!");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Ny Nøgle - <?php echo $site_name; ?></title>
</head>
<body>
<main>
<section class="py-5 text-center container">
      <div class="row py-lg-5">
         <div class="col-lg-10 col-md-10 mx-auto">
            <h1 class="fw-light">Opret ny licens - <?php echo $site_name; ?></h1>
            <p class="lead text-muted">Her opretter du nye licens nøgler i databasen!</p>
            <p> <a href="dashboard.php" class="btn btn-sm btn-primary">Tilbage til Dashboard </a> <a href="logout.php" class="btn btn-sm btn-warning">Logud af panelet </a></p>
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
             
        <form class="form-control" method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Nøgle: </span>
                <input type="text" class="form-control" placeholder="XXXXX-XXXXX-XXXXX-XXXXX-XXXXX" aria-label="Licensnøgle" aria-describedby="basic-addon1" name="licenskey" value="<?php echo generate_license(); ?>" required>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Beskrivelse af nøglen: </span>
                <input type="text" class="form-control" placeholder="Nøgle til..." aria-label="Licensnøgle" aria-describedby="basic-addon1" name="description" required>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Oprettelsesdato af nøglen: </span>
                <input type="date" name='entry_date' class="form-control" id="entry_date" value="<?php echo $dato; ?>">
            </div>

            <div class="input-group mb-3">
                <button type="submit" name="submit" class="btn btn-primary mb-3">Opret nøgle i database</button>
            </div>
        </form>
            
         </div>
      </div>
   </div>
</main>

    
</body>
</html>