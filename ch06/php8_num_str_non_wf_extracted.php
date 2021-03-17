<?php
// /repo/ch06/php8_num_str_non_wf_extracted.php
$classes = [
    0 => 'style-0',
    1 => 'style-1',
    2 => 'style-2',
    3 => 'style-3',
];
$tag = '<img src="/images/xyz.png" style="width:;">';
preg_match('/width\:(.*?)\;/', $tag, $matches);
$width = $matches[1];
switch (TRUE) {
    case $width === 0 :
        $key = 0;
        break;
    case ($width % 3) === 0 :
        $key = 3;
        break;
    case ($width % 2) === 0 :
        $key = 2;
        break;
    default :
        $key = 1;
}
$html = '<div class="' . $classes[$key] . '">';
$html .= $tag;
$html .= '</div>';

echo "Width: $width\n";
echo htmlspecialchars($html) . "\n";
echo $html . "\n";


