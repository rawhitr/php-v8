--TEST--
v8\NumberObject
--SKIPIF--
<?php if (!extension_loaded("v8")) { print "skip"; } ?>
--FILE--
<?php

/** @var \Phpv8Testsuite $helper */
$helper = require '.testsuite.php';

require '.v8-helpers.php';
$v8_helper = new PhpV8Helpers($helper);

// Tests:

$isolate1 = new \v8\Isolate();
$extensions1 = [];
$global_template1 = new v8\ObjectTemplate($isolate1);

// TODO: fix it, this cause segfault due to FunctionTemplate object destruction and all it internal structures cleanup
//$global_template1->Set('print', $v8_helper->getPrintFunctionTemplate($isolate1), \v8\PropertyAttribute::DontDelete);
$print_func_tpl = $v8_helper->getPrintFunctionTemplate($isolate1);
$global_template1->Set(new \v8\StringValue($isolate1, 'print'), $print_func_tpl, \v8\PropertyAttribute::DontDelete);

$context1 = new v8\Context($isolate1, $extensions1, $global_template1);

$value = new v8\NumberObject($context1, 42.12);

$helper->header('Object representation');
debug_zval_dump($value);
$helper->space();

$helper->assert('NumberObject extends ObjectValue', $value instanceof \v8\ObjectValue);
$helper->line();

$helper->header('Getters');
$helper->method_export($value, 'ValueOf');
$helper->space();

$v8_helper->run_checks($value, 'Checkers');

$context1->GlobalObject()->Set($context1, new \v8\StringValue($isolate1, 'val'), $value);

$source1    = '
print("val: ", val, "\n");
print("typeof val: ", typeof val, "\n");

val';
$file_name1 = 'test.js';

$script1 = new v8\Script($context1, new \v8\StringValue($isolate1, $source1), new \v8\ScriptOrigin($file_name1));
$res1 = $script1->Run();
$helper->space();

$helper->header('Returned value should be the same');
$helper->value_matches_with_no_output($res1, $value);
$helper->space();

$source1    = 'new Number(11.22);';
$file_name1 = 'test.js';

$script1 = new v8\Script($context1, new \v8\StringValue($isolate1, $source1), new \v8\ScriptOrigin($file_name1));
$res1 = $script1->Run();

$v8_helper->run_checks($res1, 'Checkers on boxed from script');


?>
--EXPECT--
Object representation:
----------------------
object(v8\NumberObject)#8 (2) refcount(2){
  ["isolate":"v8\Value":private]=>
  object(v8\Isolate)#3 (1) refcount(5){
    ["snapshot":"v8\Isolate":private]=>
    NULL
  }
  ["context":"v8\ObjectValue":private]=>
  object(v8\Context)#7 (4) refcount(2){
    ["isolate":"v8\Context":private]=>
    object(v8\Isolate)#3 (1) refcount(5){
      ["snapshot":"v8\Isolate":private]=>
      NULL
    }
    ["extensions":"v8\Context":private]=>
    array(0) refcount(2){
    }
    ["global_template":"v8\Context":private]=>
    object(v8\ObjectTemplate)#4 (1) refcount(2){
      ["isolate":"v8\Template":private]=>
      object(v8\Isolate)#3 (1) refcount(5){
        ["snapshot":"v8\Isolate":private]=>
        NULL
      }
    }
    ["global_object":"v8\Context":private]=>
    NULL
  }
}


NumberObject extends ObjectValue: ok

Getters:
--------
v8\NumberObject->ValueOf(): float(42.12)


Checkers:
---------
v8\NumberObject(v8\ObjectValue)->IsCallable(): bool(false)
v8\NumberObject(v8\Value)->IsUndefined(): bool(false)
v8\NumberObject(v8\Value)->IsNull(): bool(false)
v8\NumberObject(v8\Value)->IsTrue(): bool(false)
v8\NumberObject(v8\Value)->IsFalse(): bool(false)
v8\NumberObject(v8\Value)->IsName(): bool(false)
v8\NumberObject(v8\Value)->IsString(): bool(false)
v8\NumberObject(v8\Value)->IsSymbol(): bool(false)
v8\NumberObject(v8\Value)->IsFunction(): bool(false)
v8\NumberObject(v8\Value)->IsArray(): bool(false)
v8\NumberObject(v8\Value)->IsObject(): bool(true)
v8\NumberObject(v8\Value)->IsBoolean(): bool(false)
v8\NumberObject(v8\Value)->IsNumber(): bool(false)
v8\NumberObject(v8\Value)->IsInt32(): bool(false)
v8\NumberObject(v8\Value)->IsUint32(): bool(false)
v8\NumberObject(v8\Value)->IsDate(): bool(false)
v8\NumberObject(v8\Value)->IsArgumentsObject(): bool(false)
v8\NumberObject(v8\Value)->IsBooleanObject(): bool(false)
v8\NumberObject(v8\Value)->IsNumberObject(): bool(true)
v8\NumberObject(v8\Value)->IsStringObject(): bool(false)
v8\NumberObject(v8\Value)->IsSymbolObject(): bool(false)
v8\NumberObject(v8\Value)->IsNativeError(): bool(false)
v8\NumberObject(v8\Value)->IsRegExp(): bool(false)


val: 42.12
typeof val: object


Returned value should be the same:
----------------------------------
Expected value is identical to actual value


Checkers on boxed from script:
------------------------------
v8\NumberObject(v8\ObjectValue)->IsCallable(): bool(false)
v8\NumberObject(v8\Value)->IsUndefined(): bool(false)
v8\NumberObject(v8\Value)->IsNull(): bool(false)
v8\NumberObject(v8\Value)->IsTrue(): bool(false)
v8\NumberObject(v8\Value)->IsFalse(): bool(false)
v8\NumberObject(v8\Value)->IsName(): bool(false)
v8\NumberObject(v8\Value)->IsString(): bool(false)
v8\NumberObject(v8\Value)->IsSymbol(): bool(false)
v8\NumberObject(v8\Value)->IsFunction(): bool(false)
v8\NumberObject(v8\Value)->IsArray(): bool(false)
v8\NumberObject(v8\Value)->IsObject(): bool(true)
v8\NumberObject(v8\Value)->IsBoolean(): bool(false)
v8\NumberObject(v8\Value)->IsNumber(): bool(false)
v8\NumberObject(v8\Value)->IsInt32(): bool(false)
v8\NumberObject(v8\Value)->IsUint32(): bool(false)
v8\NumberObject(v8\Value)->IsDate(): bool(false)
v8\NumberObject(v8\Value)->IsArgumentsObject(): bool(false)
v8\NumberObject(v8\Value)->IsBooleanObject(): bool(false)
v8\NumberObject(v8\Value)->IsNumberObject(): bool(true)
v8\NumberObject(v8\Value)->IsStringObject(): bool(false)
v8\NumberObject(v8\Value)->IsSymbolObject(): bool(false)
v8\NumberObject(v8\Value)->IsNativeError(): bool(false)
v8\NumberObject(v8\Value)->IsRegExp(): bool(false)