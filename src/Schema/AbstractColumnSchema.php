<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Schema;

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
abstract class AbstractColumnSchema extends \Yiisoft\Db\Schema\AbstractColumnSchema
{
    /**
     * @var string|null Name of an associated sequence if column is auto incremental.
     */
    private string|null $sequenceName = null;

    public function dbTypecast(mixed $value): mixed
    {
        return $value;
    }

    public function defaultValueTypecast(string $defaultValue): mixed
    {
        return $this->phpTypecast($defaultValue);
    }

    public function phpTypecast(mixed $value): mixed
    {
        return $value;
    }

    /**
     * @return string|null name of an associated sequence if column is auto incremental.
     */
    public function getSequenceName(): string|null
    {
        return $this->sequenceName;
    }

    /**
     * Set the name of an associated sequence if a column is auto incremental.
     */
    public function sequenceName(string|null $sequenceName): void
    {
        $this->sequenceName = $sequenceName;
    }
}
