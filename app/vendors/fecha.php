<?php
    function fecha($time = 'now', $str = 'Y-m-d')
    {
		$in = strtotime($time);
    	$out = gmdate($str,$in);
		return ($out);
    
    }
?>
