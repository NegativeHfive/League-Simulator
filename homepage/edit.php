<?php
include_once "../Classes/Team.php";



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teams</title>
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
                    <a href="#" class="editlink">Export Data</a>
                </div>
            </div>
        </div>

        <h1>Edit your Team</h1>


<table border="0">
    <thead>
        <tr class="headers">
            <th>Logo</th>
            <th>Team</th>
            <th>Continent</th>
            <th>Ratings</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            include_once "../Classes/Team.php";
            $team = new Team();
            $team->renderTeams();
        ?>
    </tbody>
</table>



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
<script src="../js/team.js" defer></script>
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
</body>
</html>