<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Model;
use ArrayIterator;
use IteratorAggregate;

/**
 * @property-read string     $group
 * @property-read Template[] $templates
 */
class TemplateSet extends AbstractEntity implements IteratorAggregate
{
    /**
     * @var array
     */
    protected $vars = [
        'group'     => null,
        'templates' => [],
    ];

    /**
     * @inheritdoc
     *
     * @return ArrayIterator|Template[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->templates);
    }
}