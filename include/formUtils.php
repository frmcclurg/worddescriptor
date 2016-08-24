<?php 
   /**
    * @brief   Utilities related to HTML forms
    * @author  Fred R. McClurg
    * @date    November 13, 2015
    */

   /**
    * @brief   Find the IP address of the client
    * @return  string  IP address
    */
	function getClientIpAddress()
	{
		if (getenv('HTTP_CLIENT_IP'))
			$ipAddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipAddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipAddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
			$ipAddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipAddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipAddress = getenv('REMOTE_ADDR');
		else
			$ipAddress = 'unknown';

		return( $ipAddress );
	}  // function getClientIpAddress()


   /**
    * @brief   Convert every word in string to first letter uppercase
    * @param   $original    Word to convert
    * @param   $isIrish     Capitalize letter following Mc and Mac
    * @return  $initialCap  First letter uppercase each word
    */
	function firstLetterWordUpperCase( $original, $isIrish = FALSE )
	{
      // $initialCap = ucwords( strtolower( trim( $original ) ) );

      $lowercase = strtolower( trim( $original ) );
      $pattern = '/\b./';

      $initialCap = preg_replace_callback( $pattern, function( $matches ) {
      	return( strtoupper( $matches[0] ) );
      }, $lowercase );

		return( $initialCap );
	}  // function firstLetterWordUpperCase()


   /**
    * @brief   Build accordian list of words sorted by first letter
    * @param   Array of words
    * @return  HTML accordian of words in a table
    */
	function buildAccordianWords( $wordList )
	{
		$indexAssoc = array();
		
		foreach ( $wordList as $word )
		{
			// obtain first character of word
         $pattern = '/^(.).*$/';
         $replacement = '$1';
         $letter = preg_replace( $pattern, $replacement, $word );

         if ( ! is_array( $indexAssoc[$letter] ) )
         {
            $indexAssoc[$letter] = array();
         }

         // create unique list
         array_push( $indexAssoc[$letter], $word );

		}  // foreach ( $word as $wordList )
		
		$indexList = array_keys( $indexAssoc );
		sort( $indexList );
		
		// initialize string
      $html = "                  <div id='wordAccordion'>\n";
      
		foreach ( $indexList as $letter )
		{
         $html .= sprintf( "                     <h3>%s</h3>\n
                     <div>
                        <table class='table table-striped table-hover table-condensed'>\n",
         		      $letter );
         
         foreach ( $indexAssoc[$letter] as $word )
         {
            $html .= sprintf( "
                           <tr> 
                              <td> %s </td> 
                              <td> 
                                 <a href='javascript:void(0)'
                                    class='btn btn-info btn-xs thesaurus' 
                                    data-record-word='%s'> Similar </a> 
                              </td> 
                           </tr>\n", $word, $word );
         }

         $html .= sprintf( "
                        </table>
                     </div>  <!-- %s -->\n", $letter );
		}

		return( $html );
	}  // function buildAccordianWords()


   /**
    * @brief   Determine if word is valid
    * @param   $word     Word to validate
    * @return  $isValid  Returns true if word is valid
    */
	function isValidWord( $word )
	{
		// initialize variables
      $isValid = TRUE;
      	
		// exclude words matching these regular expressions
		$regexList = array( '/^[a-zA-Z]{1,2}$/',  // one or two character word
				              '/\s/' );    // word with spaces
		
      foreach ( $regexList as $regex )
      {
         if ( preg_match( $regex, $word ) )
         {
            $isValid = FALSE;
            break;
         }
      }

		return( $isValid );
	}  // function isValidWord()

?>
