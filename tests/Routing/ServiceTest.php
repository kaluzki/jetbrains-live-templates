<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\Routing;

/**
 * @see Service
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array[]
     */
    public function providerInvokeWithParams()
    {
        $func    = function($optA = null, $optB = 'string', $optC = 1, $reqA, $reqB) {return func_get_args();};
        $method = [$this, 'method'];

        return [
            'Parameter $service is not callable' => [
                'expected' => new \InvalidArgumentException('Parameter $service is not callable'),
                'service'  => null,
                'vars'     => [],
                'params'   => [],
            ],
            'Missing required argument reqA' => [
                'expected' => new \RuntimeException("Missing required argument 'reqA'"),
                'service'  => $func,
                'vars'     => [],
                'params'   => [],
            ],
            'Missing required argument reqB' => [
                'expected' => new \RuntimeException("Missing required argument 'reqB'"),
                'service'  => $func,
                'vars'     => [],
                'params'   => ['reqA' => 'reqA'],
            ],
            'function: all required arguments are set' => [
                'expected' => [null, 'string', 1, 'reqA', 'reqB'],
                'service'  => $func,
                'vars'     => [],
                'params'   => ['reqB' => 'reqB', 'reqA' => 'reqA'],
            ],
            'function: lookup in defaults for a required argument' => [
                'expected' => [null, 'string', 1, 'reqA-default', 'reqB'],
                'service'  => $func,
                'vars'     => ['defaults' => ['reqA' => 'reqA-default']],
                'params'   => ['reqB' => 'reqB'],
            ],
            'function: defaults overwrite signature, but not explicit arguments' => [
                'expected' => ['optA-explicit', 'optB', 1, 'reqA-explicit', 'reqB-default'],
                'service'  => $func,
                'vars'     => ['defaults' => ['reqB' => 'reqB-default', 'optB' => 'optB', 'optA' => 'optA', 'reqA' => 'reqA-default']],
                'params'   => ['reqA' => 'reqA-explicit', 'optA' => 'optA-explicit'],
            ],
            'method: all required arguments are set' => [
                'expected' => [null, 'string', 1, 'reqA', 'reqB'],
                'service'  => $method,
                'vars'     => [],
                'params'   => ['reqB' => 'reqB', 'reqA' => 'reqA'],
            ],
            'method: lookup in defaults for a required argument' => [
                'expected' => [null, 'string', 1, 'reqA-default', 'reqB'],
                'service'  => $method,
                'vars'     => ['defaults' => ['reqA' => 'reqA-default']],
                'params'   => ['reqB' => 'reqB'],
            ],
            'method: defaults overwrite signature, but not explicit arguments' => [
                'expected' => ['optA-explicit', 'optB', 1, 'reqA-explicit', 'reqB-default'],
                'service'  => $method,
                'vars'     => ['defaults' => ['reqB' => 'reqB-default', 'optB' => 'optB', 'optA' => 'optA', 'reqA' => 'reqA-default']],
                'params'   => ['reqA' => 'reqA-explicit', 'optA' => 'optA-explicit'],
            ],
            'invokable object: all required arguments are set' => [
                'expected' => [null, 'string', 1, 'reqA', 'reqB'],
                'service'  => $this,
                'vars'     => [],
                'params'   => ['reqB' => 'reqB', 'reqA' => 'reqA'],
            ],
            'invokable object: lookup in defaults for a required argument' => [
                'expected' => [null, 'string', 1, 'reqA-default', 'reqB'],
                'service'  => $this,
                'vars'     => ['defaults' => ['reqA' => 'reqA-default']],
                'params'   => ['reqB' => 'reqB'],
            ],
            'invokable object: defaults overwrite signature, but not explicit arguments' => [
                'expected' => ['optA-explicit', 'optB', 1, 'reqA-explicit', 'reqB-default'],
                'service'  => $this,
                'vars'     => ['defaults' => ['reqB' => 'reqB-default', 'optB' => 'optB', 'optA' => 'optA', 'reqA' => 'reqA-default']],
                'params'   => ['reqA' => 'reqA-explicit', 'optA' => 'optA-explicit'],
            ],
        ];
    }

    /**
     * @dataProvider providerInvokeWithParams
     * @covers       Service::invokeWithParams
     * @covers       Service::__construct
     *
     * @param \Exception|mixed $expected
     * @param \Closure         $service
     * @param array            $vars
     * @param array            $params
     */
    public function testInvokeWithParams($expected, $service, array $vars, array $params)
    {
        if ($expected instanceof \Exception) {
            $this->setExpectedException(get_class($expected), $expected->getMessage());
        }
        $this->assertEquals($expected, (new Service($service, $vars))->invokeWithParams($params));
    }

    /**
     * @covers Service::__invoke
     */
    public function testInvoke()
    {
        $service = new Service(
            function($opt = null, $req) {return func_get_args();},
            ['defaults' => ['req' => 'req-default', 'opt' => 'default-overwritten']]
        );
        $this->assertEquals(['default-overwritten', 'req-default'], $service());
        $this->assertEquals(['opt-value', 'req-default'], $service('opt-value'));
        $this->assertEquals(['opt-value', 'req-value'], $service('opt-value', 'req-value'));
    }

    /**
     * @param null   $optA
     * @param string $optB
     * @param int    $optC
     * @param        $reqA
     * @param        $reqB
     *
     * @return array
     */
    public function method($optA = null, $optB = 'string', $optC = 1, $reqA, $reqB)
    {
        return func_get_args();
    }

    /**
     * @param null   $optA
     * @param string $optB
     * @param int    $optC
     * @param        $reqA
     * @param        $reqB
     *
     * @return array
     */
    public function __invoke($optA = null, $optB = 'string', $optC = 1, $reqA, $reqB)
    {
        return func_get_args();
    }
}