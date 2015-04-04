--TEST--
v8\Isolate - snapshot support
--SKIPIF--
<?php if (!extension_loaded("v8")) print "skip"; ?>
--FILE--
<?php
require '.tracking_dtors.php';

/** @var \Phpv8Testsuite $helper */
$helper = require '.testsuite.php';


$isolate = new \v8Tests\TrackingDtors\Isolate();

$helper->header('Object representation (no snapshot)');
debug_zval_dump($isolate);
$helper->space();


$helper->header('Accessors (no snapshot)');
$helper->method_matches($isolate, 'GetSnapshot', null);
$helper->space();

$context = new \v8\Context($isolate);

$helper->assert('Context should have no test data', $context->GlobalObject()->Has($context, new \v8\StringValue($isolate, 'test_snapshot')), false);

$helper->line();

$context = null;
$isolate = null;

$helper->space();



$source = 'function test_snapshot() { return "hello, world";}';

$data = v8\StartupData::CreateFromSource($source);

$isolate = new \v8Tests\TrackingDtors\Isolate($data);



$helper->header('Object representation (with snapshot)');
debug_zval_dump($isolate);
$helper->space();


$helper->header('Accessors (with snapshot)');
$helper->method_matches_instanceof($isolate, 'GetSnapshot', v8\StartupData::class);
$helper->space();

$context = new \v8\Context($isolate);

$helper->assert('Context should have test function', $context->GlobalObject()->Get($context, new \v8\StringValue($isolate, 'test_snapshot'))->IsFunction());
$context->GlobalObject()->Set($context, new \v8\StringValue($isolate, 'test_snapshot'), new \v8\StringValue($isolate, 'garbage'));

$context1 = new \v8\Context($isolate);
$helper->assert('Contexts from the same snapshot doesn\'t affected by each other', $context1->GlobalObject()->Get($context1, new \v8\StringValue($isolate, 'test_snapshot'))->IsFunction());

$isolate2 = new \v8Tests\TrackingDtors\Isolate($data);
$context2 = new \v8\Context($isolate2);
$helper->assert('Contexts between different isolates from the same snapshot doesn\'t affected by each other', $context2->GlobalObject()->Get($context2, new \v8\StringValue($isolate2, 'test_snapshot'))->IsFunction());

$isolate3 = new \v8Tests\TrackingDtors\Isolate($data);
$data = null;

$context3 = new \v8\Context($isolate3);
$helper->assert('Deleting reference to snapshot is OK after creating Isolate instance', $context3->GlobalObject()->Get($context3, new \v8\StringValue($isolate3, 'test_snapshot'))->IsFunction());
$helper->line();

$context = null;
$context1 = null;
$context2 = null;
$context3 = null;
$isolate = null;
$isolate2 = null;
$isolate3 = null;

echo 'END', PHP_EOL;
?>
--EXPECT--
Object representation (no snapshot):
------------------------------------
object(v8Tests\TrackingDtors\Isolate)#2 (1) refcount(2){
  ["snapshot":"v8\Isolate":private]=>
  NULL
}


Accessors (no snapshot):
------------------------
v8Tests\TrackingDtors\Isolate::GetSnapshot() matches expected value


Context should have no test data: ok

Isolate dies now!


Object representation (with snapshot):
--------------------------------------
object(v8Tests\TrackingDtors\Isolate)#3 (1) refcount(2){
  ["snapshot":"v8\Isolate":private]=>
  object(v8\StartupData)#2 (0) refcount(2){
  }
}


Accessors (with snapshot):
--------------------------
v8Tests\TrackingDtors\Isolate::GetSnapshot() result is instance of v8\StartupData


Context should have test function: ok
Contexts from the same snapshot doesn't affected by each other: ok
Contexts between different isolates from the same snapshot doesn't affected by each other: ok
Deleting reference to snapshot is OK after creating Isolate instance: ok

Isolate dies now!
Isolate dies now!
Isolate dies now!
END
