<?php

declare(strict_types=1);

namespace Yiisoft\Db\Pgsql\Tests\Benchmark;

/**
 * @Iterations(5)
 * @Revs(1000)
 * @Groups({"typecast"})
 * @BeforeMethods({"before"})
 */
class DbTypecastBench extends AbstractTypecastBench
{
    public function benchDbTypecastString(): void
    {
        $this->string->dbTypecast('string');
    }

    public function benchDbTypecastStringInt(): void
    {
        $this->string->dbTypecast(123);
    }

    public function benchDbTypecastIntString(): void
    {
        $this->integer->dbTypecast('10');
    }

    public function benchDbTypecastInt(): void
    {
        $this->integer->dbTypecast(10);
    }

    public function benchDbTypecastDouble(): void
    {
        $this->double->dbTypecast(10.5);
    }

    public function benchDbTypecastDoubleString(): void
    {
        $this->double->dbTypecast('10.5');
    }

    public function benchDbTypecastBool(): void
    {
        $this->boolean->dbTypecast(true);
    }

    public function benchDbTypecastBoolInt(): void
    {
        $this->boolean->dbTypecast(1);
    }

    public function benchDbTypecastBoolString(): void
    {
        $this->boolean->dbTypecast('1');
    }

    public function benchDbTypecastBinaryString(): void
    {
        $this->binary->dbTypecast("\x10\x11\x12");
    }

    public function benchDbTypecastJson(): void
    {
        $this->json->dbTypecast(['one' => 1, 'two' => 2, 'three' => 3]);
    }

    public function benchDbTypecastBit(): void
    {
        $this->bit->dbTypecast(123);
    }
}
