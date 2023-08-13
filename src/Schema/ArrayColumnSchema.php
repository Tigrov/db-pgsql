<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Schema;

use Yiisoft\Db\Expression\ArrayExpression;
use Yiisoft\Db\Expression\ExpressionInterface;
use Yiisoft\Db\Pgsql\ArrayParser;
use Yiisoft\Db\Schema\SchemaInterface;

use function array_walk_recursive;
use function bindec;
use function hex2bin;
use function is_array;
use function is_string;
use function json_decode;
use function substr;

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
final class ArrayColumnSchema extends AbstractColumnSchema
{
    /**
     * @var int The dimension of array, must be greater than 0.
     */
    private int $dimension = 1;

    private string $phpTypecastMethod = 'phpString';

    public function dbTypecast(mixed $value): mixed
    {
        if ($value === null || $value instanceof ExpressionInterface) {
            return $value;
        }

        return new ArrayExpression($value, $this->getDbType(), $this->dimension);
    }

    public function phpTypecast(mixed $value): mixed
    {
        if (is_string($value)) {
            $value = (new ArrayParser())->parse($value);
        }

        if (!is_array($value)) {
            return null;
        }

        if ($this->dimension === 1 && $this->getType() !== SchemaInterface::TYPE_JSON) {
            return array_map([$this, $this->phpTypecastMethod], $value);
        }

        array_walk_recursive($value, function (string|null &$val) {
            /** @psalm-var mixed $val */
            $val = $this->{$this->phpTypecastMethod}($val);
        });

        return $value;
    }

    /**
     * @return int Get the dimension of the array.
     *
     * Defaults to 0, means this column isn't an array.
     */
    public function getDimension(): int
    {
        return $this->dimension;
    }

    /**
     * Set dimension of an array.
     *
     * Defaults to 0, means this column isn't an array.
     */
    public function dimension(int $dimension): void
    {
        $this->dimension = $dimension;
    }

    private function phpString(string|null $value): string|null
    {
        return $value;
    }

    private function phpInteger(string|null $value): int|null
    {
        if ($value === null) {
            return null;
        }

        return (int) $value;
    }

    private function phpDouble(string|null $value): float|null
    {
        if ($value === null) {
            return null;
        }

        return (float) $value;
    }

    private function phpBoolean(string|null $value): bool|null
    {
        if ($value === null) {
            return null;
        }

        return $value !== 'f';
    }

    private function phpBit(string|null $value): float|int|null
    {
        if ($value === null) {
            return null;
        }

        return bindec($value);
    }

    private function phpBinary(string|null $value): false|string|null
    {
        if ($value === null) {
            return null;
        }

        return hex2bin(substr($value, 2));
    }

    /**
     * @throws \JsonException
     */
    private function phpJson(string|null $value): mixed
    {
        if ($value === null) {
            return null;
        }

        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }

    public function phpTypecastMethod(string $phpTypecastMethod): void
    {
        $this->phpTypecastMethod = $phpTypecastMethod;
    }
}
