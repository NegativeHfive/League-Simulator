<?php

include_once "../includes/Database.php"; 

class Ranking {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // deze functie zet maakt het rankiings
  public function updateRankings() {
    $query = "SELECT 
                g.hometeam, g.awayteam, g.homepoint, g.awaypoint,
                t1.name AS home_team_name, t1.foto AS home_foto,
                t2.name AS away_team_name, t2.foto AS away_foto
              FROM game g
              JOIN teams t1 ON g.hometeam = t1.ID
              JOIN teams t2 ON g.awayteam = t2.ID";
    
    $games = $this->db->run($query)->fetchAll(PDO::FETCH_ASSOC);
    
    $teamStats = []; // Array to store team data

    // het loopt door elke team en berekent hun punten.
    foreach ($games as $game) {
        $homeId = $game['hometeam'];
        $awayId = $game['awayteam'];
        $homeName = $game['home_team_name'];
        $awayName = $game['away_team_name'];
        $homeFoto = $game['home_foto'];
        $awayFoto = $game['away_foto'];
        
        if (!isset($teamStats[$homeId])) {
            $teamStats[$homeId] = ['name' => $homeName, 'foto' => $homeFoto, 'wins' => 0, 'losses' => 0, 'draws' => 0, 'points' => 0];
        }
        if (!isset($teamStats[$awayId])) {
            $teamStats[$awayId] = ['name' => $awayName, 'foto' => $awayFoto, 'wins' => 0, 'losses' => 0, 'draws' => 0, 'points' => 0];
        }

        // Update points
        $teamStats[$homeId]['points'] += $game['homepoint'];
        $teamStats[$awayId]['points'] += $game['awaypoint'];

        // Determine wins, losses, and draws
        if ($game['homepoint'] > $game['awaypoint']) {
            $teamStats[$homeId]['wins']++;
            $teamStats[$awayId]['losses']++;
        } elseif ($game['homepoint'] < $game['awaypoint']) {
            $teamStats[$awayId]['wins']++;
            $teamStats[$homeId]['losses']++;
        } else {
            $teamStats[$homeId]['draws']++;
            $teamStats[$awayId]['draws']++;
        }
    }

    foreach ($teamStats as $teamId => $stats) {
        $query = "SELECT * FROM ranking WHERE team = :team";
        $params = [':team' => $teamId];
        $existingTeam = $this->db->run($query, $params)->fetch(PDO::FETCH_ASSOC);

        if ($existingTeam) {
            $updateQuery = "UPDATE ranking 
                            SET points = :points, wins = :wins, losses = :losses, draws = :draws, 
                                team_name = :team_name, foto = :foto
                            WHERE team = :team";
            $updateParams = [
                ':points' => $stats['points'],
                ':wins' => $stats['wins'],
                ':losses' => $stats['losses'],
                ':draws' => $stats['draws'],
                ':team_name' => $stats['name'],
                ':foto' => $stats['foto'],
                ':team' => $teamId
            ];
            $this->db->run($updateQuery, $updateParams);
        } else {
            $insertQuery = "INSERT INTO ranking (team, team_name, foto, wins, losses, draws, points) 
                            VALUES (:team, :team_name, :foto, :wins, :losses, :draws, :points)";
            $insertParams = [
                ':team' => $teamId,
                ':team_name' => $stats['name'],
                ':foto' => $stats['foto'],
                ':wins' => $stats['wins'],
                ':losses' => $stats['losses'],
                ':draws' => $stats['draws'],
                ':points' => $stats['points']
            ];
            $this->db->run($insertQuery, $insertParams);
        }
    }

    
}



    // dit zorgt dat rankings worden 
    public function getRankings(){
        $sql = "SELECT * FROM ranking ORDER BY wins DESC, losses ASC";
        return $this->db->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}





?>
