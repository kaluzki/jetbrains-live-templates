<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\Routing;

/**
 * @property-read string[] $requirements
 * @property-read string[] $defaults
 * @property-read string[] $options
 * @property-read string   $host
 * @property-read string[] $schemes
 */
class Service
{
    /**
     * @var \Closure
     */
    protected $service;

    /**
     * @var int[]
     */
    private $_positions = [];

    /**
     * @var array
     */
    protected $vars     = [
        'defaults'     => [],
        'requirements' => [],
        'options'      => [],
        'host'         => '',
        'schemes'      => [],
    ];

    /**
     * @param callable $service
     * @param array    $vars
     */
    public function __construct($service, array $vars = [])
    {
        if (!is_callable($service)) {
            throw new \InvalidArgumentException('Parameter $service is not callable');
        } else if (is_object($service) && !$service instanceof \Closure) {
            $service = [$service, '__invoke'];
        }

        $this->service = $service;
        $this->vars    = array_merge($this->vars, $vars);
        $defaults      = $this->defaults;

        if (is_array($service)) {
            list($class, $name) = $service;
            $reflection = new \ReflectionMethod($class, $name);
        } else {
            $reflection = new \ReflectionFunction($service);
        }

        foreach ($reflection->getParameters() as $parameter) {
            $this->_positions[$parameter->name] = $parameter->getPosition();
            if ($parameter->isDefaultValueAvailable() && !array_key_exists($parameter->name, $defaults)) {
                $defaults[$parameter->name] = $parameter->getDefaultValue();
            }
        }

        $this->vars['defaults'] = $defaults;
    }

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->vars)) {
            return $this->vars[$key];
        }
        throw new \InvalidArgumentException($key);
    }

    /**
     * @param string $key
     *
     * @param mixed $value
     *
     * @throws \LogicException
     */
    public function __set($key, $value)
    {
        throw new \LogicException($key);
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function invokeWithParams(array $params)
    {
        $arguments = [];
        $defaults  = $this->defaults;
        foreach ($this->_positions as $name => $position) {
            if (!array_key_exists($name, $params)) {
                if (!array_key_exists($name, $defaults)) {
                    throw new \RuntimeException("Missing required argument '$name'");
                }
                $params[$name] = $defaults[$name];
            }
            $arguments[$position] = $params[$name];
        }
        return call_user_func_array($this->service, $arguments);
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        $args   = func_get_args();
        $params = [];
        foreach ($this->_positions as $name => $position) {
            if (array_key_exists($position, $args)) {
                $params[$name] = $args[$position];
            }
        }
        return $this->invokeWithParams($params);
    }
}