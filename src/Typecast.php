<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql;

use PDO;
use Yiisoft\Db\Command\Param;
use Yiisoft\Db\Expression\ExpressionInterface;
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
        if ($value === '') {
            return null;
        }

        return $value;
    }

    public function string(mixed $value): mixed
    {
        return match (true) {
            is_string($value), $value === null, is_resource($value), $value instanceof ExpressionInterface => $value,
            /** ensure type cast always has . as decimal separator in all locales */
            is_float($value) => DbStringHelper::normalizeFloat($value),
            $value === false => '0',
            default => (string) $value,
        };
    }

    public function integer(mixed $value): mixed
    {
        return match (true) {
            is_int($value), $value === null, $value instanceof ExpressionInterface => $value,
            $value === '' => null,
            default => (int) $value,
        };
    }

    public function boolean(mixed $value): mixed
    {
        return match (true) {
            $value, $value === false, $value === null, $value instanceof ExpressionInterface => $value,
            is_string($value) => $value !== '' ? $value && $value !== 'f' : null,
            default => (bool) $value,
        };
    }

    public function double(mixed $value): mixed
    {
        return match (true) {
            is_float($value), $value === null, $value instanceof ExpressionInterface => $value,
            $value === '' => null,
            default => (float) $value,
        };
    }

    public function dbBinary(mixed $value): mixed
    {
        return match (true) {
            is_string($value) => new Param($value, PDO::PARAM_LOB),
            $value === null, is_resource($value), $value instanceof ExpressionInterface => $value,
            /** ensure type cast always has . as decimal separator in all locales */
            is_float($value) => DbStringHelper::normalizeFloat($value),
            is_bool($value) => $value ? '1' : '0',
            default => (string) $value,
        };
    }

    public function dbJson(mixed $value): mixed
    {
        if (is_array($value) || is_object($value) && !$value instanceof ExpressionInterface) {
            return new JsonExpression($value, $this->column->getDbType());
        }

        return $value;
    }

    public function phpJson(mixed $value): mixed
    {
        if (is_string($value)) {
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        }

        return $value;
    }

    public function dbBit(mixed $value): mixed
    {
        if (is_int($value)) {
            return str_pad(decbin($value), (int) $this->column->getSize(), '0', STR_PAD_LEFT);
        }

        return $value;
    }

    public function phpBit(mixed $value): mixed
    {
        if (is_string($value)) {
            return $value !== '' ? bindec($value) : null;
        }

        return $value;
    }
}
