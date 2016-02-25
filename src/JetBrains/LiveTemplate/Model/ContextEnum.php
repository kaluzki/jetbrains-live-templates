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
    const HTML            = "HTML";
    const HTML_TEXT       = "HTML_TEXT";
    const XML             = "XML";
    const XML_TEXT        = "XML_TEXT";
    const XSL_TEXT        = "XSL_TEXT";
    const JSON            = "JSON";
    const SQL             = "SQL";
    const JSP             = "JSP";
    const CSS             = "CSS";
    const CSS_VALUE       = "CSS_PROPERTY_VALUE";
    const CSS_DECLARATION = "CSS_DECLARATION_BLOCK";
    const CSS_RULESET     = "CSS_RULESET_LIST";
    const CUCUMBER        = "CUCUMBER_FEATURE_FILE";
    const JS              = "JAVA_SCRIPT";
    const JS_EXPRESSION   = "JS_EXPRESSION";
    const JS_STATEMENT    = "JS_STATEMENT";
    const TYPESCRIPT      = "TypeScript";
    const HAML            = "HAML";
    const PHP             = "PHP";
    const PHP_COMMENT     = "PHP Comment";
    const PHP_STRING      = "PHP String Literal";
    const JADE            = "JADE";
    const COFFEESCRIPT    = "CoffeeScript";
    const OTHER           = "OTHER";
}