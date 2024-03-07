<?php

namespace CleanBandits\SingleActionResourceControllersForLaravelDingoApi;

use \Dingo\Api\Routing\Router as DingoRouter;

class Router extends DingoRouter
{
    public function __construct(DingoRouter $router)
    {
        parent::__construct($router->adapter, $router->exception, $router->container, $router->domain, $router->prefix);
    }

    public function singleActionResource(string $name, array $action): void
    {
        (new ResourceRegistrar($name, $action, $this))();
    }
}
