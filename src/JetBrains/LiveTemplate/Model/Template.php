<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Model;

/**
 * @property-read string     $name
 * @property-read string     $value
 * @property-read string     $description
 * @property-read bool       $toReformat
 * @property-read bool       $toShortenFQNames
 * @property-read Variable[] $variables
 * @property-read string[]   $context
 * @property-read string     $shortcut
 * @property-read bool       $deactivated
 */
class Template extends AbstractEntity
{
    /**
     * @var array
     */
    protected $vars = [
        'name'             => null,
        'description'      => null,
        'value'            => null,
        'toReformat'       => false,
        'toShortenFQNames' => true,
        'variables'        => [],
        'context'          => [],
        'shortcut'         => null,
        'deactivated'      => false,
    ];
}