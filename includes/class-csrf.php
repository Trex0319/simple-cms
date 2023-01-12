<?php

// static class
class CSRF
{
    // Generate CSRF token
    public static function generateToken( $prefix = '' )
    {
        if ( !isset( $_SESSION[ $prefix . '_csrf_token' ] ) ) {
            $_SESSION[ $prefix . '_csrf_token' ] = bin2hex( random_bytes(32) );
        }
    }

    public static function verifyToken( $formToken, $prefix = '' )
    {
        if ( isset( $_SESSION[ $prefix . '_csrf_token' ] ) && $formToken === $_SESSION[ $prefix . '_csrf_token'] ) {
            return true;
        }
        return false;
    }

    public static function getToken( $prefix = '' )
    {
        if ( isset( $_SESSION[ $prefix . '_csrf_token' ] ) ) {
            return $_SESSION[ $prefix . '_csrf_token' ];
        }
        return false;
    }

    public static function removeToken( $prefix = '' )
    {
        if ( isset( $_SESSION[ $prefix . '_csrf_token' ] ) ) {
            unset( $_SESSION[ $prefix . '_csrf_token' ] );
        }
    }
}