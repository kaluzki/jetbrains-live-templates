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
    ];
}