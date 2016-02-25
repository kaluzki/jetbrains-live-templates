<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Model;
use JsonSerializable;

/**
 */
abstract class AbstractEntity implements JsonSerializable
{
    /**
     * @var array
     */
    protected $vars = [];

    /**
     * @param array $vars
     */
    public function __construct(array $vars)
    {
        $this->vars = array_merge($this->vars, $vars);
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
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->vars;
    }
}