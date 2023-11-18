<?php


class View
{

    public static function load($view_name, $view_data = [])
    {

        $file = VIEWS . $view_name . '.php';
        if (file_exists($file)) {
            $view_data = self::htmlSC($view_data);
            extract($view_data);
            ob_start();
            require($file);
            ob_end_flush();
        } else {
            echo "This view: " . $view_name . "dose not exist";
        }
    }

    public static function htmlSC(array $datas): array
    {
        $view_data = [];

        foreach ($datas as $key => $value) {
            if (is_array($value)) {
                // If the value is an array, recursively apply htmlspecialchars
                $view_data[$key] = self::htmlSC($value);
            } else {
                // If the value is not an array, apply htmlspecialchars
                $view_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }

        return $view_data;
    }
}
