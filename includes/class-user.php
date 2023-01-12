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
}