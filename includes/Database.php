<?php

class Database{

    public $pdo;
    public $statement;

    //constructor
    public function __construct($db='league',$host='localhost:3310',$user='root',$pwd=''){
        //try en catch voor meer duidelijkheid met fouten 
        try{
            $this->pdo = new PDO("mysql:host=$host;dbname=$db",$user,$pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            echo "Connected to ".$db."succesfully";
        }
        catch(PDOException $e){
            die('Connection error :'.$e->getMessage());
        }
    }

    // het run functie 
    public function run($query,$params = null){
        try{
            $this->statement = $this->pdo->prepare($query);
            if($params != null){
                $this->statement->execute($params);
            }
            else{
                $this->statement->execute();
            }
            return $this->statement;
        }
        catch(PDOException $e){
            echo "Execution error : ".$e->getMessage();
            return false;
        }
    }


}



?>