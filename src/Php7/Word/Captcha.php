<?php
// /repo/src/Php7/Word/Captcha.php
namespace Php7\Word;

class Captcha
{
	const BOTTOM_20 = [
			1 => 'one','two','three','four','five','six','seven','eight','nine','ten',
			11 => 'eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen'
	];
	const TOP_20 = [2 => 'twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety'];
	const ABOVE  = [3 => 'hundred', 4 => 'thousand'];

	public $hash = '';
	public $key  = 0;
	public function render()
	{
		$words = '';
		$num = rand(1000,9999);
		$str = (string) $num;
		$len = strlen($str);
		$max = $len - 2;
		$pos = 0;
		while ($pos < $max) {
			$digit = (int) $str[$pos];
			$words .= self::BOTTOM_20[$digit] ?? '';
			$words .= ' ';
			$words .= self::ABOVE[$len - $pos] ?? '';
			$words .= ' ';
			$pos++;
		}
		$last2 = (int) substr($str, -2);
		if ($last2 < 20) {
			$words .= self::BOTTOM_20[(int) $last2] ?? '';
		} else {
			$first = (int)((string) $last2)[0];
			$last  = (int)((string) $last2)[1];
			$words .= self::TOP_20[$first] ?? '';
			$words .= ' ';
			$words .= self::BOTTOM_20[$last] ?? '';
		}
		$this->key = $num;
		$this->hash = password_hash($num, PASSWORD_BCRYPT);
		return trim($words);
	}
}
// usage:
/*
session_start();
use Php7\Word\Captcha;
$captcha = new Captcha();
$words = $captcha->render();
$token = $captcha->hash;
if ($_POST) {
	$pwd = $_POST['captcha'] ?? 'pwd';
	$hash = $_POST['token'] ?? 'hash';
	if (password_verify($pwd, $hash)) {
		echo 'Success!';
	} else {
		error_log('Auth Failure');
	}
}
echo <<<EOT
<form method="post">
	Prove you're human!  Type in this number:
	<?= $words; ?>
	<br /><input type="text" name="captcha" />
	<br /><input type="hidden" name="token" value="<?= $token ?>" />
	<br /><input type="submit" />
</form>
EOT;
*/
