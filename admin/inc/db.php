<?php
    require_once "inc/admin.php"; 
	function delete_query( $tableName, $fieldName, $whereClause ) {

        $delete = $mysqli->prepare("DELETE FROM $tableName WHERE $fieldName = ?");
        $delete->bind_param('i', $whereClause);
        $delete->execute(); 
        $delete->close();

        if($upload === false) {
            return 'Wrong Menu Update SQL: ' . $menuSqlQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error;
        } else {
            return "Sucessfully Delete the row!";
        }
    }
?>