<?php


class AuthMiddleware
{
    public function handle()
    {

        if (!isset($_SESSION['userid'])) {
            return false;
        } else {
            return true;
        }
    }
}
