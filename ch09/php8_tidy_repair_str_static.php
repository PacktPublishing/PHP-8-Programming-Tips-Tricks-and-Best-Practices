<?php
// /repo/ch08/php8_tidy_repair_str_static.php

$str = <<<EOT
<DIV>
    <Div>Some Content</div>
    <Div>Some Other Content
</div>
EOT;
$class = new class() extends tidy {
    public static function repairString(string $str, array|string|null $config = null, ?string $encoding = null)
    {
        $fixed = parent::repairString($str);
        return preg_replace_callback(
            '/<+?>/',
            function ($item) { return strtolower($item); },
            $fixed);
    }
};
echo $class->repairString($str);
