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
        echo "<tr class='fade'>
            <td><img src='{$team['foto']}' width='50' height='50' class='foto'></td>
            <td class='team'>{$team['name']}</td>
            <td class='team'>{$team['continent']}</td>
            <td class='team'>{$team['ratings']}</td>
            <td>
                <a href='edit_team.php?ID={$team['ID']}' class='edit-btn'>Edit</a>
                <a href='delete_team.php?ID={$team['ID']}' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a>
            </td>
        </tr>";
    }
}


    // update a team
    public function updateTeam($ID,$name,$ratings,$continent,$foto){
        $query = "UPDATE teams SET name=:name,ratings=:ratings,continent=:continent,foto=:foto WHERE ID = :ID";
        $parameters = [
            ':ID'=>$ID,
            ':name'=>$name,
            'ratings'=>$ratings,
            ':continent'=>$continent,
            ':foto'=>$foto
        ];

        return $this->db->run($query,$parameters);
    }

    //select a team by its ID
    public function selectTeamById($ID){
        $query = "SELECT * FROM teams WHERE ID = :ID";
        return $this->db->run($query, [':ID' => $ID])->fetch(PDO::FETCH_ASSOC);
    }

    //delete a team 
    public function deleteTeam($ID){
        $query= "DELETE FROM teams WHERE ID = :ID";
        $parameters = [":ID"=>$ID];
        return $this->db->run($query,$parameters);
    }


    
}
















?>