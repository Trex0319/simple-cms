<?php

class Post
{
    public static function getAllPosts()
    {
        return DB::Connect()->select(
            'SELECT * FROM posts ORDER BY id DESC',
            [],
            true
        );
    }

    public static function getPostByID( $post_id )
    {
        return DB::connect()->select(
            'SELECT * FROM posts WHERE id = :id',
            [
                'id' => $post_id
            ]
            );
    }

    public static function add( $title, $content, $user_id )
    {
        return DB::connect()->insert(
            'INSERT INTO posts (title, content, user_id) 
            VALUES (:title, :content, :user_id)',
            [
                'title' => $title,
                'content' => $content,
                'user_id' => $user_id
            ]
        );
    }

    public static function update( $id, $title, $content, $status )
    {
        $params = [
            'id' => $id,
            'title' => $title,
            'status' => $status,
            'content' => $content
        ];

        // update user data into the database
        return DB::connect()->update(
            'UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id',
            $params
        );
    }

    /**
    * Delete post
    */
    public static function delete( $post_id )
    {
        return DB::connect()->delete(
            'DELETE FROM posts where id = :id',
            [
                'id' => $post_id
            ]
        );
    }
}