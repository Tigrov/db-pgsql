<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql;

use JsonException;
use Yiisoft\Db\Expression\ArrayExpression;
use Yiisoft\Db\Expression\ExpressionInterface;
use Yiisoft\Db\Schema\AbstractColumnSchema;
use Yiisoft\Db\Schema\SchemaInterface;

use function array_walk_recursive;
use function is_array;
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
final class ColumnSchema extends AbstractColumnSchema
{
    /**
     * @var int The dimension of array. Defaults to 0, means this column isn't an array.
     */
    private int $dimension = 0;

    /**
     * @var string|null Name of an associated sequence if column is auto incremental.
     */
    private string|null $sequenceName = null;

    private Typecast $typecast;

    public string|null $dbTypecast = 'value';

    public string|null $phpTypecast = 'value';

    public function __construct(string $name)
    {
        $this->typecast = new Typecast($this);

        parent::__construct($name);
    }

    /**
     * Converts the input value according to {@see type} and {@see dbType} for use in a db query.
     *
     * If the value is null or an {@see Expression}, it won't be converted.
     *
     * @param mixed $value input value
     *
     * @return mixed Converted value.
     */
    public function dbTypecast(mixed $value): mixed
    {
        if ($this->dimension > 0) {
            if ($value === null || $value instanceof ExpressionInterface) {
                return $value;
            }

            return new ArrayExpression($value, $this->getDbType(), $this->dimension);
        }

        return $this->typecast->{$this->dbTypecast}($value);
    }

    /**
     * Converts the input value according to {@see phpType} after retrieval from the database.
     *
     * If the value is null or an {@see Expression}, it won't be converted.
     *
     * @param mixed $value The input value
     *
     * @throws JsonException
     *
     * @return mixed The converted value
     */
    public function phpTypecast(mixed $value): mixed
    {
        if ($this->dimension > 0) {
            if (is_string($value)) {
                $value = (new ArrayParser())->parse($value);
            }

            if (!is_array($value)) {
                return null;
            }

            if ($this->dimension === 1 && $this->getType() !== SchemaInterface::TYPE_JSON) {
                return array_map([$this->typecast, $this->phpTypecast], $value);
            }

            array_walk_recursive($value, function (mixed &$val) {
                /** @psalm-var mixed $val */
                $val = $this->typecast->{$this->phpTypecast}($val);
            });

            return $value;
        }

        return $this->typecast->{$this->phpTypecast}($value);
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
     * @return string|null name of an associated sequence if column is auto incremental.
     */
    public function getSequenceName(): string|null
    {
        return $this->sequenceName;
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

    /**
     * Set the name of an associated sequence if a column is auto incremental.
     */
    public function sequenceName(string|null $sequenceName): void
    {
        $this->sequenceName = $sequenceName;
    }
}
