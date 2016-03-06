<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\Routing;

use Symfony\Component\Routing;

/**
 * usage:
 *
 * call_user_func(new Router(['GET|POST /api/{param}' => function($param, $method = null) {}], 'GET', '/api/value1')
 */
class Router
{
    /**
     * @var Routing\RouteCollection
     */
    protected $collection;

    /**
     * @param \Closure[]|Service[]|\Traversable $services Callable services indexed by a route
     *
     * @throws Routing\Exception\InvalidParameterException
     */
    public function __construct($services)
    {
        $this->collection = new Routing\RouteCollection();
        if (!is_array($services) && !$services instanceof \Traversable) {
            throw new Routing\Exception\InvalidParameterException('Parameter $services is not traversable');
        }
        foreach ($services as $locator => $service) {
            if (!is_callable($service)) {
                throw new Routing\Exception\InvalidParameterException("service '{$locator}' is not callable");
            }

            $service = $service instanceof Service ? $service : new Service($service);
            list($methods, $path) = explode(' ', $locator, 2);

            foreach (explode('|', $methods) as $method) {
                $route = new Routing\Route(
                    $path,
                    array_merge(['_service' => $service], $service->defaults),
                    $service->requirements,
                    $service->options,
                    $service->host,
                    $service->schemes,
                    $method
                );
                $this->collection->add("$method $path", $route);
            }
        }
    }

    /**
     * Delegates the call to a registered service
     *
     * @param string $method
     * @param string $path
     *
     * @throws Routing\Exception\ResourceNotFoundException
     * @throws Routing\Exception\MethodNotAllowedException
     *
     * @return mixed
     */
    public function __invoke($method, $path)
    {
        $matcher = new Routing\Matcher\UrlMatcher($this->collection, new Routing\RequestContext('', $method));
        $params  = $matcher->match($path);
        /** @var Service $service */
        $service          = $params['_service'];
        $params['_route'] = $this->collection->get($params['_route']);
        return $service->invokeWithParams($params);
    }
}