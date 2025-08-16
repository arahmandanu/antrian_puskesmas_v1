<?php

namespace App\Trait;

trait EnumFromName
{
    public static function valueFromName(string $name): self
    {
        return constant("self::$name");
    }
}
