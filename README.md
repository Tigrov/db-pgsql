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
```

## Results

PHP version 8.2.9 without xdebug.

### For `dbTypecast()`

```
./vendor/bin/phpbench report --report=overview --ref=dbTypecastCurrent --ref=dbTypecastPredefined
```

| vcs branch                  | iterations | revs  | mode    | net_time |
|-----------------------------|------------|-------|---------|----------|
| speedup_typecast_current    | 60         | 60000 | 0.381μs | 25.933ms |
| speedup_typecast_predefined | 60         | 60000 | 0.248μs | 19.422ms |

### For `phpTypecast()`

```
./vendor/bin/phpbench report --report=overview --ref=phpTypecastCurrent --ref=phpTypecastPredefined
```

| vcs branch                  | iterations | revs  | mode    | net_time |
|-----------------------------|------------|-------|---------|----------|
| speedup_typecast_current    | 60         | 60000 | 0.430μs | 25.894ms |
| speedup_typecast_predefined | 60         | 60000 | 0.244μs | 18.087ms |
