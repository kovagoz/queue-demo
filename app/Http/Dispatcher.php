<?php

namespace App\Http;

use App\Core\Application;

class Dispatcher
{
    public function __construct(Router $router, Application $app)
    {
        $this->router = $router;
        $this->app    = $app;
    }

    public function dispatch(Request $request)
    {
        $controller = $this->router->match($request);

        $response = call_user_func($controller, $request, $app);

        return new Response($response);
    }
}
