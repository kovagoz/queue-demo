<?php

namespace App\Http;

use App\Core\Application;
use App\Contracts\Http\Router as RouterContract;
use App\Contracts\Http\Request as RequestContract;
use App\Contracts\Http\Dispatcher as DispatcherContract;

class Dispatcher implements DispatcherContract
{
    /**
     * Create new dispatcher instance.
     *
     * @param RouterContract $router
     * @param Application    $app
     */
    public function __construct(RouterContract $router, Application $app)
    {
        $this->router = $router;
        $this->app    = $app;
    }

    /**
     * Dispatch the request.
     *
     * @param RequestContract $request
     * @return void
     */
    public function dispatch(RequestContract $request)
    {
        $this->loadRoutes();

        $controller = $this->router->match($request);

        $response = call_user_func($controller, $request, $this->app);

        return new Response($response);
    }

    /**
     * Load the user defined routes.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $router = $this->router;

        call_user_func(function () use ($router) {
            include __DIR__ . '/routes.php';
        });
    }
}
