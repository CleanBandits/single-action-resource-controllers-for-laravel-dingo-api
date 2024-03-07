<?php

namespace CleanBandits\SingleActionResourceControllersForLaravelDingoApi;

class ResourceRegistrar
{
    public function __construct(
        private readonly string $name,
        private array           $action,
        private readonly Router $router,
    )
    {
    }

    public function __invoke(): void
    {
        $resourceTypes = [
            'index' => ['GET', 'HEAD'],
            'store' => ['POST'],
            'show' => ['GET', 'HEAD'],
            'update' => ['PUT', 'PATCH'],
            'destroy' => ['DELETE']
        ];
        $resource = $this->action['uses'];
        foreach ($resourceTypes as $type => $methods) {
            $this->action['uses'] = 'App\\Http\\Controllers\\' . $resource . '\\' . ucfirst($type) . 'Controller';
            if (class_exists($this->action['uses'])) {
                $this->router->addRoute($methods, $this->name($type), $this->action);
            }
        }
    }

    private function name(string $type): string
    {
        return in_array($type, ['show', 'update', 'destroy']) ? $this->name . str($this->name)->camel()->snake()->wrap('/{', '}') : $this->name;
    }
}
