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
 * @see Router
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array[]
     */
    public function providerInvoke()
    {
        return [
            'service is not callable' => [
                'expected' => new Routing\Exception\InvalidParameterException("service 'my service' is not callable"),
                'services' => new \ArrayObject(['my service' => 'string']),
                'method'   => null,
                'path'     => null,
            ],
            'not traversable' => [
                'expected' => new Routing\Exception\InvalidParameterException('Parameter $services is not traversable'),
                'services' => null,
                'method'   => null,
                'path'     => null,
            ],
            'empty services' => [
                'expected' => new Routing\Exception\ResourceNotFoundException('No routes found for ""'),
                'services' => [],
                'method'   => null,
                'path'     => null,
            ],
            'method' => [
                'expected' => new Routing\Exception\MethodNotAllowedException([]),
                'services' => ['POST /' => function() {}],
                'method'   => 'GET',
                'path'     => '/',
            ],
            '$_route is also passed to the service => GET' => [
                'expected' => ['first', 'second', ['GET']],
                'services' => [
                    'get|post|delete|put /{bar}/{foo}' => function($foo, Routing\Route $_route, $bar) {
                        return [$bar, $foo, $_route->getMethods()];
                    }
                ],
                'method'   => 'GET',
                'path'     => '/first/second',
            ],
            '$_route is also passed to the service => DELETE' => [
                'expected' => ['first', 'second', ['DELETE']],
                'services' => [
                    'get|post|delete|put /{bar}/{foo}' => function(Routing\Route $_route, $foo, $bar) {
                        return [$bar, $foo, $_route->getMethods()];
                    }
                ],
                'method'   => 'DELETE',
                'path'     => '/first/second',
            ],
        ];
    }

    /**
     * @dataProvider providerInvoke
     * @covers       Router::__invoke
     * @covers       Router::__construct
     *
     * @param \Exception|mixed $expected
     * @param \Closure[]       $services
     * @param string           $method
     * @param string           $path
     */
    public function testInvoke($expected, $services, $method, $path)
    {
        if ($expected instanceof \Exception) {
            $this->setExpectedException(get_class($expected), $expected->getMessage());
        }
        $router = new Router($services);
        $this->assertEquals($expected, $router($method, $path));
    }
}