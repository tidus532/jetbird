<?php

	/*	This file is part of Jetbird.

	    Jetbird is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.

	    Jetbird is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.

	    You should have received a copy of the GNU General Public License
	    along with Jetbird.  If not, see <http://www.gnu.org/licenses/>.
	*/
	
	switch ($_GET['action']) {
	
		case edit_permissions:
		
			$query = "	SELECT username 
						FROM users
						WHERE auth_id = 1";
			$result = mysql_query($query);
			//$test = $dbconnection->fetch_array($query);
			//die(print_r($test));
			while($row = mysql_fetch_array($result)) {
				$main['username'][] = $row['username'];
				}
			//die(print_r($main));
			$smarty->assign('admin', $main['username']);
			
		break;
	}
	
	$smarty->display('admin.index.tpl');
?>