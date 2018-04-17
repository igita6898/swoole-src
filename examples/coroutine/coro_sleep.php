<?php
use Swoole\Coroutine as co;
class Obj {
  public $a;
  protected $b;
  private $c;
  var $d;

  function __construct($a, $b, $c, $d) {
    $this->a = $a;
    $this->b = $b;
    $this->c = $c;
    $this->d = $d;
  }

  function __sleep() {
         // co::sleep(0.5);
	$client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
	$res = $client->connect('127.0.0.1', 9501, 10);
        var_dump($res);
	if ($res)
	{
	    echo("connect success. Error: {$client->errCode}\n");
	}
               echo "sleep\n";
    return array('a', 'b', 'c');
  }

#   function __wakeup() {
#       $this->d = $this->a + $this->b + $this->c;
#   }
}

$o = new Obj(1, 2, 3, 4);



co::set(['trace_flags' => 1]);

co::create(function() use($o) {
    $serialized = swoole_serialize::pack($o);
    $unserialized = swoole_serialize::unpack($serialized);
    var_dump($unserialized);
    echo "call user\n";
    });
