<?php

include_once "../includes/Database.php";

class Team{


    private $db;

    //constructor
    public function __construct(){
        $this->db = new Database();
    }

    //het tovoegen van nieuwe teams 
    public function insertTeam($name,$ratings,$continent,$foto){
        $query = "INSERT INTO teams (name,ratings,continent,foto) VALUES (:name,:ratings,:continent,:foto)";
        $parameters = [
            ':name'=>$name,
            ':ratings'=>$ratings,
            ':continent'=>$continent,
            'foto'=>$foto
        ];
        return $this->db->run($query,$parameters);
    }

    //fetch everything from the table teams
    public function selectAllTeams(){
        $query = "SELECT * FROM teams";
        return $this->db->run($query)->fetchAll();
    }

    //render all the teams 
    public function renderTeams(){
    $teams = $this->selectAllTeams();
    
    foreach ($teams as $team) {
        echo "<tr>
            <td><img src='{$team['foto']}' width='50' height='50' class='foto'></td>
                <td class='team'>{$team['name']}</td>
                <td>{$team['continent']}</td>
                <td>{$team['ratings']}</td>
              </tr>";
    }
}



    
}
















?>