## Installation

To install the project, follow these steps:

1. Clone the repository using the command:
```
   git clone https://github.com/IgumenovBogdan/supplier-product-list-processor.git
```
2. Open the project folder
```
   cd supplier-product-list-processor
```
3. Run this command for start the script:
```
   php parser.php --file=products_comma_separated.csv --unique-combinations=combination_count.csv
```
After executing the script, you will see lines with Product objects as well as the unique_combinations.csv file with the number of unique fields specified in the combination_count.csv file.

For more convenient testing, I have already placed the files for use with the --file and --unique-combinations flags from example files, but you can also place any of your files in the project folder and specify them when running the command