<?php
/**
 * (c) Demjan Kaluzki <kaluzkidemjan@gmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kaluzki\JetBrains\LiveTemplate\View;
use kaluzki\JetBrains\LiveTemplate\Model\ContextEnum;
use kaluzki\JetBrains\LiveTemplate\Model\Template;
use kaluzki\JetBrains\LiveTemplate\Model\TemplateSet;
use kaluzki\JetBrains\LiveTemplate\Model\Variable;

/**
 */
class MarkDown
{
    use ViewTrait;

    /**
     * @var array[]
     */
    protected static $aceModeMap = [
        'html'       => [
            ContextEnum::HTML,
            ContextEnum::HTML_TEXT
        ],
        'xml'        => [
            ContextEnum::XML,
            ContextEnum::XML_TEXT,
            ContextEnum::XSL_TEXT
        ],
        'json'       => [
            ContextEnum::JSON
        ],
        'sql'        => [
            ContextEnum::SQL
        ],
        'jsp'        => [
            ContextEnum::JSP
        ],
        'css'        => [
            ContextEnum::CSS,
            ContextEnum::CSS_DECLARATION,
            ContextEnum::CSS_RULESET,
            ContextEnum::CSS_VALUE
        ],
        'javascript' => [
            ContextEnum::JS,
            ContextEnum::JS_EXPRESSION,
            ContextEnum::JS_STATEMENT,
            ContextEnum::JS_XHTML
        ],
        'typescript' => [
            ContextEnum::TYPESCRIPT
        ],
        'coffee'     => [
            ContextEnum::COFFEESCRIPT
        ],
        'php'        => [
            ContextEnum::PHP,
            ContextEnum::PHP_COMMENT,
            ContextEnum::PHP_STRING
        ],
        'haml'       => [
            ContextEnum::HAML
        ],
        'text'       => [
            ContextEnum::CUCUMBER,
            ContextEnum::OTHER
        ],
    ];

    const EMOJI  = ':';
    const CODE   = '`';
    const BOLD   = '**';
    const ITALIC = '_';

    /**
     * @param TemplateSet $set
     *
     * @return string
     */
    public function render(TemplateSet $set)
    {
        return $this->lines(
            $set->group,
            str_repeat('-', mb_strlen($set->group)),
            '',
            array_map([$this, 'renderTemplate'], $set->templates)
        );
    }

    /**
     * @param Template $template
     *
     * @return string
     */
    protected function renderTemplate(Template $template)
    {
        return $this->lines(
            implode(' ', [
                $this->md(self::EMOJI, $template->deactivated ? 'white_small_square' : 'black_small_square'),
                $this->md(self::BOLD, $this->md(self::CODE, $template->name)),
                $this->md(self::CODE, '[' . ($template->shortcut ? : 'Default') . ']'),
                $this->md(self::ITALIC, $template->description),
            ]),
            '>' . $this->md(self::CODE, implode('|', $template->context)),
            '',
            "```{$this->getAceMode($template->context[0])}",
            $template->value,
            '```',
            array_map([$this, 'renderVariable'], $template->variables),
            '',
            '==='
        );
    }

    /**
     * @param Variable $variable
     *
     * @return string
     */
    protected function renderVariable(Variable $variable)
    {
        return implode(' ', [
            '-',
            $this->md(self::EMOJI, $variable->alwaysStopAt ? 'arrow_forward' : 'fast_forward'),
            $this->md(self::CODE, $variable->name),
            $this->md(self::BOLD, $this->md(self::CODE, $variable->expression)),
            $this->md(self::ITALIC, $this->md(self::CODE, $variable->defaultValue)),
        ]);
    }

    /**
     * @param string $context
     *
     * @return string
     */
    protected function getAceMode($context)
    {
        foreach (static::$aceModeMap as $mode => $contexts) {
            if (in_array($context, $contexts)) {
                return $mode;
            }
        }
        return 'text';
    }

    /**
     * @param string $type
     * @param string $content
     *
     * @return null|string
     */
    protected function md($type, $content)
    {
        return mb_strlen($content) ? "{$type}{$content}{$type}" : null;
    }
}