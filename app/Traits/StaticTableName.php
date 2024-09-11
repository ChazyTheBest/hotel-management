<?php declare(strict_types=1);

namespace App\Traits;

trait StaticTableName
{
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }

    public static function getFK(): string
    {
        return with(new static)->getForeignKey();
    }
}
