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



    
}
















?>