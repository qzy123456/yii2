<?php
namespace app\models;
class Service
{
    public function __constrict()
    {
    }

    public function add($a, $b)
    {
        return $a + $b;
    }

    public function sub($a, $b)
    {
        return $a - $b;
    }
}