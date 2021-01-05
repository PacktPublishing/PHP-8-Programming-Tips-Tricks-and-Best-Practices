<?php
// ch02/includes/nullsafe_config.php
return new class() {
	const HEADERS = ['Name','Amt','Age','ISO','Company'];
	const PATTERN = "%20s | %16s | %3s | %3s | %s\n";
	public function json($fn) {
		$json = file_get_contents($fn);
		return json_decode($json, TRUE);
	}
	public function csv($fn) {
		$arr = [];
		$fh = new SplFileObject($fn, 'r');
		while ($node = $fh->fgetcsv()) $arr[] = $node;
		return $arr;			
	}
	public function txt($fn) {
		$arr = [];
		$fh = new SplFileObject($fn, 'r');
		while ($node = $fh->fgets())
			$arr[] = explode("\t", $node);
		return $arr;
	}
	public function display(array $data)
	{
		// reformat amount using ","
		$total  = 0;
		$lines  = ['----','---','---','---','-------'];
		echo '<pre>';
		vprintf(self::PATTERN, self::HEADERS);
		vprintf(self::PATTERN, $lines);
		foreach ($data as $row) {
			if (!empty($row[1])) {
				$total += $row[1];
				$row[1] = number_format($row[1], 0);
				$row[2] = (string) $row[2];
				vprintf(self::PATTERN, $row);
			}
		}
		echo "\nCombined Wealth:";
		echo number_format($total, 0) . "\n";
		echo '</pre>';
	}	
};

