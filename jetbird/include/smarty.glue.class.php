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
	
	load("smarty");
	
	class smarty_glue extends smarty{
		private $smarty_handle;
		public $template;
		
		public function __construct(){
			global $config;
			parent::__construct();
			
			// Look for smarty directories, since they are defined relative to jetbird root
			$prefix = "";
			while(!file_exists($prefix . $config['smarty']['template_dir'])){
				$prefix .= "../";
				
				if($level == 5){
					die("<b>Fatal error:</b> smarty directories not found");
				}
				
				$level++;
			}
			
			$this->template_dir = $prefix . $config['smarty']['template_dir'];
	        $this->compile_dir = $prefix . $config['smarty']['compile_dir'];
	        $this->cache_dir = $prefix . $config['smarty']['cache_dir'];
	        $this->config_dir = $prefix . $config['smarty']['config_dir'];
			
			if(!is_readable($this->template_dir . $config['smarty']['template'] . '/') || $config['smarty']['template'] == "rss"){
				$this->template = "default";
			}else{
				$this->template = $config['smarty']['template'];
			}
			
			$this->template_dir .= $this->template;
			$this->compile_id = $this->template;
			
			// Assign some vars
			$this->assign("template_dir", $this->template_dir);
			$this->register_modifier('truncate', 'truncate');
			$this->register_modifier('bbcode', 'BBCode');
		}
		
		public function display_rss($file){
			global $config;
			$this->template_dir = str_replace($config['smarty']['template'], "rss", $this->template_dir);
			$this->display($file);
		}
		
		public function fetch_rss($file){
			global $config;
			$this->template_dir = $config['smarty']['template_dir'] ."rss/";
			return $this->fetch($file);
		}
	}

?>