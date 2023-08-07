<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Tests\Benchmark;

/**
 * @Iterations(5)
 * @Revs(1000)
 * @Groups({"typecast"})
 * @BeforeMethods({"before"})
 */
class PhpTypecastBench extends AbstractTypecastBench
{
    public function benchPhpTypecastString(): void
    {
        $this->string->phpTypecast('string');
    }

    public function benchPhpTypecastStringInt(): void
    {
        $this->string->phpTypecast(123);
    }

    public function benchPhpTypecastIntString(): void
    {
        $this->integer->phpTypecast('10');
    }

    public function benchPhpTypecastInt(): void
    {
        $this->integer->phpTypecast(10);
    }

    public function benchPhpTypecastDouble(): void
    {
        $this->double->phpTypecast(10.5);
    }

    public function benchPhpTypecastDoubleString(): void
    {
        $this->double->phpTypecast('10.5');
    }

    public function benchPhpTypecastBool(): void
    {
        $this->boolean->phpTypecast(true);
    }

    public function benchPhpTypecastBoolInt(): void
    {
        $this->boolean->phpTypecast(1);
    }

    public function benchPhpTypecastBoolString(): void
    {
        $this->boolean->phpTypecast('1');
    }

    public function benchPhpTypecastBinaryString(): void
    {
        $this->binary->phpTypecast("\x10\x11\x12");
    }

    public function benchPhpTypecastJson(): void
    {
        $this->json->phpTypecast('{"one":1,"two":2,"three":3}');
    }

    public function benchPhpTypecastBit(): void
    {
        $this->bit->phpTypecast('01111011');
    }
}
