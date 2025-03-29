## How to execute the script

The script requires PHP >= 8.3

You can use the provided docker config to build the image and run the command inside.

```bash
docker compose up -d
```

To run the script use the index.php and provide your csv file path to its first argument.
There is a test.csv file which contains the data provided in the homework.

The api key to the exchangerate api is hardcoded inside the index.php as a default value.
If you want to use your own api key, provide it as a second argument to the `index.php`

Be aware by running the index.php you will get the results by the live exchange rates.

> php index.php <csv_file_path> [excahnge_api_key]

```bash
php index.php test.csv
```

Run inside the container:

```bash
docker compose exec -it php php index.php test.csv
```

## How to run the test

The test has a stub with the rates provided in the homework description.
Uses the same set of test data from a dataprovider matching the results with the result-set provided.

```bash
composer test
```

Run inside the container:

```bash
docker compose exec -it php composer test
```