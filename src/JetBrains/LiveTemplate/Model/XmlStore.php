<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Model;
use IteratorAggregate;
use ReflectionClass;
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
            $this->templateSet = $this->toTemplateSet($this->xml);
        }
        return $this->templateSet;
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return TemplateSet
     */
    protected function toTemplateSet(SimpleXMLElement $xml)
    {
        return new TemplateSet([
            'group'     => $this->attribute($xml, 'group'),
            'templates' => array_map([$this, 'toTemplate'], $xml->xpath('/templateSet/template'))
        ]);
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return Template
     */
    protected function toTemplate(SimpleXMLElement $xml)
    {
        return new Template([
            'name'             => $this->attribute($xml, 'name'),
            'description'      => $this->attribute($xml, 'description'),
            'value'            => $this->attribute($xml, 'value'),
            'toReformat'       => $this->attribute($xml, 'toReformat') == 'true',
            'toShortenFQNames' => $this->attribute($xml, 'toShortenFQNames') != 'false',
            'variables'        => array_map([$this, 'toVariable'], $xml->xpath('variable')),
            'context'          => $this->toContext($xml->context),
            'shortcut'         => $this->attribute($xml, 'shortcut'),
            'deactivated'      => $this->attribute($xml, 'toReformat') == 'true',
        ]);
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return Variable
     */
    protected function toVariable(SimpleXMLElement $xml)
    {
        return new Variable([
            'name'         => $this->attribute($xml, 'name'),
            'expression'   => $this->attribute($xml, 'expression'),
            'defaultValue' => $this->attribute($xml, 'defaultValue'),
            'alwaysStopAt' => $this->attribute($xml, 'alwaysStopAt') != 'false',
        ]);
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return string[]
     */
    protected function toContext(SimpleXMLElement $xml)
    {
        static $supported = null;
        if (!$supported) {
            $supported = array_flip((new ReflectionClass(__NAMESPACE__ . '\ContextEnum'))->getConstants());
        }
        $context = [];
        foreach ($xml->xpath('option') as $option) {
            $name = $this->attribute($option, 'name');
            if (isset($supported[$name]) && $this->attribute($option, 'value') == 'true' ) {
                $context[] = $name;
            }
        }
        return array_unique($context);
    }

    /**
     * @param SimpleXMLElement $xml
     * @param string           $name
     *
     * @return string
     */
    protected function attribute(SimpleXMLElement $xml, $name)
    {
        return html_entity_decode((string)$xml[$name]);
    }
}