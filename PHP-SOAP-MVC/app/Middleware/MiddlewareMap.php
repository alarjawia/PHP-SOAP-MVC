<?php



class MiddlewareMap extends Middleware
{
    public const MAP = [
        'guest' => [GuestMiddleware::class, '/'],
        'auth' => [AuthMiddleware::class, '/'],
    ];
}
