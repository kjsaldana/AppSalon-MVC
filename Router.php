<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        session_start();

        $rutas_usuario = ['/citas', 'api/servicios', 'api/citas'];
        $rutas_admin = ['/admin', '/servicios', '/servicios/crear', '/servicios/actualizar', '/servicios/eliminar'];
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if (in_array($currentUrl, $rutas_usuario) && !isset($_SESSION['login'])) {
            header('location: /');
        }
        if (in_array($currentUrl, $rutas_admin) && !isset($_SESSION['admin'])) {
            header('location: /citas');
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();

        include_once __DIR__ . '/views/layout.php';
    }
}
