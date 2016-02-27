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
interface ContextEnum
{
    /**
     * html
     */
    const HTML            = "HTML";
    const HTML_TEXT       = "HTML_TEXT";

    /**
     * xml
     */
    const XML             = "XML";
    const XML_TEXT        = "XML_TEXT";
    const XSL_TEXT        = "XSL_TEXT";

    /**
     * json
     */
    const JSON            = "JSON";

    /**
     * sql
     */
    const SQL             = "SQL";

    /**
     * jsp
     */
    const JSP             = "JSP";

    /**
     * css
     */
    const CSS             = "CSS";
    const CSS_DECLARATION = "CSS_DECLARATION_BLOCK";
    const CSS_VALUE       = "CSS_PROPERTY_VALUE";
    const CSS_RULESET     = "CSS_RULESET_LIST";

    /**
     * javascript
     */
    const JS              = "JAVA_SCRIPT";
    const JS_EXPRESSION   = "JS_EXPRESSION";
    const JS_STATEMENT    = "JS_STATEMENT";
    const JS_XHTML        = "JSX_HTML";

    /**
     * typescript
     */
    const TYPESCRIPT      = "TypeScript";

    /**
     * coffee
     */
    const COFFEESCRIPT    = "CoffeeScript";

    /**
     * php
     */
    const PHP             = "PHP";
    const PHP_COMMENT     = "PHP Comment";
    const PHP_STRING      = "PHP String Literal";

    /**
     * haml
     */
    const HAML            = "HAML";

    /**
     * text
     */
    const CUCUMBER        = "CUCUMBER_FEATURE_FILE";
    const OTHER           = "OTHER";
}