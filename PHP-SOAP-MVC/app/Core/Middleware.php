<?php



class Middleware
{
    public const MAP = [];


    public static function resolve($key)
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key];

        $result = (new $middleware[0])->handle();

        if (!$result) {
            header("Location: {$middleware[1]}");
            exit();
        }
    }

    public static function role($key): bool
    {
        if (!$key) {
            return false;
        }

        $middleware = static::MAP[$key];

        $result = (new $middleware[0])->handle();

        return $result;
    }

    public static function isOwner($id): bool
    {
        if (isset($_SESSION['userid'])) {
            if ($id == $_SESSION['userid']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
