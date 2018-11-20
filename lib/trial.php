<?php 


	if (isset($_REQUEST['submit'])) {
		
		$checkbox = $_GET['items'];
		var_dump($checkbox);

	}
	
	echo '<form>';

	for ($i = 0; $i < 5; $i++) {
		
		echo '<input type="checkbox" name="items[]" value="2015-Above-it-All"/>';

	}
	echo '<input type="submit" name="submit" value="submit">';
	echo '</form>';



 