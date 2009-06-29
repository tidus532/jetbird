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

	class plugin {
		
		function load_plugins($page) {
			global $config;
			if(empty($page)) {
				die();
			}
			$plugins = $config['plugin'][$page];
			//die(var_dump($plugins));
			if(is_array($plugins)) {
				foreach($plugins as $plugin) {
					include("/plugin/". $plugin ."/index.php");
				}
			} else {
				include("plugin/". $plugins ."/index.php");
			}
			
		}
	}
?>