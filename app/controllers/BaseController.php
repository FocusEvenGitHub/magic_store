<?php

namespace App\Controllers;

class BaseController {
    public function render(string $view, array $data = [])
    {
        extract($data);
        require_once __DIR__ . "/../Views/{$view}.php";
    }

    public function redirect(string $route)
    {
        header("Location: /{$route}");
        exit();
    }

    public function setFlash(string $message, string $type = 'success')
    {
        $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
    }

    public function getFlash()
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
}
