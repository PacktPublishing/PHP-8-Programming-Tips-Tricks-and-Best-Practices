<?php
// /repo/ch01/php7_prop_reduce.php
declare(strict_types=1);
class Test {
	protected $id = 0;
	protected $token = 0;
	protected $name = '';
	public function getId() {
		return $this->id;
	}
	public function setId(int $id) {
		$this->id = $id;
	}
	public function getToken() {
		return $this->token;
	}
	public function setToken(int $token) {
		$this->token = $token;
	}
	public function getName() {
		return $this->name;
	}
	public function setName(string $name) {
		$this->name = $name;
	}
}

// assign values
$test = new Test();
$test->setId(111);
$test->setToken(999999);
$test->setName('Fred');

// display results
$pattern = '<tr><th>%s</th><td>%s</td></tr>';
echo '<table width="50%" border=1>';
printf($pattern, 'ID', $test->getId());
printf($pattern, 'Token', $test->getToken());
printf($pattern, 'Name', $test->getName());
echo '</table>';
