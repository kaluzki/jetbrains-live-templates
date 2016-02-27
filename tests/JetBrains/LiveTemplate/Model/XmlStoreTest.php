<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\Model;

/**
 */
class XmlStoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array[]
     */
    public function providerGetIterator()
    {
        $integration = <<<XML
<templateSet group="test-group">
  <template name="t1-name" value="t1-value">
    <context>
      <option name="PHP String Literal" value="true" />
      <option name="HTML" value="false" />
      <option name="OTHER" value="true" />
    </context>
  </template>
  <template name="t2-name" value="\$v1$&#10;&gt;\$v2$&lt;\$v3$&amp;\$v4$" description="t2-description" toReformat="true" toShortenFQNames="false" shortcut="ENTER" deactivated="true">
    <variable />
    <variable name="v2" />
    <variable name="v3" expression="exp" defaultValue="default" />
    <variable name="v4" alwaysStopAt="false" />
  </template>
 </templateSet>
XML;

        return [
            'empty xml' => [
                'expected' => ['group' => '', 'templates' => []],
                'xml'      => '<xml/>'
            ],
            'integration' => [
                'expected' => ['group' => 'test-group', 'templates' => [
                    [
                        'name'             => 't1-name',
                        'description'      => '',
                        'value'            => 't1-value',
                        'toReformat'       => false,
                        'toShortenFQNames' => true,
                        'variables'        => [],
                        'context'          => [
                            ContextEnum::PHP_STRING,
                            ContextEnum::OTHER
                        ],
                        'shortcut'         => '',
                        'deactivated'      => false,
                    ],
                    [
                        'name'             => 't2-name',
                        'description'      => 't2-description',
                        'value'            => "\$v1$\n>\$v2$<\$v3$&\$v4$",
                        'toReformat'       => true,
                        'toShortenFQNames' => false,
                        'variables'        => [
                            [
                                'name'         => '',
                                'expression'   => '',
                                'defaultValue' => '',
                                'alwaysStopAt' => true,
                            ],
                            [
                                'name'         => 'v2',
                                'expression'   => '',
                                'defaultValue' => '',
                                'alwaysStopAt' => true,
                            ],
                            [
                                'name'         => 'v3',
                                'expression'   => 'exp',
                                'defaultValue' => 'default',
                                'alwaysStopAt' => true,
                            ],
                            [
                                'name'         => 'v4',
                                'expression'   => '',
                                'defaultValue' => '',
                                'alwaysStopAt' => false,
                            ],
                        ],
                        'context'          => [],
                        'shortcut'         => 'ENTER',
                        'deactivated'      => true,
                    ],
                ]],
                'xml'      => $integration
            ],
        ];
    }

    /**
     * @dataProvider providerGetIterator
     * @covers       XmlStore::getIterator
     *
     * @param \Exception|array $expected
     * @param string          $xml
     */
    public function testGetIterator($expected, $xml)
    {
        if ($expected instanceof \Exception) {
            $this->setExpectedException(get_class($expected), $expected->getMessage());
        }
        $store     = new XmlStore(new \SimpleXMLElement($xml));
        $iterator  = $store->getIterator();
        $this->assertInstanceOf('kaluzki\JetBrains\LiveTemplate\Model\TemplateSet', $iterator);
        $this->assertEquals($expected, json_decode(json_encode($iterator), true));
    }
}