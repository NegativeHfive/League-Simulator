<?php
session_start();
//session_destroy();  // Make sure session is started

include_once "../includes/Database.php";
include_once "../Classes/Game.php";  // Include the Game class

$currentWeek = null;

$game = new Game();  // Create a new game object

// Get the current week from the URL, defaulting to week 1 if not provided
$currentWeek = isset($_GET['week']) && is_numeric($_GET['week']) && $_GET['week'] > 0 ? (int)$_GET['week'] : 1;

// Ensure the week is not less than 1
if ($currentWeek < 1) {
    $currentWeek = 1;
}

$game->generateWeeklyFixtures($currentWeek);

// Get the fixtures for this week
$fixtures = $game->getFixturesForWeek($currentWeek);

// Handle form submission for simulating or saving results
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['simulate'])) {
        // Simulate match score without saving
        $homeTeamID = $_POST['home_team_id'];
        $awayTeamID = $_POST['away_team_id'];
        
        $simulatedResult = $game->simulateMatchScore($homeTeamID, $awayTeamID);
        $homeScore = $simulatedResult['home_score'];
        $awayScore = $simulatedResult['away_score'];

        // Store the simulated score in session to persist it across page reloads
        $_SESSION['simulated_results'][$homeTeamID][$awayTeamID] = [
            'home_score' => $homeScore,
            'away_score' => $awayScore,
        ];

        // Show the simulated result to the user
        echo "<p>Simulated result: Home Team {$homeScore} - Away Team {$awayScore}</p>";
    }
    
    if (isset($_POST['save'])) {
        // Save match result to the database
        $homeTeamID = $_POST['home_team_id'];
        $awayTeamID = $_POST['away_team_id'];

        // Check if simulated result exists for this match
        if (isset($_SESSION['simulated_results'][$homeTeamID][$awayTeamID])) {
            $simulatedResult = $_SESSION['simulated_results'][$homeTeamID][$awayTeamID];
            $homeScore = $simulatedResult['home_score'];
            $awayScore = $simulatedResult['away_score'];

            // Debug: Verify that the scores are correct
            echo "<p>Saving result for match: Home {$homeScore} - Away {$awayScore}</p>";

            // Call the save function from the Game class
            if ($game->saveGameResult($homeTeamID, $awayTeamID, $homeScore, $awayScore,$currentWeek)) {
                echo "<p>Game result saved: Home Team {$homeScore} - Away Team {$awayScore}</p>";
                // Clear the simulated result from the session after saving it
                unset($_SESSION['simulated_results'][$homeTeamID][$awayTeamID]);
            } else {
                echo "<p>Error saving the result. Please try again.</p>";
            }
        } else {
            echo "<p>No simulated result found for this match.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixtures for Week <?php echo $currentWeek; ?></title>
    <link rel="stylesheet" href="../css/hometeam.css">
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
                    <a href="#" class="rankingslink">Rankings</a>
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

<div class="week">
    <!-- Link to previous week -->
    <a href="?week=<?php echo $currentWeek - 1; ?>">
        <ion-icon name="arrow-back-outline" class="lastweek"></ion-icon>
    </a>

    <h2>Fixtures for Week <?php echo $currentWeek; ?></h2>

    <!-- Link to next week -->
    <a href="?week=<?php echo $currentWeek + 1; ?>">
        <ion-icon name="arrow-forward-outline" class="nextweek"></ion-icon>
    </a>
</div>

<h3>Matches for Week <?php echo $currentWeek; ?>:</h3>

<?php
if ($fixtures && count($fixtures) > 0) {
    foreach ($fixtures as $fixture) {
        $homeTeam = $game->getTeamById($fixture['hometeam']);
        $awayTeam = $game->getTeamById($fixture['awayteam']);
        
        if ($homeTeam && $awayTeam) {
            echo "<div class='match-form'>";
            echo "<form method='POST'>";
            echo "<div class='gameday'>";
            echo "<img src='{$homeTeam['foto']}' width='50' height='50' class='foto'>";
            echo "<h3>{$homeTeam['name']} vs {$awayTeam['name']}</h3>";
            echo "<img src='{$awayTeam['foto']}' width='50' height='50' class='foto1'></div>";

            echo "<input type='hidden' name='home_team_id' value='{$homeTeam['ID']}'>";
            echo "<input type='hidden' name='away_team_id' value='{$awayTeam['ID']}'>";

            // Display simulated score if available in session
            if (isset($_SESSION['simulated_results'][$homeTeam['ID']][$awayTeam['ID']])) {
                $simulatedScore = $_SESSION['simulated_results'][$homeTeam['ID']][$awayTeam['ID']];
                echo "<p class='score'>{$simulatedScore['home_score']} - {$simulatedScore['away_score']}</p>";
            }

            // Simulate Button
            echo "<button type='submit' name='simulate'>Simulate Score</button>";

            // Save Button
            echo "<button type='submit' name='save'>Save Result</button>";

            echo "</form>";
            echo "</div>"; // End match-form div
        }
    }
} else {
    echo "<p>No fixtures available for this week.</p>";
}
?>

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
