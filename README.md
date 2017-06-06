# Germanpostalcodesvalidator

1.INTRODUCTION
---------------

Germanpostalcodesvalidator is a PHP tool to check if a given string of integers matches one of the 59215 German towns & cities postal codes.

2.INSTALLATION
---------------

2.1 -  Install PHPExcel library with composer in your project root folder: $ composer require phpoffice/phpexcel  

2.2 - Install the dependencies with composer in your project root folder: $ php composer.phar install

2.3 - Visit the link below, download and copy the Excel file OpenGeoDB_plz_ort_de.xls (3.62 MB) in your src directory (see files structure below)

Link: http://www.datendieter.de/item/Postleitzahlen_Liste_Deutschland

2.4 - Download and install (or use git clone) in your src directory the file Germanpostalcodesvalidator.php (availalable in the repository)

After the installation, the files structure should look the following:

 - project_root/vendor/phpexcel/  (directory)

(It includes in particular the file autoloader.php, here: project_root/vendor/phpexcel/autoloader.php) 

 - project_root/src/Germanpostalcodesvalidator.php

 - project_root/src/OpenGeoDB_plz_ort_de.xls.php

3.USAGE
--------

3.1 validate_postal_code(Object $filterSubsetObj, String $input)

There are 59215 German towns & cities postal codes in the Excel file OpenGeoDB_plz_ort_de.xls and the filter runs for blocks of 500 postal codes at a time. The method validate_postal_code() has to be called (59215/500) = 119 times approximately
against the string entered to check all postal codes. (The checks have to be done in chunks to avoid a computer memory crash).

Example: to check if the postal code 01994 matches one of the first 500 postal codes in column "A" of OpenGeoDB_plz_ort_de.xls

    <?php
	        // in file: Germanpostalcodesvalidator.php

          $validator = new Germanpostalcodesvalidator(0,500,range('A'));

          $postalCode = "01994"; 

          echo $validator->validate_postal_code($validator,$postalCode); // output: 1 (TRUE) 

          $postalCode = "1994";

          echo "<br/>";

          echo $validator->validate_postal_code($validator,$postalCode); // output: 0 (FALSE)

    ?>


