<?php

class DB
{
    public $db;

    public function __construct() 
    {
    try {
            $this->db = new PDO(
                'mysql:host=devkinsta_db;dbname=Simple_CMS',
                'root',
                'r9wz9RSYYaTbjS7v'
            );
        } catch( PDOException $error ) {
            die("Database connection failed");
        }
    }

    public static function connect()
    {
        return new self();
    }

    public function select( $sql, $data = [], $is_list = false )
    {
        $statement = $this->db->prepare( $sql );
        $statement->execute( $data );
        if ( $is_list ) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function insert( $sql, $data = [] )
    {
        $statement = $this->db->prepare( $sql );
        $statement->execute( $data );
        return $this->db->lastInsertId();
    }

    public function update( $sql, $data = [] )
    {
        $statement = $this->db->prepare( $sql );
        $statement->execute( $data );
        return $statement->rowCount();
    }
    
    public function delete( $sql, $data = [] )
    {
        $statement = $this->db->prepare( $sql );
        $statement->execute( $data );
        return $statement->rowCount();
    }
}

