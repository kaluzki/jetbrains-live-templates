<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\View;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

/**
 * Helper methods for rendering
 */
trait ViewTrait
{
    /**
     * Merges all arguments recursively and implodes the result with a new line.
     *
     * $this->lines(
     *   'first line',
     *   'second line',
     *   [
     *     'third line'
     *   ]
     * )
     *
     * @param string|string[] ... $content
     *
     * @return string
     */
    public function lines()
    {
        return implode(PHP_EOL, $this->merge(func_get_args()));
    }

    /**
     * Merges all arguments recursively.
     *
     * @param mixed|mixed[] ... $content
     *
     * @return array
     */
    public function merge()
    {
        return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator(func_get_args())), false);
    }
}