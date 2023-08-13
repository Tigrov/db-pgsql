<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Schema;

use function bindec;
use function decbin;
use function is_int;
use function str_pad;

/**
 * Represents the metadata of a column in a database table for PostgreSQL Server.
 *
 * It provides information about the column's name, type, size, precision, and other details.
 *
 * It's used to store and retrieve metadata about a column in a database table and is typically used in conjunction with
 * the {@see TableSchema}, which represents the metadata of a database table as a whole.
 *
 * The following code shows how to use:
 *
 * ```php
 * use Yiisoft\Db\Pgsql\ColumnSchema;
 *
 * $column = new ColumnSchema();
 * $column->name('id');
 * $column->allowNull(false);
 * $column->dbType('integer');
 * $column->phpType('integer');
 * $column->type('integer');
 * $column->defaultValue(0);
 * $column->autoIncrement(true);
 * $column->primaryKey(true);
 * ```
 */
final class BitColumnSchema extends AbstractColumnSchema
{
    public function dbTypecast(mixed $value): mixed
    {
        if (is_int($value)) {
            return str_pad(decbin($value), (int) $this->getSize(), '0', STR_PAD_LEFT);
        }

        if ($value === '') {
            return null;
        }

        return $value;
    }

    public function phpTypecast(mixed $value): mixed
    {
        if (is_string($value)) {
            return bindec($value);
        }

        return $value;
    }
}
