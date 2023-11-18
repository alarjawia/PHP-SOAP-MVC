<?php


class Validations
{

    public static function addError(string $message): void
    {
        $_SESSION['errors'][] = $message;
    }

    public static function isErrors(): bool
    {
        if (isset($_SESSION['errors'])) {
            if (count($_SESSION['errors']) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getErrors(): array
    {
        if (isset($_SESSION['errors'])) {
            $erros = $_SESSION['errors'];
        } else {
            $erros = [];
        }
        unset($_SESSION['errors']);
        return $erros;
    }

    public static function addData(array $data): void
    {
        $_SESSION['data'] = $data;
    }

    public static function showData($name)
    {
        if (isset($_SESSION['data'][$name])) {
            $data = $_SESSION['data'][$name];
            unset($_SESSION['data'][$name]);
            echo $data;
        }
    }
}
