<?php
// /repo/ch02/php7_variadic_inherit.php
class Upper {
    public function test(
                $here,
                int $id,
                string $name)
        {
                echo "ID: $id\n"
                         . "Name: $name\n"
                         . "Here: $here\n";
        }
}
class Lower extends Upper {
    public function test(...$everything)
    {
                var_dump($everything);
        }
}
$lower = new Lower();
echo '<pre>';
echo $lower->test('YES', 999, 'Fred');
echo '</pre>';

// output:
/*
Warning: Declaration of Lower::test(...$everything) should be compatible with
Upper::test($here, int $id, string $name) in /repo/ch02/php7_variadic_inherit.php on line 19

array(3) {
  [0] =>
  string(3) "YES"
  [1] =>
  int(999)
  [2] =>
  string(4) "Fred"
}

 */
