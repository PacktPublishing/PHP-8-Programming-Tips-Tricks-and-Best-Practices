<?php
namespace Php8\Jit;
// Used by PHP development team to test JIT performance
// See: https://gist.github.com/dstogov/12323ad13d3240aee8f1#file-b-php
class Mandelbrot
{
    public static $bailout    = 16;
    public static $cols       = 80;
    public static $iterations = 1000;
    /**
     * Renders Mandelbrot
     *
     */
    public function render()
    {
        $d1 = microtime(1);
        $halfMinusOne = (int) ((self::$cols / 2) - 1);
        $out = '';
        for ($y = -$halfMinusOne; $y < $halfMinusOne; $y++) {
            for ($x = -$halfMinusOne; $x < $halfMinusOne; $x++) {
                if ($this->iterate($x, $y) == 0)
                    $out .= '*';
                else
                    $out .= ' ';
            }
            $out .= "\n";
        }
        $d2 = microtime(1);
        $diff = $d2 - $d1;
        $out .= sprintf("\nPHP Elapsed %0.3f\n", $diff);
        return $out;
    }
    public function iterate($x,$y)
    {
        $half = (int) (self::$cols / 2);
        $x  = $x / $half;
        $y  = $y / $half;
        $cr = $y-0.5;
        $ci = $x;
        $zr = 0.0;
        $zi = 0.0;
        $i = 0;
        while (true) {
            $i++;
            $temp = $zr * $zi;
            $zr2 = $zr * $zr;
            $zi2 = $zi * $zi;
            $zr = $zr2 - $zi2 + $cr;
            $zi = $temp + $temp + $ci;
            if ($zi2 + $zr2 > self::$bailout)
                return $i;
            if ($i > self::$iterations)
                return 0;
        }

    }
    public function __toString()
    {
        return $this->render();
    }
}
