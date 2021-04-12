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

		protected $_startRow = 0;
		protected $_endRow = 0;
		protected $_columns = array();
		
		protected $filterSubsetObj;		
		protected $objReader;
		protected $objPHPExcel;
		
		protected $postalCodesArray = array();
		protected $input = "";
		protected $result = true;
		
		
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
		
		public function validate_postal_code($input) {
									
			$input = trim($input);
    
			if ( !isset($input) || (isset($input) === true && $input === '') ) {
    
			   die("You cannot enter an empty string. Your string must contain at least one character."); 
  
 			}

			$this->input = preg_replace('~\D~','', $input);
									
			$this->filterSubsetObj = new MyReadFilter(); 

			$this->objReader = PHPExcel_IOFactory::createReader("Excel5");

			$this->objReader->setLoadSheetsOnly("Tabelle1");

			$this->objReader->setReadFilter($this->filterSubsetObj);

			$this->objPHPExcel = $this->objReader->load('OpenGeoDB_plz_ort_de.xls');

			$this->postalCodesArray = $this->objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			foreach ($this->postalCodesArray as $v => $postalCode ) {
					
				if (trim($postalCode) == $this->input) {
							
					$this->result = true;
					break;
					
				} else {						
					$this->result = false;
				  }		
			}
			
			return $this->result;
		}
	}			

?>
