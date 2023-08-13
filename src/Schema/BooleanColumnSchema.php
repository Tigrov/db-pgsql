<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Schema;

use Yiisoft\Db\Expression\ExpressionInterface;

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
final class BooleanColumnSchema extends AbstractColumnSchema
{
    public function dbTypecast(mixed $value): mixed
    {
        return match (true) {
            $value, $value === false, $value === null, $value instanceof ExpressionInterface => $value,
            $value === '' => null,
            default => (bool) $value,
        };
    }

    public function defaultValueTypecast(string $defaultValue): bool
    {
        return $defaultValue === 'true';
    }
}
