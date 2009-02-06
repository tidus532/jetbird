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

/*
 * Thanks to http://nadeausoftware.com/articles/2007/9/php_tip_how_strip_punctuation_characters_web_page and the other articles referenced there
 * for the code, the following function is licensed under the OSI BSD
 */

function clean_text( $text )
{
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
		$text = clean_text($text);
		
		//splitting the words with mb_split as the explode() function isn't safe on UTF-8
		mb_regex_encoding( "utf-8" );
		$text = mb_split( ' +', $text );
		
		return $text;
}

/*
 * This function fetches the id of each word.
 * an array is returned in word => id format.
 * returns false if there are no results.
 */
function get_word_id($words) {
	$index = get_index();
		foreach($words as $word) {
			$word_id[$word] = $index[$word];
		}
	if(empty($word_id)) {
		return false;
	}
	else
	{
		return $word_id;
	}
}

/*
 * This function gets the index out of the database used for searching.
 * Use this function to supply index_title and index_text an index.
 */
function get_index() {
	global $config;
	global $dbconnection;
	$dbconnection = new database_handler;
	$query = "SELECT * FROM search_index";
	$result = $dbconnection->query($query);
	while($row = mysql_fetch_array($result)) {
		$index[$row['word']] = $row['id'];
	}
	return $index;
}

/*
 * This function indexes titles
 * $index must we in the format of word => id
 */
function index_title($title, $index, $post_id) {
	//cleaning and splitting text
	$title = split_text($title);
	$title = array_unique($title);
	
	foreach($title as $word) {
		if(empty($index[$word])) {
			$query = "INSERT INTO search_index (word) VALUES ('". addslashes($word) ."')";
			$dbconnection->query($query);
			$index[$word] = $dbconnection->last_insert_id;
		}
		$query = "	INSERT INTO search_word(word_id, post_id, title_match) 
					VALUES ('$index[$word]', '$post_id', 1)";
		$dbconnection->query($query);
	}
return true;	
}

/*
 * This function indexes text
 * $index must we in the format of word => id
 */
function index_text($text, $index, $post_id) {
	$text = split_text($text);
	$text = array_unique($text);
	
	foreach($text as $word) {
		if(empty($index[$word])) {
			$query = "INSERT INTO search_index (word) VALUES ('". addslashes($word) ."')";
			$dbconnection->query($query);
			$index[$word] = $dbconnection->last_insert_id;
		}
		$query = "	INSERT INTO search_word(word_id, post_id) 
					VALUES ('$index[$word]', '$post_id')";
		$dbconnection->query($query);
	}
return true;
}

/*
 * Returns an array with the post id's that have a title match for the provided word id's
 * NOTE: these results are not sorted in ANY way, use the process_results if you want a array sorted on importance
 */
function search_title($word_id) {
	foreach($word_id as $id) {
		if(empty($sub_query)) {
			$sub_query = " word_id = '". $id ."' AND title_match = 1";
		} 
		else 
		{
			$sub_query .= " OR word_id = '". $id ."' AND title_match = 1";
		}
	}
	$query = "  SELECT * 
				FROM search_word
				WHERE ". $sub_query."";
	$result = $dbconnection->query($query);
	while($row = mysql_fetch_array($result)) {
		$post_id[] = $row['post_id'];
	}
	return $post_id;
}

/*
 * Returns an array with the post id's that have a text match for the provided word id's.
 * NOTE: not sorted, you must use process_results.
 */
function search_text($word_id) {
	foreach($word_id as $id) {
		if(empty($sub_query)) {
			$sub_query = " word_id = '". $id ."' AND title_match = 0";
		} 
		else 
		{
			$sub_query .= " OR word_id = '". $id ."' AND title_match = 0";
		}
	}
	$query = "  SELECT * 
				FROM search_word
				WHERE ". $sub_query."";
	$result = $dbconnection->query($query);
	while($row = mysql_fetch_array($result)) {
		$post_id[] = $row['post_id'];
	}
	return $post_id;
}


/*
 * takes the results of the search_title and search_text and orders them, returns an array with all the post data.
 */
function process_results($text, $title) {
	// Sorting title and text on occurence, the more a post_id is in the array (thus more words) the higher it will be ranked in the array.
	$title = array_count_values($title);
	$text = array_count_values($text);
	arsort($title, SORT_NUMERIC);
	arsort($text, SORT_NUMERIC);
	
	//Finding words that are both in the title and the text and put them up front.
}

?>