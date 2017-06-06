<?php
	require_once "../vendor/phpexcel/autoloader.php";
	error_reporting(E_ALL);
	set_time_limit(0);
	date_default_timezone_set('Europe/Berlin');
?>	
	
<?php
	
	 /**
	 *   Germanpostalcodesvalidator - A php tool to determine if a string containing digits matches any city or town postal code in Germany
	 *
	 *  The contents of this file are subject to the terms of the GNU General
	 *  Public License Version 3.0. You may not use this file except in
	 *  compliance with the license. Any of the license terms and conditions
	 *  can be waived if you get permission from the copyright holder.
	 *	 *
	 *  Copyright (c) 2017 by KB DESIGN
	 *  Kami Barut-Wanayo <kamibarut@yahoo.com>
	 *  https://github.com/KB-WEB-DEVELOPMENT/
	 *
	 *  @package Germanpostalcodesvalidator
	 *  @version 1.0.1-dev
	 *  @date  03.06.2017
	 *  @since 03.06.2017
	 */	
		
	class Germanpostalcodevalidator implements PHPExcel_Reader_IReadFilter	{

		private $_startRow = 0;
		private $_endRow = 0;
		private $_columns = array();
		protected $filterSubsetObj = new stdClass();
		
		/** setting parameters for reading the Excel worksheet
		* @param int
		* @param int
		* @param int
		*/
		public function __construct($startRow, $endRow, $columns) {
			
			$this->_startRow	= $startRow;
			$this->_endRow		= $endRow;
			$this->_columns		= $columns;
								
		}
				
		/**
		* returns true while data is being read, false when all cells have been read
		* @param int
		* @param int
		* @param string
		* @return bool
		*/
		public function readCell($column, $row, $worksheetName = '') {
			if ($row >= $this->_startRow && $row <= $this->_endRow) {
				if (in_array($column,$this->_columns)) {
					return true;
				}
			}
			return false;
		}

		/**
		* returns true if the string input is an official German postal code within any Germany city or town.
		* @param object
		* @param string
		* @return bool
		*/
		
		public function validate_postal_code($filterSubsetObj, $input) {
						
			$inputFileType = 'Excel5';
			$inputFileName = 'OpenGeoDB_plz_ort_de.xls';
			$sheetname = 'Tabelle1';
			
			$this->filterSubsetObj = $filterSubsetObj; 

			$objReader = PHPExcel_IOFactory::createReader($inputFileType);

			$objReader->setLoadSheetsOnly($sheetname);

			$objReader->setReadFilter($this->filterSubsetObj);

			$objPHPExcel = $objReader->load($inputFileName);

			$postalCodesArray = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

			$input = preg_replace('~\D~','', $input);
			
			foreach ($postalCodesArray as $v => $postalCode ) {
					
				if (trim($postalCode) == $input) {
							
					$result = true;
					break;
					
				} else {						
					$result = false;
				  }		
			}
			
			return $result;
		}
	}			

?>
