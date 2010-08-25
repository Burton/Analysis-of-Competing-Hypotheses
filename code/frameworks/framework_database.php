<?php



// THIS IS NOT INTENDED TO BE USED ALONE. IT'S A FRAMEWORK FOR OTHER CLASSES.



class FrameworkDatabase {


	
	// These are other extra variables that don't need to be matched in the DB table.
	public $database_table_name; // This is the table that this class interacts with.
	public $insert_fields_to_ignore = Array(); // These are tables fields that will be IGNORED when inserts happen.



	public function __construct() { // Populates all of the varibles in this object from the DB.
		$this->found = FALSE;
	}

	public function populateFromId($id) { // Populates all of the varibles in this object from the DB. Maybe this and the next functions can be merged.
		$return_value = FALSE;
		$results = mysql_fast("SELECT * FROM $this->database_table_name WHERE id='$id' LIMIT 1");
		$this_results = Array();
		if( count($results) > 0 ) {
			$this_result = $results[0]; // Since only one results comes back.
		}
		$badchars = array("\"", "\\");
		$goodchars = array("''", "");
		foreach ($this_result as $field => $value) {
			$this->$field = str_replace($badchars, $goodchars, $value); //stripslashes($value);
			$return_value = TRUE;
		}
		$this->found = $return_value;
		return $return_value;
	}

	public function populateFromAttribute($value, $kind) { // Populates all of the varibles in this object from the DB.
		$return_value = FALSE;
		$results = mysql_fast("SELECT * FROM $this->database_table_name WHERE $kind='$value' LIMIT 1");
		$this_result = $results[0]; // Since only one results comes back.
		$badchars = array("\"", "\\");
		$goodchars = array("''", "");
		foreach ($this_result as $field => $value) {
			$this->$field = str_replace($badchars, $goodchars, $value); //stripslashes($value);
			$return_value = TRUE;
		}
		$this->found = $return_value;
		return $return_value;
	}
	
	public function insertNew() {
	
		$table_fields = getFieldList($this->database_table_name);
		$sql_statement = "INSERT INTO $this->database_table_name (";
		$counter = 0;
		for( $i = 1; $i < count($table_fields); $i ++ ) {
			if( !in_array($table_fields[$i], $this->insert_fields_to_ignore) ) {
				$sql_statement .= $table_fields[$i];
				$counter++;
				if( $counter < count($table_fields)-count($this->insert_fields_to_ignore)-1 ) {
					$sql_statement .= ", ";
				}
			}
		}
		$sql_statement .= ") VALUES (";
		$counter = 0;
		for( $i = 1; $i < count($table_fields); $i ++ ) {
			if( !in_array($table_fields[$i], $this->insert_fields_to_ignore) ) {
				$sql_statement .= "'" . addslashes($this->$table_fields[$i]) . "'";
				$counter++;
				if( $counter < count($table_fields)-count($this->insert_fields_to_ignore)-1 ) {
					$sql_statement .= ", ";
				}
			}
		}
		$sql_statement .= ");";
		
		mysql_do($sql_statement);
		$this->id = mysql_insert_id();
		return TRUE;
		
	}
	
	public function update() {
		$table_fields = getFieldList($this->database_table_name);
		$sql_statement = "UPDATE $this->database_table_name SET ";
		for( $i = 1; $i < count($table_fields); $i ++ ) {
			$sql_statement .= $table_fields[$i] . "='" . addslashes($this->$table_fields[$i]) . "'";
			if( $i < count($table_fields)-1 ) {
				$sql_statement .= ", ";
			}
		}
		$sql_statement .= " WHERE id=$this->id;";
		
		mysql_do($sql_statement);
		$this->id = mysql_insert_id();
		return TRUE;
	}
	
	public function get($id) { // Alias.
		return $this->populateFromId($id);
	}
	
	public function getAttr($value, $kind) { // Alias.
		return $this->populateFromAttribute($value, $kind);
	}
	
	public function insert() { // Alias.
		return $this->insertNew();
	}

}



?>