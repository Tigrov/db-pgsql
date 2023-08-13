<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Tests\Benchmark;

use Yiisoft\Db\Pgsql\Schema;
use Yiisoft\Db\Pgsql\Schema\ArrayColumnSchema;
use Yiisoft\Db\Pgsql\Schema\BinaryColumnSchema;
use Yiisoft\Db\Pgsql\Schema\BitColumnSchema;
use Yiisoft\Db\Pgsql\Schema\BooleanColumnSchema;
use Yiisoft\Db\Pgsql\Schema\DoubleColumnSchema;
use Yiisoft\Db\Pgsql\Schema\IntegerColumnSchema;
use Yiisoft\Db\Pgsql\Schema\JsonColumnSchema;
use Yiisoft\Db\Pgsql\Schema\StringColumnSchema;
use Yiisoft\Db\Schema\SchemaInterface;

/**
 * @Iterations(5)
 * @Revs(1000)
 * @Groups({"typecast"})
 * @BeforeMethods({"before"})
 */
class AbstractTypecastBench
{
    public StringColumnSchema $string;

    public IntegerColumnSchema $integer;

    public DoubleColumnSchema $double;

    public BooleanColumnSchema $boolean;

    public BinaryColumnSchema $binary;

    public JsonColumnSchema $json;

    public BitColumnSchema $bit;

    public ArrayColumnSchema $intArray;

    /**
     * Load the bulk of the definitions.
     */
    public function before(): void
    {
        $this->string = new StringColumnSchema('string');
        $this->string->type(SchemaInterface::TYPE_STRING);
        $this->string->dbType('varchar');
        $this->string->phpType(SchemaInterface::PHP_TYPE_STRING);

        $this->integer = new IntegerColumnSchema('integer');
        $this->integer->type(SchemaInterface::TYPE_INTEGER);
        $this->integer->dbType('int4');
        $this->integer->phpType(SchemaInterface::PHP_TYPE_INTEGER);

        $this->double = new DoubleColumnSchema('double');
        $this->double->type(SchemaInterface::TYPE_DOUBLE);
        $this->double->dbType('float8');
        $this->double->phpType(SchemaInterface::PHP_TYPE_DOUBLE);

        $this->boolean = new BooleanColumnSchema('boolean');
        $this->boolean->type(SchemaInterface::TYPE_BOOLEAN);
        $this->boolean->dbType('bool');
        $this->boolean->phpType(SchemaInterface::PHP_TYPE_BOOLEAN);

        $this->binary = new BinaryColumnSchema('binary');
        $this->binary->type(SchemaInterface::TYPE_BINARY);
        $this->binary->dbType('bytea');
        $this->binary->phpType(SchemaInterface::PHP_TYPE_RESOURCE);

        $this->json = new JsonColumnSchema('json');
        $this->json->type(SchemaInterface::TYPE_JSON);
        $this->json->dbType('jsonb');
        $this->json->phpType(SchemaInterface::PHP_TYPE_ARRAY);

        $this->bit = new BitColumnSchema('bit');
        $this->bit->type(Schema::TYPE_BIT);
        $this->bit->dbType('bit');
        $this->bit->phpType(SchemaInterface::PHP_TYPE_INTEGER);

        $this->intArray = new ArrayColumnSchema('int_array');
        $this->intArray->type(SchemaInterface::TYPE_INTEGER);
        $this->intArray->dbType('int4');
        $this->intArray->phpType(SchemaInterface::PHP_TYPE_INTEGER);
        $this->intArray->dimension(1);
        $this->intArray->phpTypecastMethod('phpInteger');
    }
}
