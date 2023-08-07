<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql;

use PDO;
use Yiisoft\Db\Command\Param;
use Yiisoft\Db\Expression\JsonExpression;
use Yiisoft\Db\Helper\DbStringHelper;
use Yiisoft\Db\Schema\ColumnSchemaInterface;

use function json_decode;

class Typecast
{
    public function __construct(private ColumnSchemaInterface $column)
    {
    }

    public function value(mixed $value): mixed
    {
        return $value;
    }

    public function string(mixed $value): mixed
    {
        return match (true) {
            is_string($value), is_resource($value) => $value,
            /** ensure type cast always has . as decimal separator in all locales */
            is_float($value) => DbStringHelper::normalizeFloat($value),
            is_bool($value) => $value ? '1' : '0',
            default => (string) $value,
        };
    }

    public function integer(mixed $value): int
    {
        return (int) $value;
    }

    public function boolean(mixed $value): bool
    {
        return $value && $value !== "f";
    }

    public function double(mixed $value): float
    {
        return (float) $value;
    }

    public function dbBinary(mixed $value): mixed
    {
        if (is_resource($value)) {
            return $value;
        }

        return new Param($this->string($value), PDO::PARAM_LOB);
    }

    public function dbJson(mixed $value): JsonExpression
    {
        return new JsonExpression($value, $this->column->getDbType());
    }

    public function phpJson(mixed $value): array|bool|float|int|string|null
    {
        return json_decode((string) $value, true, 512, JSON_THROW_ON_ERROR);
    }

    public function dbBit(mixed $value): string
    {
        if (is_int($value)) {
            return str_pad(decbin($value), (int) $this->column->getSize(), '0', STR_PAD_LEFT);
        }

        return (string) $value;
    }

    public function phpBit(mixed $value): mixed
    {
        return is_string($value) ? bindec($value) : $value;
    }
}
