<?php 
   /**
    * @file    dbUtils.php
    * @brief   Utilities related to the database
    * @author  Fred R. McClurg
    * @date    November 13, 2015
    */

   /**
    * @brief  Queries database to determine if user at IP has already submitted.
    * @param  $conn           Database connection
    * @param  $firstLastName  First and last name of current user (submitter)
    * @param  $friendFirst    First name of the friend submission is regarding
    * @param  $friendLast     Last name of the friend submission is regarding
    * @param  $ipAddress      The IP address of user (submitter)
    * @return $isSubmitted    Returns true if user and IP are in database
    */
	function isAlreadySubmitted( $conn, $firstLastName,
			                       $friendFirst, $friendLast,
			                       $ipAddress )
	{
		// Build a an SQL statement
		$sql = "
      SELECT name, friend_first, friend_last, ip_address
      FROM guest
      WHERE ( name = ? ) AND
				( friend_first = ? ) AND
				( friend_last = ? ) AND
            ( ip_address = ? )";
		
		// Create a prepared statement
	   if ( $stmt = mysqli_prepare( $conn, $sql ) )
	   {
			// Define the bind parameters for markers
			mysqli_stmt_bind_param( $stmt, 'ssss',
					$firstLastName, $friendFirst, $friendLast, $ipAddress );
			 
			// Execute the SQL statement
			mysqli_stmt_execute( $stmt );
			
			// Store result
			mysqli_stmt_store_result( $stmt );
			
			// Store result
			$numRows = mysqli_stmt_num_rows( $stmt );
			
			if ( $numRows > 0 )
			{
				$isSubmitted = TRUE;
			}
			else
			{
				$isSubmitted = FALSE;
			}
	   }
		
		return( $isSubmitted );
	}  // function isAlreadySubmitted()


   /**
    * @brief   Displays a list of distinct words submitted to the database
    * @param   $conn   Database connection
    * @return  $words  Array of words submitted
    */
	function getWordsSubmitted( $conn )
	{
		// Build the SQL statement
		$sql = "
      SELECT DISTINCT name
      FROM word
      ORDER BY name";
		
      // 4. Execute the SQL statement
      $result = mysqli_query( $conn, $sql );
		
      if ( ! $result )  // SQL failed
      {
         die( "Could not execute SQL
               <pre>$sql</pre> <br />" .
               mysqli_error( $conn ) );
      }
   
      // declare blank array
      $words = array();
      
      // 5. Obtain the SQL results
      while ( $row = mysqli_fetch_assoc( $result ) )
      {
         array_push( $words, $row['name'] );
      }
		
		return( $words );
	}  // function getWordsSubmitted()
?>
