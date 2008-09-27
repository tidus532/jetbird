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
		
			$query = "	SELECT user_name 
						FROM user
						WHERE user_level = 1";
			$admins = $dbconnection->fetch_array($query);
			
			foreach($admins as $admin){
				$main['username'][] = $admin['username'];
			}
			$smarty->assign('admin', $main['username']);
			
		break;
	}
	
	$smarty->display('admin.user.tpl');

?>