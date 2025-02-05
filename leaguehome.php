<?php







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Simulator</title>
    <link rel="stylesheet" href="./css/leaguehome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <audio id="audio" type="audio/mp3" src="./audio/CITY by Louis Culture.mp3" autoplay loop ></audio>

</head>
<body>

      <div class="navbar">
            <h2>negative.</h2>
            <div class="icons">
                <div class="home">
                    <ion-icon name="home"></ion-icon>
                    <a href="#">Home</a>
                </div>
                <div class="about">
                    <ion-icon name="man"></ion-icon>
                    <a href="#">About Me</a>
                </div>
                <div class="help">
                    <ion-icon name="help-circle"></ion-icon>
                    <a href="#">Help</a>
                </div>
            </div>
        </div>

       <div class="menu">
             <div class="title">
                <h2 class="league">LEAGUE</h2>
                <h1>Simulator</h1>
                <a href="#" class="play">PLAY</a>
                <div class="text">
                    A fun and interactive football game where you can create your own league! Add teams, remove teams, and watch them compete for glory. Each team battles it out on the field, and a dynamic ranking table updates based on wins, losses, goals, and goal difference. You can even export your league to track progress or share with friends. Enjoy the thrill of managing your own football championship—have fun and play your way to victory!
                </div>
            </div>

            <div class="img">
                <img class="mbappe" src="./images/French-soccer-player-Kylian-Mbappe-FIFA-World-Cup-December-10-2022-Photoroom.png" alt="">
            </div>
       </div>


       <div class="footer">
          <div class="links">
            <a href="#">Home</a>
            <a href="#">About Me</a>
            <a href="#">Help</a>
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
<script src="./js/leaguehome.js"  defer></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    window.addEventListener("load", () => {
      let audio = document.getElementById("audio");
      if (audio) {
        audio.volume = 0.1;  // Set the volume to 10% of the maximum volume
      }
    });
  </script>
</body>
</html>