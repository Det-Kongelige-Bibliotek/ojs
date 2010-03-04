<?php
/**
 * @file classes/db/compat/drivers/AdodbDatadictCompatDelegate.inc.php
 *
 * Copyright (c) 2003-2009 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AdodbDatadictCompatDelegate
 * @ingroup db
 *
 * @brief Compatibility layer for ADODB_DataDict to avoid 3rd-party software patches
 */

// $Id: $

class AdodbDatadictCompatDelegate {
	// Our data dictionary strategy
	var $adodbDict;

	// Character set support
	var $charSet = false;

	function AdodbDatadictCompatDelegate(&$adodbDict) {
		$this->adodbDict = &$adodbDict;
	}

	function _RenameColumnSQLDelegate($tabname, $oldcolumn, $newcolumn, $flds = '') {
		if ($flds) {
			return $this->adodbDict->_RenameColumnSQLUnpatched($tabname, $oldcolumn, $newcolumn, $flds);
		} else {
			return array(sprintf($this->adodbDict->renameColumn, $this->adodbDict->TableName($tabname), $this->adodbDict->NameQuote($oldcolumn), $this->adodbDict->NameQuote($newcolumn), ''));
		}
	}

	function _ChangeTableSQLDelegate($tablename, $flds, $tableoptions = false) {
		// Test wether we alter an existing table in a database that
		// does not support the ALTER COLUMN statement:
		//  * We check if the table exists by calling MetaColumns()
		//  * We check if the database supports ALTER COLUMN by checking
		//    for one exemplary field whether AlterColumnSQL() returns a result.
		if (!empty($flds) && is_array($cols = $this->adodbDict->MetaColumns($tablename))
		        && !sizeof($alter = $this->adodbDict->AlterColumnSQL($tablename, array_slice($flds, 0, 1, true)))) {
			// Database does not support ALTER COLUMN so AlterColumnSQL() will implicitly
			// recreate the entire table.
			return $this->adodbDict->AlterColumnSQL($tablename, false, $flds, $tableoptions);
		} else {
			return $this->adodbDict->_ChangeTableSQLUnpatched($tablename, $flds, $tableoptions);
		}
	}

	/**
	 * Functions managing the database character encoding
	 */
	function _GetCharSetDelegate() {
		return $this->charSet;
	}

	function _SetCharSetDelegate($charset_name) {
		$this->charSet = $charset_name;
	}
}
?>