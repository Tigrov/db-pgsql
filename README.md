## Installation

```
git clone https://github.com/Tigrov/db-pgsql
cd db-pgsql
composer install
```

## Usage

```
git switch speedup_typecast_current
./vendor/bin/phpbench run --filter=DbTypecast  --tag=dbTypecastCurrent --store
./vendor/bin/phpbench run --filter=PhpTypecast  --tag=phpTypecastCurrent --store

git switch speedup_typecast_predefined
./vendor/bin/phpbench run --filter=DbTypecast  --tag=dbTypecastPredefined --store
./vendor/bin/phpbench run --filter=PhpTypecast  --tag=phpTypecastPredefined --store

git switch speedup_typecast_columns
./vendor/bin/phpbench run --filter=DbTypecast  --tag=dbTypecastColumns --store
./vendor/bin/phpbench run --filter=PhpTypecast  --tag=phpTypecastColumns --store
```

## Results

PHP version 8.2.9 without xdebug.

### For `dbTypecast()`

```
./vendor/bin/phpbench report --report=overview --ref=dbTypecastCurrent --ref=dbTypecastPredefined --ref=dbTypecastColumns
```

| vcs branch                  | iterations | revs  | mode    | net_time |
|-----------------------------|------------|-------|---------|----------|
| speedup_typecast_current    | 60         | 60000 | 0.381μs | 29.028ms |
| speedup_typecast_predefined | 60         | 60000 | 0.252μs | 22.707ms |
| speedup_typecast_columns    | 60         | 60000 | 0.142μs | 15.949ms |

### For `phpTypecast()`

```
./vendor/bin/phpbench report --report=overview --ref=phpTypecastCurrent --ref=phpTypecastPredefined --ref=phpTypecastColumns
```

| vcs branch                  | iterations | revs  | mode    | net_time |
|-----------------------------|------------|-------|---------|----------|
| speedup_typecast_current    | 60         | 60000 | 0.449μs | 56.213ms |
| speedup_typecast_predefined | 60         | 60000 | 0.279μs | 34.744ms |
| speedup_typecast_columns    | 60         | 60000 | 0.147μs | 26.656ms |
