<?php

include_once "../Classes/Team.php";


if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];
    $realteam = new Team();
    $team = $realteam->selectTeamById($ID);

    if (!$team) {
        die("Team not found!");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $ratings = $_POST['ratings'];
    $continent = $_POST['continent'];
    $foto = $_POST['foto']; // Ideally, handle file uploads properly

    $realteam->updateTeam($ID, $name, $ratings, $continent, $foto);
    header("Location: ../homepage/edit.php"); // Redirect after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit team</title>
    <link rel="stylesheet" href="../css/edit.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <audio id="bgMusic" src="../audio/CITY by Louis Culture.mp3" autoplay loop></audio>
</head>
<body>

    <div class="editform">
        <h1>Edit <?php   echo $team['name']?></h1>
        <form method="POST">
            <div class="formlist">
            <label for="name">Team Name</label><br>
            <input type="text" name="name" value="<?= htmlspecialchars($team['name']) ?>" required><br><br>
            <label for="ratings">Ratings</label><br>
            <input type="number" name="ratings" value="<?= $team['ratings'] ?>" required><br><br>
            <label for="continent">Continent</label><br>
            <input type="text" name="continent" value="<?= htmlspecialchars($team['continent']) ?>" required><br><br>
            <label for="fotourl">Foto Url</label><br>
            <input type="text" id="foto" name="foto" value="<?php echo htmlspecialchars($team['foto']); ?>"><br><br>
            <button type="submit">Update Team</button>
            </div>
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


