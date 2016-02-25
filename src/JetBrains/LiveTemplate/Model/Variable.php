<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Model;

/**
 * @property-read string $name
 * @property-read string $expression
 * @property-read string $defaultValue
 * @property-read bool   $alwaysStopAt
 */
class Variable extends AbstractEntity
{
    /**
     * @var array
     */
    protected $vars = [
        'name'         => null,
        'expression'   => null,
        'defaultValue' => null,
        'alwaysStopAt' => true,
    ];
}