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
	class search_class {
		
				function debug($var) {					
					die(var_dump($var));
				}
				
				function clean_text($text) {
				$text = stripslashes($text);
				/*
				 * Removing HTML tags
				 */
				    $text = preg_replace(
				        array(
				          // Remove invisible content
				            '@<head[^>]*?>.*?</head>@siu',
				            '@<style[^>]*?>.*?</style>@siu',
				            '@<script[^>]*?.*?</script>@siu',
				            '@<object[^>]*?.*?</object>@siu',
				            '@<embed[^>]*?.*?</embed>@siu',
				            '@<applet[^>]*?.*?</applet>@siu',
				            '@<noframes[^>]*?.*?</noframes>@siu',
				            '@<noscript[^>]*?.*?</noscript>@siu',
				            '@<noembed[^>]*?.*?</noembed>@siu',
				          // Add line breaks before and after blocks
				            '@</?((address)|(blockquote)|(center)|(del))@iu',
				            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				            '@</?((table)|(th)|(td)|(caption))@iu',
				            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				            '@</?((frameset)|(frame)|(iframe))@iu',
				        ),
				        array(
				            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				            "\n\$0", "\n\$0",
				        ),
				        $text );
				        
				    //decoding HTML entities for further processing
				   	$text =  html_entity_decode( $text, ENT_QUOTES, "utf-8" );
			    
				/*
				 * Stripping all punctuations.
				 */
				    $urlbrackets    = '\[\]\(\)';
				    $urlspacebefore = ':;\'_\*%@&?!' . $urlbrackets;
				    $urlspaceafter  = '\.,:;\'\-_\*@&\/\\\\\?!#' . $urlbrackets;
				    $urlall         = '\.,:;\'\-_\*%@&\/\\\\\?!#' . $urlbrackets;
				 
				    $specialquotes  = '\'"\*<>';
				 
				    $fullstop       = '\x{002E}\x{FE52}\x{FF0E}';
				    $comma          = '\x{002C}\x{FE50}\x{FF0C}';
				    $arabsep        = '\x{066B}\x{066C}';
				    $numseparators  = $fullstop . $comma . $arabsep;
				 
				    $numbersign     = '\x{0023}\x{FE5F}\x{FF03}';
				    $percent        = '\x{066A}\x{0025}\x{066A}\x{FE6A}\x{FF05}\x{2030}\x{2031}';
				    $prime          = '\x{2032}\x{2033}\x{2034}\x{2057}';
				    $nummodifiers   = $numbersign . $percent . $prime;
				 
				    $text =  preg_replace(
				        array(
				        // Remove separator, control, formatting, surrogate,
				        // open/close quotes.
				            '/[\p{Z}\p{Cc}\p{Cf}\p{Cs}\p{Pi}\p{Pf}]/u',
				        // Remove other punctuation except special cases
				            '/\p{Po}(?<![' . $specialquotes .
				                $numseparators . $urlall . $nummodifiers . '])/u',
				        // Remove non-URL open/close brackets, except URL brackets.
				            '/[\p{Ps}\p{Pe}](?<![' . $urlbrackets . '])/u',
				        // Remove special quotes, dashes, connectors, number
				        // separators, and URL characters followed by a space
				            '/[' . $specialquotes . $numseparators . $urlspaceafter .
				                '\p{Pd}\p{Pc}]+((?= )|$)/u',
				        // Remove special quotes, connectors, and URL characters
				        // preceded by a space
				            '/((?<= )|^)[' . $specialquotes . $urlspacebefore . '\p{Pc}]+/u',
				        // Remove dashes preceded by a space, but not followed by a number
				            '/((?<= )|^)\p{Pd}+(?![\p{N}\p{Sc}])/u',
				        // Remove consewcutive spaces
				            '/ +/',
				        ),
				        ' ',
				        $text );
				        
			    /*
			     * Stripping all symbols
			     */
					$plus   = '\+\x{FE62}\x{FF0B}\x{208A}\x{207A}';
				    $minus  = '\x{2012}\x{208B}\x{207B}';
				 
				    $units  = '\\x{00B0}\x{2103}\x{2109}\\x{23CD}';
				    $units .= '\\x{32CC}-\\x{32CE}';
				    $units .= '\\x{3300}-\\x{3357}';
				    $units .= '\\x{3371}-\\x{33DF}';
				    $units .= '\\x{33FF}';
				 
				    $ideo   = '\\x{2E80}-\\x{2EF3}';
				    $ideo  .= '\\x{2F00}-\\x{2FD5}';
				    $ideo  .= '\\x{2FF0}-\\x{2FFB}';
				    $ideo  .= '\\x{3037}-\\x{303F}';
				    $ideo  .= '\\x{3190}-\\x{319F}';
				    $ideo  .= '\\x{31C0}-\\x{31CF}';
				    $ideo  .= '\\x{32C0}-\\x{32CB}';
				    $ideo  .= '\\x{3358}-\\x{3370}';
				    $ideo  .= '\\x{33E0}-\\x{33FE}';
				    $ideo  .= '\\x{A490}-\\x{A4C6}';
				 
				    $text =  preg_replace(
				        array(
				        // Remove modifier and private use symbols.
				            '/[\p{Sk}\p{Co}]/u',
				        // Remove mathematics symbols except + - = ~ and fraction slash
				            '/\p{Sm}(?<![' . $plus . $minus . '=~\x{2044}])/u',
				        // Remove + - if space before, no number or currency after
				            '/((?<= )|^)[' . $plus . $minus . ']+((?![\p{N}\p{Sc}])|$)/u',
				        // Remove = if space before
				            '/((?<= )|^)=+/u',
				        // Remove + - = ~ if space after
				            '/[' . $plus . $minus . '=~]+((?= )|$)/u',
				        // Remove other symbols except units and ideograph parts
				            '/\p{So}(?<![' . $units . $ideo . '])/u',
				        // Remove consecutive white space
				            '/ +/',
				        ),
				        ' ',
				        $text );
				        
				//finally convert the string to lowercase
			    $text = mb_strtolower( $text, "utf-8" );
			    
			    return $text;
			}

		function split_text($text)
		{
				//we assume from now on that all the text we recieve is UTF-8.
				
				//remove all punctuations and unwanted symbols.
				$text = $this->clean_text($text);
				
				//splitting the words with mb_split as the explode() function isn't safe on UTF-8
				mb_regex_encoding( "utf-8" );
				$text = mb_split( ' +', $text );
				
				return $text;
		}
		
		function get_word_id($words) {			
			global $db;
			$index = $this->get_index();
			foreach($words as $word) {
				if(!empty($index[$word])) {
				$word_id[$word] = $index[$word];
				}
			}
			if(empty($word_id)) {
				return false;
			}
			else {
				return $word_id;
			}
		}
		
		function get_index() {
			global $db;
			$query = "SELECT * FROM search_index";
			$result = $db->query($query);
			while($row = mysql_fetch_array($result)) {
				$index[$row['word']] = $row['id'];
			}
			return $index;
		}
	
		function index($text, $post_id, $weight, $group_id) {
			global $db;
			$index = $this->get_index();
			$text = $this->split_text($text);
			$text = array_unique($text);
			
			foreach($text as $word) {
				if(empty($index[$word])) {
					$query = "INSERT INTO search_index (word) VALUES ('". addslashes($word) ."')";
					$db->query($query);
					$index[$word] = $db->last_insert_id;
				}
				$query = "	INSERT INTO search_word(word_id, post_id, weight, group_id) 
							VALUES ('$index[$word]', '$post_id', $weight, $group_id)";
				$db->query($query);
			}
			return true;
		}
	
	
		function search($text, $group_id) {
			//die(var_dump($text));
			$text = $this->split_text($text);
			
			$word_id = $this->get_word_id($text);
			if(!$word_id) {
				return false;
			}
			global $db;
			foreach($word_id as $id) {
				if(empty($sub_query)) {
					$sub_query = " word_id = '". $id ."' AND group_id = '". $group_id ."'";
				} 
				else 
				{
					$sub_query .= " OR word_id = '". $id ."' AND group_id = '". $group_id ."'";
				}
			}
			$query = "  SELECT * 
						FROM search_word
						WHERE ". $sub_query." ORDER BY weight DESC";
			//$this->debug($query);
			$result = $db->query($query);
			
			while($row = mysql_fetch_array($result)) {
				if(!empty($post_id[$row['$post_id']])) {
					$post_id[$row['post_id']] = $row['weight'];	
				} else {
					$weight = $post_id[$row['post_id']] + $row['weight'];
					$post_id[$row['post_id']] = $weight;
				}
			}
			arsort($post_id);
			
			$post = $this->get_post($post_id);
			return $post;
		}
		
		function get_post($post_id) {
			$i = 0;
			global $db;
			foreach($post_id as $id => $weight) {
				$query = "SELECT post.* 
					FROM post
					WHERE post.post_id = ". $id ."";
				
				$result = $db->query($query);
				while ($row = mysql_fetch_array($result)) {
					$post[$i]['post_id'] = $row['post_id'];
					$post[$i]['post_title'] = $row['post_title'];
					$post[$i]['post_author'] = $row['post_author'];
					$post[$i]['post_content'] = $row['post_content'];
					$post[$i]['comment_status'] = $row['comment_status'];
				}
			$i++;
			}
				
		return $post;
		}


	
}
?>