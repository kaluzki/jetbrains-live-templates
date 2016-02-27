PHP: Common
-----------

:white_small_square: **`try`** `[Default]` _try ... catch_
>`PHP`

```php
try {
    $END$
}
catch ($EXCEPTION$ $e) {
}
```
- :arrow_forward: `EXCEPTION` **`complete()`** _`"Exception"`_

===
:black_small_square: **`ar`** `[Default]` _array_
>`PHP`

```php
array($END$)
```

===
:black_small_square: **`:`** `[Default]` _=>_
>`PHP`

```php
=> $VALUE$,$END$
```
- :arrow_forward: `VALUE`  

===
:black_small_square: **`test`** `[Default]` _test method_
>`PHP`

```php
/**
 * @see test$METHOD_CAPITALIZED$
 * @return array[]
 */
public function getDataForTest$METHOD_CAPITALIZED$()
{
    return array(
        'case' => array(
            'expected' => 'expected',
        ),
    );
}

/**
 * @covers $CLASS$::$METHOD$
 * @dataProvider getDataForTest$METHOD_CAPITALIZED$
 */
public function test$METHOD_CAPITALIZED$($expected)
{
    $current = $END$;
    $this->assertEquals($current, $expected);
}
```
- :arrow_forward: `METHOD` **`complete()`** 
- :arrow_forward: `CLASS` **`fileNameWithoutExtension()`** 
- :fast_forward: `METHOD_CAPITALIZED` **`capitalize(METHOD)`** 

===
:black_small_square: **`mock`** `[Default]` _getIwatMock_
>`PHP`

```php
/** @var $$$OBJ$ $CLASS$ */
$$$OBJ$ = $this->getIwatMock('$CLASS$', array(
    '$METHOD$' => function() {
        $END$
    },
));
```
- :arrow_forward: `OBJ`  _`"obj"`_
- :arrow_forward: `CLASS` **`complete()`** _`"iwat_"`_
- :arrow_forward: `METHOD`  _`"get"`_

===
:black_small_square: **`,`** `[Default]` _", "_
>`PHP`

```php
, $END$
```

===
:black_small_square: **`':`** `[Default]` _=>_
>`PHP`

```php
' => $VALUE$,$END$
```
- :arrow_forward: `VALUE`  

===
:black_small_square: **`":`** `[Default]` _=>_
>`PHP`

```php
" => $VALUE$,$END$
```
- :arrow_forward: `VALUE`  

===
:black_small_square: **`@r`** `[Default]` _@return_
>`PHP Comment`

```php
@return $COMPLETE$
```
- :arrow_forward: `COMPLETE` **`complete()`** 

===
:black_small_square: **`@p`** `[Default]` _@param_
>`PHP Comment`

```php
@param $ENUM$ $$$COMPLETE$
```
- :arrow_forward: `ENUM` **`enum("string", "int", "bool", "array", "float", "mixed")`** 
- :arrow_forward: `COMPLETE` **`complete()`** 

===
:black_small_square: **`ta`** `[Default]` _pstart_
>`PHP`

```php
pstart(__METHOD__ . '$SUFFIX$');
```
- :arrow_forward: `SUFFIX`  

===
:black_small_square: **`to`** `[Default]` _pstort_
>`PHP`

```php
pstop(__METHOD__ . '$SUFFIX$');
```
- :arrow_forward: `SUFFIX`  

===
:black_small_square: **`ar-map`** `[Default]` _array_map(function() {}, array());_
>`PHP`

```php
array_map($FUNCTION$, $SELECTION$)$END$
```
- :arrow_forward: `FUNCTION` **`"function($entry) {return $entry;}"`** 

===
:black_small_square: **`context-test`** `[Default]` 
>`HTML_TEXT|HTML|XSL_TEXT|XML|XML_TEXT|JSON|SQL|JSP|CSS_PROPERTY_VALUE|CSS_DECLARATION_BLOCK|CSS_RULESET_LIST|CSS|CUCUMBER_FEATURE_FILE|JAVA_SCRIPT|JS_EXPRESSION|JS_STATEMENT|TypeScript|CoffeeScript|PHP|PHP Comment|PHP String Literal|HAML|OTHER`

```html
context-test
```

===
:white_small_square: **`;`** `[Default]` _;_
>`PHP`

```php
;
$END$
```

===
:white_small_square: **`=`** `[Default]` _$var = $value;_
>`PHP`

```php
$VAR$ = $SELECTION$;
$END$
```
- :fast_forward: `VAR` **`phpSuggestVariableName()`** _`"$var"`_

===

