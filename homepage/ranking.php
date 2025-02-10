<?php
include "../Classes/Ranking.php";

$ranking = new Ranking();
$ranking->updateRankings();
$rankings = $ranking->getRankings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rankings</title>
    <link rel="stylesheet" href="../css/ranking.css">
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

    <div class="ranking-container">
        <h2>League Rankings</h2>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Team</th>
                    <th>Name</th>
                    <th>Wins</th>
                    <th>Losses</th>
                    <th>Draws</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $position = 1;
                foreach ($rankings as $rank) {
                    echo "<tr>
                            <td>{$position}</td>
                            <td><img src='{$rank['foto']}'></td>
                            <td>{$rank['team_name']}</td>
                            <td>{$rank['wins']}</td>
                            <td>{$rank['losses']}</td>
                            <td>{$rank['draws']}</td>
                            <td>{$rank['points']}</td>
                          </tr>";
                    $position++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../js/music.js" defer></script>
    <script src="../js/homepage.js" defer></script>
    <script>
        window.addEventListener("load", () => {
          let audio = document.getElementById("bgMusic");
          if (audio) {
            audio.volume = 0.1; 
          }
        });
    </script>
</body>
</html>
