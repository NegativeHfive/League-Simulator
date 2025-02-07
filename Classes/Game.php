<?php
include_once "../includes/Database.php";  // Make sure to include your Database class

class Game {

    private $db;
    private $currentWeek;

    public function __construct($currentWeek = 1) {
        $this->db = new Database(); 
        $this->currentWeek = $currentWeek; // Assuming you have a Database class to connect to the DB
    }

    // Function to fetch all teams
    public function getAllTeams() {
        $query = "SELECT * FROM teams";
        return $this->db->run($query)->fetchAll(PDO::FETCH_ASSOC);
    }

     // Function to fetch a team by ID
   public function getTeamById($teamId) {
    $query = "SELECT * FROM teams WHERE ID = :ID";
    $params = [':ID' => $teamId];
    return $this->db->run($query, $params)->fetch(PDO::FETCH_ASSOC);
}

    


    public function getFixturesForWeek($weekNumber) {
        $query = "SELECT * FROM game WHERE week_number = :week_number";
        $parameters = [':week_number' => $weekNumber];
        
        return $this->db->run($query, $parameters)->fetchAll(PDO::FETCH_ASSOC);
    }

        // Function to fetch the match history to avoid repeating matchups
        public function getMatchHistory() {
            $query = "SELECT team1_id, team2_id FROM match_history";
            return $this->db->run($query)->fetchAll(PDO::FETCH_ASSOC);
        }


    // Function to check if two teams have played before
    private function hasPlayedBefore($team1_id, $team2_id) {
    $query = "SELECT COUNT(*) FROM game WHERE 
              ((hometeam = :team1_id AND awayteam = :team2_id) 
              OR (hometeam = :team2_id AND awayteam = :team1_id))";
    
    $params = [
        ':team1_id' => $team1_id,
        ':team2_id' => $team2_id
    ];

    $count = $this->db->run($query, $params)->fetchColumn();
    return $count > 0;  // If count > 0, the teams have already played
}


    // Function to simulate all games for the week and save results in the DB
    public function simulateWeekGames($fixtures) {
        foreach ($fixtures as $fixture) {
            $homeTeamID = $fixture['home'];
            $awayTeamID = $fixture['away'];

            // Simulate scores (random values for now)
            $homeScore = rand(0, 5);  
            $awayScore = rand(0, 5);

            // Points logic (adjust as needed)
            $homePoints = ($homeScore > $awayScore) ? 3 : (($homeScore == $awayScore) ? 1 : 0);
            $awayPoints = ($awayScore > $homeScore) ? 3 : (($homeScore == $awayScore) ? 1 : 0);

            // Save the match result into the database
            $this->saveGameResult($homeTeamID, $awayTeamID, $homeScore, $awayScore, $homePoints, $awayPoints);

            // Log this match into match history to avoid repetition
            $this->saveMatchHistory($homeTeamID, $awayTeamID);
        }
    }


    // Function to save a match into the match history
    private function saveMatchHistory($homeTeamID, $awayTeamID) {
        $query = "INSERT INTO match_history (team1_id, team2_id, match_date) VALUES (:team1_id, :team2_id, NOW())";
        $params = [
            ':team1_id' => $homeTeamID,
            ':team2_id' => $awayTeamID
        ];
        $this->db->run($query, $params);
    }

    public function checkFixturesExistForWeek($week) {
    $query = "SELECT * FROM game WHERE week_number = :week_number";
    $params = [':week_number' => $week];
    $result = $this->db->run($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    
    return count($result) > 0;  // Returns true if fixtures exist for the week, false if not
}

public function fixtureExists($week, $homeTeamID, $awayTeamID) {
    $query = "SELECT COUNT(*) FROM game WHERE week_number = :week_number 
              AND ((hometeam = :hometeam AND awayteam = :awayteam) 
              OR (hometeam = :awayteam AND awayteam = :hometeam))";
    $params = [
        ':week_number' => $week,
        ':hometeam' => $homeTeamID,
        ':awayteam' => $awayTeamID
    ];
    
    $count = $this->db->run($query, $params)->fetchColumn();
    return $count > 0;  // If count > 0, fixture already exists
}


public function generateWeeklyFixtures($week) {
    if ($this->checkFixturesExistForWeek($week)) {
        echo "<p>Fixtures already exist for Week {$week}.</p>";
        return [];
    }

    $teams = $this->getAllTeams();  
    $fixtures = [];
    $playedTeams = [];

    shuffle($teams); // Randomize the teams to get different matchups each week

    for ($i = 0; $i < count($teams); $i++) {
        for ($j = $i + 1; $j < count($teams); $j++) {
            $team1 = $teams[$i];
            $team2 = $teams[$j];

            // Check if they have already played in the current week or if the fixture already exists
            if (!$this->hasPlayedBefore($team1['ID'], $team2['ID']) &&
                !in_array($team1['ID'], $playedTeams) && 
                !in_array($team2['ID'], $playedTeams) &&
                !$this->fixtureExists($week, $team1['ID'], $team2['ID'])) {
                
                $fixtures[] = [
                    'hometeam' => $team1['ID'],
                    'awayteam' => $team2['ID'],
                    'week' => $week
                ];

                $playedTeams[] = $team1['ID'];
                $playedTeams[] = $team2['ID'];
            }
        }
    }

    if (!empty($fixtures)) {
        $this->saveFixturesForWeek($week, $fixtures);
    }

    echo "<pre>";
    print_r($fixtures);
    echo "</pre>";

    return $fixtures;
}


    public function simulateMatchScore($homeTeamID, $awayTeamID) {
    // Simulate the match score
    $homeScore = rand(0, 5);  
    $awayScore = rand(0, 5);

    return [
        'home_score' => $homeScore,
        'away_score' => $awayScore,
    ];
}

 public function saveGameResult($homeTeamID, $awayTeamID, $homeScore, $awayScore) {
        // Check if the result already exists for this match
        $query = "SELECT COUNT(*) FROM game WHERE hometeam = :hometeam 
                  AND awayteam = :awayteam AND week_number = :week_number";
        $params = [
            ':hometeam' => $homeTeamID,
            ':awayteam' => $awayTeamID,
            ':week_number' => $this->currentWeek  // Use the class property
        ];

        $count = $this->db->run($query, $params)->fetchColumn();

        if ($count > 0) {
            echo "<p>Result for this match already exists!</p>";
            return false;
        }

        // If the result doesn't exist, proceed with saving
        $homePoints = ($homeScore > $awayScore) ? 3 : (($homeScore == $awayScore) ? 1 : 0);
        $awayPoints = ($awayScore > $homeScore) ? 3 : (($homeScore == $awayScore) ? 1 : 0);

        $query = "INSERT INTO game (hometeam, awayteam, homescore, awayscore, homepoint, awaypoint, week_number) 
                  VALUES (:hometeam, :awayteam, :homescore, :awayscore, :homepoint, :awaypoint, :week_number)";
        $params = [
            ':hometeam' => $homeTeamID,
            ':awayteam' => $awayTeamID,
            ':homescore' => $homeScore,
            ':awayscore' => $awayScore,
            ':homepoint' => $homePoints,
            ':awaypoint' => $awayPoints,
            ':week_number' => $this->currentWeek  // Ensure this is set correctly
        ];

        $this->db->run($query, $params);
        return true;
    }


public function saveFixturesForWeek($week, $fixtures) {
    foreach ($fixtures as $fixture) {
        $homeTeamID = $fixture['hometeam'];
        $awayTeamID = $fixture['awayteam'];

        // Insert fixture into the game table
        $query = "INSERT INTO game (hometeam, awayteam, week_number) VALUES (:hometeam, :awayteam, :week_number)";
        $params = [
            ':hometeam' => $homeTeamID,
            ':awayteam' => $awayTeamID,
            ':week_number' => $week,
        ];
        
        $this->db->run($query, $params);
    }
}


}




?>