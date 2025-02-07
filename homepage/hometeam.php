<?php
include_once "../includes/Database.php";
include_once "../Classes/Game.php";  // Include the Game class

$game = new Game();  // Create a new game object

// Get the current week from the URL, defaulting to week 1 if not provided
$currentWeek = isset($_GET['week']) ? (int)$_GET['week'] : 1;

// Ensure the week is not less than 1
if ($currentWeek < 2) {
    $currentWeek = 1;
}

$game->generateWeeklyFixtures($currentWeek);

// Get the fixtures for this week
$fixtures = $game->getFixturesForWeek($currentWeek);
$fixtures = $game->getFixturesForWeek($currentWeek);
echo "<pre>";
print_r($fixtures); // Check if any fixtures are returned for this week
echo "</pre>";

// Handle form submission for simulating or saving results
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['simulate'])) {
        // Simulate match score without saving
        $homeTeamID = $_POST['home_team_id'];
        $awayTeamID = $_POST['away_team_id'];
        
        $simulatedResult = $game->simulateMatchScore($homeTeamID, $awayTeamID);
        $homeScore = $simulatedResult['home_score'];
        $awayScore = $simulatedResult['away_score'];
        
        echo "<p>Simulated result: Home Team {$homeScore} - Away Team {$awayScore}</p>";
    }
    
    if (isset($_POST['save'])) {
        // Save match result to the database
        $homeTeamID = $_POST['home_team_id'];
        $awayTeamID = $_POST['away_team_id'];
        
        // Get the simulated result (or you can use actual scores)
        $simulatedResult = $game->simulateMatchScore($homeTeamID, $awayTeamID);
        $homeScore = $simulatedResult['home_score'];
        $awayScore = $simulatedResult['away_score'];
        
        // Save to the database
        $game->saveGameResult($homeTeamID, $awayTeamID, $homeScore, $awayScore);
        
        echo "<p>Game result saved: Home Team {$homeScore} - Away Team {$awayScore}</p>";
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
        $homeTeam = $game->getTeamById($fixture['home']);
        $awayTeam = $game->getTeamById($fixture['away']);
        
        if ($homeTeam && $awayTeam) {
            echo "<form method='POST'>";
            echo "<h3>{$homeTeam['name']} vs {$awayTeam['name']} - Week: {$fixture['week']}</h3>";
            echo "<input type='hidden' name='home_team_id' value='{$homeTeam['ID']}'>";
            echo "<input type='hidden' name='away_team_id' value='{$awayTeam['ID']}'>";
            
            // Simulate Button
            echo "<button type='submit' name='simulate'>Simulate Score</button>";

            // Save Button
            echo "<button type='submit' name='save'>Save Result</button>";
            
            echo "</form>";
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