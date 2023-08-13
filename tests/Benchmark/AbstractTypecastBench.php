<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Tests\Benchmark;

use Yiisoft\Db\Pgsql\ColumnSchema;
use Yiisoft\Db\Pgsql\Schema;
use Yiisoft\Db\Schema\SchemaInterface;

/**
 * @Iterations(5)
 * @Revs(1000)
 * @Groups({"typecast"})
 * @BeforeMethods({"before"})
 */
class AbstractTypecastBench
{
    public ColumnSchema $string;

    public ColumnSchema $integer;

    public ColumnSchema $double;

    public ColumnSchema $boolean;

    public ColumnSchema $binary;

    public ColumnSchema $json;

    public ColumnSchema $bit;

    public ColumnSchema $intArray;

    /**
     * Load the bulk of the definitions.
     */
    public function before(): void
    {
        $this->string = new ColumnSchema('string');
        $this->string->type(SchemaInterface::TYPE_STRING);
        $this->string->dbType('varchar');
        $this->string->phpType(SchemaInterface::PHP_TYPE_STRING);

        $this->integer = new ColumnSchema('integer');
        $this->integer->type(SchemaInterface::TYPE_INTEGER);
        $this->integer->dbType('int4');
        $this->integer->phpType(SchemaInterface::PHP_TYPE_INTEGER);

        $this->double = new ColumnSchema('double');
        $this->double->type(SchemaInterface::TYPE_DOUBLE);
        $this->double->dbType('float8');
        $this->double->phpType(SchemaInterface::PHP_TYPE_DOUBLE);

        $this->boolean = new ColumnSchema('boolean');
        $this->boolean->type(SchemaInterface::TYPE_BOOLEAN);
        $this->boolean->dbType('bool');
        $this->boolean->phpType(SchemaInterface::PHP_TYPE_BOOLEAN);

        $this->binary = new ColumnSchema('binary');
        $this->binary->type(SchemaInterface::TYPE_BINARY);
        $this->binary->dbType('bytea');
        $this->binary->phpType(SchemaInterface::PHP_TYPE_RESOURCE);

        $this->json = new ColumnSchema('json');
        $this->json->type(SchemaInterface::TYPE_JSON);
        $this->json->dbType('jsonb');
        $this->json->phpType(SchemaInterface::PHP_TYPE_ARRAY);

        $this->bit = new ColumnSchema('bit');
        $this->bit->type(Schema::TYPE_BIT);
        $this->bit->dbType('bit');
        $this->bit->phpType(SchemaInterface::PHP_TYPE_INTEGER);

        $this->intArray = new ColumnSchema('int_array');
        $this->intArray->type(SchemaInterface::TYPE_INTEGER);
        $this->intArray->dbType('int4');
        $this->intArray->phpType(SchemaInterface::PHP_TYPE_INTEGER);
        $this->intArray->dimension(1);
    }
}
