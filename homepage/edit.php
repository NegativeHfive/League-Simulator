<?php

include_once "../Classes/Team.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $teamName = htmlspecialchars($_POST['name']);
    $continent = htmlspecialchars($_POST['continent']);
    $ratings = rand(1,100);
    $foto = $_FILES['foto'];

    $fotoPath = '../uploads'.basename($foto['name']);
    $fotoSaved = move_uploaded_file($foto['tmp_name'],$fotoPath);

    if($fotoSaved){
        $team = new Team();
        $success = $team->insertTeam($teamName,$continent,$ratings,$fotoPath);

        if($success){
            echo "Team added successfully";
        }
        else{
            echo "Team not added";
        }
    }
    else{
        echo "Uploading the foto couldn't work";
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
                <div class="rankings">
                    <ion-icon name="podium"></ion-icon>
                    <a href="#" class="rankingslink">Rankings</a>
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

        <h1>Add a Team </h1>

        <div class="form">
             <form action="../homepage/edit.php" method="post" enctype="multipart/form-data">
                <label for="name" name="name">Your Team:</label><br>
                <input type="text" name="name"><br><br>
                <label for="continent" name="continent">Choose a continent:</label><br>
                <select name="continent" id="cars">
                    <option value="europe">Europe</option>
                    <option value="asia">Asia</option>
                    <option value="northamerica">North America</option>
                    <option value="southamerica">South America</option>
                    <option value="australia">Australia</option>
                    <option value="antartica">Antartica</option>
                </select><br><br>
                <label for="foto" name="foto">Add the team logo : </label><br>
                <input type="file" id="foto" name="foto" accept="image/*" required><br><br>

                <div class="ratings">
                    <h2>Your Ratings:</h2>
                    <p>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            echo $ratings; // Display the random rating
                        }
                        ?>
                    </p>
                </div>

                <button type="submit">Submit</button>
             </form>
        </div>


    





<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="../js/music.js" defer></script>
<script>
    window.addEventListener("load", () => {
      let audio = document.getElementById("bgMusic");
      if (audio) {
        audio.volume = 0.5; 
      }
    });
  </script>
</body>
</html>