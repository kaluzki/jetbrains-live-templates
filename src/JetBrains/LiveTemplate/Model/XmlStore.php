<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Model;
use IteratorAggregate;
use SimpleXMLElement;

/**
 */
class XmlStore implements IteratorAggregate
{
    /**
     * @var SimpleXMLElement
     */
    protected $xml;

    /**
     * @var TemplateSet
     */
    protected $templateSet;

    /**
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    /**
     * @inheritdoc
     *
     * @return TemplateSet|Template[]
     */
    public function getIterator()
    {
        if (!$this->templateSet) {
            $this->templateSet = $this->_toTemplateSet($this->xml);
        }
        return $this->templateSet;
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return TemplateSet
     */
    private function _toTemplateSet(SimpleXMLElement $xml)
    {
        return new TemplateSet([
            'group'     => (string)$this->xml['group'],
            'templates' => array_map([$this, '_toTemplate'], $xml->xpath('/templateSet/template'))
        ]);
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return Template
     */
    private function _toTemplate(SimpleXMLElement $xml)
    {
        return new Template([
            'name'             => (string)$xml['name'],
            'description'      => (string)$xml['description'],
            'value'            => (string)$xml['value'],
            'toReformat'       => (string)$xml['toReformat'] == 'true',
            'toShortenFQNames' => (string)$xml['toShortenFQNames'] != 'false',
            'variables'        => array_map([$this, '_toVariable'], $xml->xpath('variable')),
            'context'          => $this->_toContext($xml->context),
        ]);
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return Variable
     */
    private function _toVariable(SimpleXMLElement $xml)
    {
        return new Variable([
            'name'         => (string)$xml['name'],
            'expression'   => (string)$xml['expression'],
            'defaultValue' => (string)$xml['defaultValue'],
            'alwaysStopAt' => (string)$xml['alwaysStopAt'] != 'false',
        ]);
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return string[]
     */
    private function _toContext(SimpleXMLElement $xml)
    {
        $context = [];
        foreach ($xml->xpath('option') as $option) {
            if ((string)$option['value'] == 'true' && constant(__NAMESPACE__ . "\\ContextEnum::{$option['name']}")) {
                $context[] = (string)$option['name'];
            }
        }
        return array_unique($context);
    }
}