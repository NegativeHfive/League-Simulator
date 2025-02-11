<?php
include_once "../Classes/Team.php";

$ratings = null;  
$teamName = "";
$continent = "";
$foto = null;
$fotoPath = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {
        $teamName = htmlspecialchars($_POST['name']);
        $continent = htmlspecialchars($_POST['continent']);
        
        $ratings = rand(1, 100);  

        // Voor het toevogen van teams
        $foto = $_FILES['foto'];
        $fotoPath = '../uploads/' . basename($foto['name']);
        $fotoSaved = move_uploaded_file($foto['tmp_name'], $fotoPath);

        // If file uploaded successfully, insert team into database
        if ($fotoSaved) {
            $team = new Team();
            $success = $team->insertTeam($teamName, $ratings, $continent, $fotoPath);

            if ($success) {
                echo "Team added successfully!";
            } else {
                echo "There was an issue adding the team.";
            }
        } else {
            echo "Uploading the photo failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Your Team </title>
    <link rel="stylesheet" href="../css/edit.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <audio id="bgMusic" src="../audio/CITY by Louis Culture.mp3" autoplay loop></audio>
</head>
<body>

     <div class="navbar">
            <h2>negative.</h2>
            <div class="icons">
                <div class="home">
                    <ion-icon name="home"></ion-icon>
                    <a href="../leaguehome.php" class="homelink">Home</a>
                </div>
                <div class="home">
                    <ion-icon name="home"></ion-icon>
                    <a href="../homepage/hometeam.php" class="homelink">Fixtures</a>
                </div>
                <div class="rankings">
                    <ion-icon name="podium"></ion-icon>
                    <a href="../homepage/ranking.php" class="rankingslink">Rankings</a>
                </div>
                <div class="help">
                    <ion-icon name="create"></ion-icon>
                    <a href="../homepage/add.php" class="editlink">Add Teams</a>
                </div>
                <div class="help">
                    <ion-icon name="create"></ion-icon>
                    <a href="../homepage/edit.php" class="editlink">Edit Teams</a>
                </div>
                <div class="help">
                    <ion-icon name="document-text"></ion-icon>
                    <a href="../homepage/csv.php" class="editlink">Export Data</a>
                </div>
            </div>
        </div>

        <h1>Add a Team </h1>

       <div class="form">
       <div class="form">
        <form action="../homepage/add.php" method="post" enctype="multipart/form-data">
            <label for="name">Your Team:</label><br>
            <input type="text" name="name" value="<?php echo $teamName; ?>" required><br><br>

            <label for="continent">Choose a continent:</label><br>
            <select name="continent" id="cars">
                <option value="europe" <?php echo ($continent == "europe") ? "selected" : ""; ?>>Europe</option>
                <option value="asia" <?php echo ($continent == "asia") ? "selected" : ""; ?>>Asia</option>
                <option value="northamerica" <?php echo ($continent == "northamerica") ? "selected" : ""; ?>>North America</option>
                <option value="southamerica" <?php echo ($continent == "southamerica") ? "selected" : ""; ?>>South America</option>
                <option value="australia" <?php echo ($continent == "australia") ? "selected" : ""; ?>>Australia</option>
                <option value="antartica" <?php echo ($continent == "antartica") ? "selected" : ""; ?>>Antartica</option>
            </select><br><br>

            <label for="foto">Add the team logo:</label><br>
            <input type="file" name="foto" accept="image/*" class="foto"required><br><br>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
    

       <div class="footer">
          <div class="links">
            <a href="./leaguehome.php">Home</a>
            <a href="./aboutme.php">About Me</a>
            <a href="./help.php">Help</a>
          </div>

          <div class="footericon">
            <ion-icon name="logo-facebook"></ion-icon>
            <ion-icon name="logo-youtube"></ion-icon>
            <ion-icon name="logo-designernews"></ion-icon>
            <ion-icon name="logo-amazon"></ion-icon>
          </div>

          <div class="passages">
            <p>Project made By Godrine Manu</p>
            <p>&copy; 2025</p>
          </div>
       </div>




<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="../js/music.js" defer></script>
<script>
    window.addEventListener("load", () => {
      let audio = document.getElementById("bgMusic");
      if (audio) {
        audio.volume = 0.1; 
      }
    });
    setTimeout(() => {
        document.getElementById("ratingDisplay").style.visibility = "visible";
    }, 5000);
  </script>
  <script src="../js/team.js" defer></script>
</body>
</html>