<?php

// static class
class FormValidation
{
    /**
     * make sure email is unique
     */
    public static function checkEmailUniqueness( $email )
    {
        // check if email already used by another user
        $user = DB::connect()->select(
            'SELECT * FROM users where email = :email',
            [
                'email' => $email
            ]
        );

        // if user with the same email is already exists
        if ( $user ) {
            return 'Email is already in-use';
        }

        return false;
    }
    
    /**
     * do all the form validation
     */
    public static function validate( $data, $rules = [] )
    {
        $error = false;

        // do all the form validation
        // round 1 - email = $key, required = $condition
        foreach( $rules as $key => $condition ) 
        {
            switch( $condition ) 
            {
                case 'required':
                    // round 1 - $data[$key] = $_POST['email']
                    if ( empty( $data[$key] ) )
                    {
                        $error .= 'This field (' . $key . ') is empty<br />';
                    }
                    break;
                // make sure password is not empty and have at least 8 characters
                case 'password_check':
                    // step 1: make sure password field is not empty
                    if ( empty( $data[$key] ) )
                    {
                        $error .=  'This field (' . $key . ') is empty<br />';
                    } 
                    // step 2: make sure length is at least 8 characters
                    else if ( strlen( $data[$key] ) < 8 ) {
                        $error .= 'Password should be at least 8 characters';
                    }
                    break;
                // make sure password is match
                case 'is_password_match':
                    if ( $data['password'] !== $data['confirm_password'] ) {
                        $error .= 'Password do not match<br />';
                    }
                    break;

                case 'email_check':
                    if ( !filter_var( $data[$key], FILTER_VALIDATE_EMAIL ) )
                    {
                        $error .= "Email provided is invalid<br />";
                    }
                    break;
                // make sure login form csrf token is match
                case 'login_form_csrf_token':
                    // $data[$key] = $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'login_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";                        
                    }
                    break;
                // make sure signup form csrf token is match
                case 'signup_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'signup_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;
            }
        } // end - foreach

        return $error;
    }
}