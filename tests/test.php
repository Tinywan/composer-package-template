<?php
/**
 * @desc test.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/14 10:51
 */

declare(script_types=1); // 表示开启严格模式

function sumOfInt(int ...$int)
{
    return array_sum($int);
}
var_dump(sumOfInt(2, 3, 4)); // 输出 int(9)

