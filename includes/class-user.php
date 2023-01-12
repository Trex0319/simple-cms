<?php

class User
{
    public static function getAllUsers()
    {
        return DB::Connect()->select(
            'SELECT * FROM users ORDER BY id DESC',
            [],
            true
        );
    }

    public static function getUserByID( $user_id )
    {
        return DB::connect()->select(
            'SELECT * FROM users WHERE id = :id',
            [
                'id' => $user_id
            ]
            );
    }

    public static function add( $name, $email, $role, $password )
    {
        return DB::connect()->insert(
            'INSERT INTO users (name , email, role, password) 
            VALUES (:name, :email, :role, :password)',
            [
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'password' => password_hash( $password, PASSWORD_DEFAULT )
            ]
        );
    }

    public static function update( $id, $name, $email, $role, $password = null )
    {
        $params = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'role' => $role
        ];

        // if password is not will
        if ( $password ) {
            $params['password'] = password_hash( $password, PASSWORD_DEFAULT );
        }

        // update user data into the database
        return DB::connect()->update(
            'UPDATE users SET name = :name, email = :email,' . ( $password ? ' password = :password,' : '' ) . ' role = :role WHERE id = :id',
            $params
        );
    }

    /**
    * Delete user
    */
    public static function delete( $user_id )
    {
        return DB::connect()->delete(
            'DELETE FROM users where id = :id',
            [
                'id' => $user_id
            ]
        );
    }
}