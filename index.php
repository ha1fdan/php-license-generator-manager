<?php session_start(); require 'config.php'; ?>

<?php

if (isset($_SESSION['sess_authed']) && $_SESSION['sess_authed'] == "true") {
    header("Location: dashboard.php");
  }

if(isset($_POST["submit"])){ 
  
    if(!empty($_POST['username']) && !empty($_POST['passwd'])) { 
        $user=$_POST['username'];
        $pass=md5($_POST['passwd']);
      
        require 'dbconn.php';
      
        $sql = "SELECT * FROM users WHERE username=? AND md5passwd=?";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $dbusername = $row['username'];
            $dbpassword = $row['md5passwd'];
            if($user == $dbusername && $pass == $dbpassword) {
                $_SESSION['sess_authed']="true";
            
                /* Redirect browser */
                header("Location: dashboard.php");
            }
        }
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
    <link href="assets/signin.css" rel="stylesheet">
    <title>Log på - <?php echo $site_name; ?></title>
</head>
<body class="text-center">
    <main class="form-signin">
        <form method="POST">
            <h1 class="h1 mb-3 fw-normal">Log venligst ind</h1>

            <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" name="username" placeholder="examplename">
            <label for="floatingInput">Brugernavn</label>
            </div>
            <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="passwd" placeholder="Adgangskode">
            <label for="floatingPassword">Adgangskode</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Log ind</button>
            <p class="mt-5 mb-3 text-muted"><?php echo $site_name; ?> &copy; 2022-<?php echo date("Y"); ?></p>
        </form>
    </main>
</body>
</html>