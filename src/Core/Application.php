<?php
/**
 * Class Application
 *
 * The core application class responsible for bootstrapping and managing the lifecycle of the application.
 */
namespace DevinciIT\Modulr\Core;
use DevinciIT\Modulr\Http\Router;
use DevinciIT\Modulr\Http\Response;
use DevinciIT\Modulr\Http\Request;
use DevinciIT\Modulr\Container\ServiceContainer;
use DevinciIT\Modulr\Container\Container;

class Application
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var ServiceContainer
     */
    protected ServiceContainer $container;

    /**
     * @var Router
     */
    protected Router $router;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * Application constructor.
     * Initializes core services.
     */
    public function __construct()
    {
        $this->config = new Config();
        $this->container = new ServiceContainer();
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * Bootstraps the application.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Example: Register a default route
        $this->router->add('/', function () {
            return '<h1>Welcome to Modulr!</h1>';
        });
    }

    /**
     * Run the application (dispatch route and send response).
     *
     * @return void
     */
    public function run(): void
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $content = $this->router->dispatch($path);
        if ($content === null) {
            $content = '<h1>404 Not Found</h1>';
            $this->response->send($content, 404);
        } else {
            $this->response->send($content);
        }
    }

    /**
     * Get the application config.
     *
     * @return Config
     */
    public function config(): Config
    {
        return $this->config;
    }

    /**
     * Get the service container.
     *
     * @return ServiceContainer
     */
    public function container(): ServiceContainer
    {
        return $this->container;
    }

    /**
     * Get the router.
     *
     * @return Router
     */
    public function router(): Router
    {
        return $this->router;
    }

    /**
     * Get the request object.
     *
     * @return Request
     */
    public function request(): Request
    {
        return $this->request;
    }

    /**
     * Get the response object.
     *
     * @return Response
     */
    public function response(): Response
    {
        return $this->response;
    }
}
