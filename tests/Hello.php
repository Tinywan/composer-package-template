<?php
/**
 * @desc Hello.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/10/14 10:26
 */

namespace Tinywan\Template\Tests;

class Hello
{
    private $num = 1;

    function test(){
        try {
            $value = 1 << -1;
        } catch (\ArithmeticError $e){
            echo $e->getMessage();//Bit shift by negative number
        }
    }
}

$f = function() {
    return $this->num + 1;
};

echo $f->call(new Hello);

