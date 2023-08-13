<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Schema;

use PDO;
use Yiisoft\Db\Command\Param;
use Yiisoft\Db\Expression\Expression;
use Yiisoft\Db\Expression\ExpressionInterface;
use Yiisoft\Db\Helper\DbStringHelper;

use function is_float;
use function is_resource;
use function is_string;

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
final class BinaryColumnSchema extends AbstractColumnSchema
{
    public function dbTypecast(mixed $value): mixed
    {
        return match (true) {
            is_string($value) => new Param($value, PDO::PARAM_LOB),
            $value === null, is_resource($value), $value instanceof ExpressionInterface => $value,
            /** ensure type cast always has . as decimal separator in all locales */
            is_float($value) => DbStringHelper::normalizeFloat($value),
            $value === false => '0',
            default => (string) $value,
        };
    }

    public function defaultValueTypecast(string $defaultValue): string|Expression
    {
        $value = false;

        if (str_starts_with($defaultValue, '\\x')) {
            $value = hex2bin(substr($defaultValue, 2));
        }

        if ($value === false) {
            return new Expression($defaultValue);
        }

        return $value;
    }
}
