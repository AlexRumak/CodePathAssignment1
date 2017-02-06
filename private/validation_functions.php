<?php

	function hasFieldData($fieldInfo){
		if($fieldInfo == ""){
			return false;
		}
	return true;
	}

	function isLessThan($fieldInfo, $length){
		if(strlen($fieldInfo) > $length){
			return false;
		}
	return true;
	}

	function hasAtLeast($fieldInfo, $length){
		if(strlen($fieldInfo) < $length){
			return false;
		}
	return true;
	}

	function containsAtSymbol($fieldInfo){
		if(strpos($fieldInfo, '@') !== false){
			return true;
		}
	return false;
	}

	function helloWorld(){
		echo '<p>Hello World</p>';
	}

?>
