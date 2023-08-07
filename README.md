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

## Result

### For `dbTypecast()`

```
./vendor/bin/phpbench report --report=overview --ref=dbTypecastCurrent --ref=dbTypecastPredefined
```

| suite                | date                | php   | vcs branch                  | xdebug | iterations | revs  | mode    | net_time |
|----------------------|---------------------|-------|-----------------------------|--------|------------|-------|---------|----------|
| dbtypecastcurrent    | 2023-08-07 09:51:57 | 8.2.9 | speedup_typecast_current    | false  | 60         | 60000 | 0.381μs | 25.933ms |
| dbtypecastpredefined | 2023-08-07 09:55:01 | 8.2.9 | speedup_typecast_predefined | false  | 60         | 60000 | 0.226μs | 19.613ms |

### For `phpTypecast()`

```
./vendor/bin/phpbench report --report=overview --ref=phpTypecastCurrent --ref=phpTypecastPredefined
```

| suite                 | date                | php   | vcs branch                  | xdebug | iterations | revs  | mode    | net_time |
|-----------------------|---------------------|-------|-----------------------------|--------|------------|-------|---------|----------|
| phptypecastcurrent    | 2023-08-07 10:07:27 | 8.2.9 | speedup_typecast_current    | false  | 60         | 60000 | 0.430μs | 25.894ms |
| phptypecastpredefined | 2023-08-07 10:05:23 | 8.2.9 | speedup_typecast_predefined | false  | 60         | 60000 | 0.264μs | 20.128ms |
