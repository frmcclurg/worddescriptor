<?php 
   /**
    * @brief Collects three words from the user
    * @author Fred R. McClurg
    * @date   October 24, 2015
    * @see    http://services.aonaware.com/DictService/DictService.asmx/MatchInDict?dictId=gcide&word=ize&strategy=substring
    * @see    http://services.aonaware.com/DictService/DictService.asmx/MatchInDict?dictId=wn&word=ize&strategy=substring
    * @see    http://api.wordnik.com:80/v4/word.json/beautiful/relatedWords?useCanonical=false&relationshipTypes=synonym&limitPerRelationshipType=20&api_key=a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5
    */
  
   /**
    * @example
    * 
    * $url = 'http://services.aonaware.com/...';
    * // $xmlstring = file_get_contents( 'http://services/aonaware.com/...' );
    * $xml = simplexml_load_string($url, "SimpleXMLElement", LIBXML_NOCDATA);
    * if ( $xml === FALSE ) {
    *    // error.  something went wrong
    * }
    * else {
    *    // process xml
    *    $json = json_encode($xml);
    *    $array = json_decode($json,TRUE);
    * }
    */

   require_once( 'include/errors.php' );
   require_once( 'include/login.php' );
   require_once( 'include/dbUtils.php' );
   require_once( 'include/formUtils.php' );

   $friendFirst = "Marty";
   $friendLast = "McClurg";

   $title = "Word Descriptor";
   $subTitle = sprintf( "<p>For a birthday present, I am asking several
   		friends for three words that <em><b>best</b></em> describe %s. &nbsp; I am
   		going to take all your encouraging words and turn them into a word cloud
   		collage and present it as a gift. &nbsp; Thanks for finding the perfect
   		words, I think they will be treasured.<p>
         
         <p>Note: Duplicate words are okay. &nbsp; If several people submit the
   		same word, those words will show up as larger font in the word cloud.</p>
   		
   		<p><em>After entering your words, don't forget to press the dark blue button
   		below the form to submit the form!</em></p><br>", $friendFirst );
   
   // initialize messages
   $status = "";
   $error = "";
   
   if ( isset( $_REQUEST['doit'] ) )  // form submitted
   {
      /* initialize variables */
      $notes = trim( $_REQUEST['notes'] );
      $firstLastName = trim( $_REQUEST['firstLastName'] );
      $remoteAddr = getClientIpAddress();
      $httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
      $httpReferer = $_SERVER['HTTP_REFERER'];
         
      if ( ! isAlreadySubmitted( $conn, $firstLastName, 
      		                     $friendFirst, $friendLast, 
      		                     getClientIpAddress() ) )
      {
         $status = sprintf( "Thank you %s for submitting your three special words and
               being part of creating this birthday gift. &nbsp; I could not 
               have done it without each of your contributions! &nbsp; I know 
               %s will very much appreciate your kindness.", 
                                $firstLastName, $friendFirst );
      }
      else
      {
         $error = sprintf( "%s, you have already submitted your excellent words. &nbsp; 
               Three words will be sufficient. &nbsp; Thanks for your participation and
               willingness to make %s's birthday meaningful!",
                              $firstLastName, $friendFirst );
      }

      if ( ! $error )  // no error condition
      {
         // build the SQL statement for the guest
         $sql = "
            INSERT INTO guest
               (name, friend_first, friend_last, 
         		 notes, ip_address, browser, referer)
               VALUES (?, ?, ?, ?, ?, ?, ?)";

         /* create a prepared statement */
         $stmt = mysqli_prepare( $conn, $sql );
         
         /* bind parameters with markers */
         mysqli_stmt_bind_param( $stmt, 'sssssss',
               $firstLastName,
               $friendFirst,
               $friendLast,
               $notes, 
               $remoteAddr,
               $httpUserAgent,
               $httpReferer );
         
         /* execute prepared statement */
         mysqli_stmt_execute($stmt);
         
         $guestId = mysqli_insert_id( $conn );
         
         // printf( "%d guest \"%s\" inserted.<br>\n",
                    // mysqli_stmt_affected_rows($stmt),
                    // $firstLastName );

         $wordList = array( $_REQUEST['firstWord'],
                            $_REQUEST['secondWord'],
                            $_REQUEST['thirdWord'] );

         foreach ( $wordList as $wordInput )
         {
            $word = firstLetterWordUpperCase( $wordInput );

            // build the SQL statement for the words
            $sql = "
               INSERT INTO word
                  (name)
                  VALUES (?)";

            /* create a prepared statement */
            $stmt = mysqli_prepare( $conn, $sql );
            
            /* bind parameters with markers */
            mysqli_stmt_bind_param( $stmt, 's', $word );
         
            /* execute prepared statement */
            mysqli_stmt_execute( $stmt );
            
            $wordId = mysqli_insert_id( $conn );

            // printf( "%d word \"%s\" inserted.<br>\n", 
                       // mysqli_stmt_affected_rows($stmt),
                       // $word );

            // build the SQL statement for the words
            $sql = "
               INSERT INTO guest_2_word
                  (guest_id, word_id)
                  VALUES (?, ?)";

            /* create a prepared statement */
            $stmt = mysqli_prepare( $conn, $sql );
            
            /* bind parameters with markers */
            mysqli_stmt_bind_param( $stmt, 'ii',
                  $guestId, $wordId );
         
            /* execute prepared statement */
            mysqli_stmt_execute( $stmt );
            
            // printf( "%d guest_2_word: %d, %d inserted.<br>\n", 
                       // mysqli_stmt_affected_rows($stmt),
                       // $guestId, $wordId );

         }  // foreach ( $wordList as $word )

         /* close statement and connection */
         mysqli_stmt_close($stmt);
         
         /* close connection */
         mysqli_close( $conn );
      }  // if ( ! $error )

   }  // if ( $_REQUEST['doit'] )
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="icon" href="images/wd_28x16.png">

   <title><?= $title ?></title>

   <!-- Styles for jQuery UI -->
   <!-- <link href="http://code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css" rel="stylesheet"> -->
   <link href="http://code.jquery.com/ui/1.11.4/themes/flick/jquery-ui.css" rel="stylesheet">

   <!-- Bootstrap core CSS -->
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
   
   <!-- Optional theme -->
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet">

   <!-- jQuery (must be before Bootstrap) -->
   <script src="http://code.jquery.com/jquery-1.10.2.js"></script>

   <!-- Latest compiled and minified JavaScript -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

   <!-- jQuery UI (must be after Bootstrap) -->
   <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

   <!-- Local styles for this template -->
   <link href="css/styles.css" rel="stylesheet">

   <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
   
<script>
$(document).ready(function() {

   $( "#synonymDialog" ).dialog({
      autoOpen: false,
      height: 300,
      width: 485,
      open: function() {
		   var word = $(this).data("record-word");
         var firstLabel = "as First";
         var secondLabel = "as Second";
         var thirdLabel = "as Third";

         $( this ).dialog( "option", "buttons", 
            [
               {
                  text: firstLabel,
                  icons: {
                     primary: "ui-icon-clipboard"
                  },
                  click: function() {
              		   word = $(this).data("record-word");
                     $( "#firstWord" ).val( word );
                     $( this ).dialog( "close" );
                  }
               },
               {
                  text: secondLabel,
                  icons: {
                     primary: "ui-icon-clipboard"
                  },
                  click: function() {
              		   word = $(this).data("record-word");
                     $( "#secondWord" ).val( word );
                     $( this ).dialog( "close" );
                  }
               },
               {
                  text: thirdLabel,
                  icons: {
                     primary: "ui-icon-clipboard"
                  },
                  click: function() {
              		   word = $(this).data("record-word");
                     $( "#thirdWord" ).val( word );
                     $( this ).dialog( "close" );
                  }
               },
               {
                  text: "Close",
                  click: function() {
                     $( this ).dialog( "close" );
                  }
               }
            ]
         );

         // $( "div.ui-dialog-buttonset" ).prepend( 
               // "<div class='ui-dialog-buttonset-title'>Insert word \"" + word + "\" ...</div>" );
       }
   });
 
   $( ".thesaurus" ).click(function() {
      var word = $(this).data("record-word");
      $( "#synonymDialog" ).dialog( "option", "title", 'Words similar to "' + word + '"' )
         .data( "record-word", word )
         .load( "getSynonymsWordnik.php", { word: word } )  // $( "#synonymDialog" ).load( "getSynonyms.php?word=" + word );
         .dialog( "open" );

		if ( $( "div.ui-dialog-buttonset-title" ).length )  // div exists
		{
			$( "div.ui-dialog-buttonset-title" ).html( 
					"Insert word \"" + word + "\" ..." );
		}
		else
		{
			$( "div.ui-dialog-buttonset" ).prepend( 
					"<div class='ui-dialog-buttonset-title'>Insert word \"" + word + "\" ...</div>" );
		}
   });
      

   /**
    * @brief Handles text autocompletion of words
    */
   $( ".words" ).autocomplete({
      source: "getWordsWordnik.php",
      minLength: 3,
      dataType: "jsonp"
	});  // $( ".words" ).autocomplete

	$( "#wordAccordion" ).accordion({
		heightStyle: "content",
		collapsible: true,
		active: false
	});
				 
});  // $(document).ready(function()
</script>
</head>

<body>

<div id="synonymDialog" title="Synonym Dialog"></div>

<div class="container-fluid">

   <div class="jumbotron">
      <img src="images/wordDescriptor_294x100.png"
           alt="Word Descriptor" 
           class="img-responsive" 
           id="logo" />
   </div>
   
   <div class="page-header">
      <h1 id="synonym-title"><?= $title ?></h1>
   </div>

<?php 
   if ( ! isset( $_REQUEST['doit'] ) )  // prior to form submission
   {
      printf( "%s\n", $subTitle );
?>
   <form method="post" 
         action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="row">
         <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Name</h3>
                     </div>
                     <div class="panel-body">
                        <div class="form-group">
                           <label for="firstLastName"
                                  class="control-label">
                              Enter Full Name:
                           </label>
                           <input type="text" 
                                  name="firstLastName" 
                                  id="firstLastName" 
                                  placeholder="First Last" 
                                  pattern="^\s*[a-zA-Z]{2,} [a-zA-Z]{2,}\s*$" 
                                  class="form-control" 
                                  required>
                        </div>  <!-- form-group -->
                     </div>  <!-- panel-body -->
                  </div>  <!-- panel-default -->
               </div>  <!-- col-12 -->
            </div>  <!-- row -->

            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Descriptive Words</h3>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <div class="form-group">
                                 <label for="firstWord"
                                        class="control-label">
                                    First Word:
                                 </label>
                                 <input type="text" 
                                        name="firstWord" 
                                        id="firstWord" 
                                        placeholder="Single or hyphenated word" 
                                        pattern="^\s*[a-zA-Z]{3,}(-?[a-zA-Z])*\s*$" 
                                        class="form-control words" 
                                        required>
                              </div>  <!-- form-group -->
                           </div>  <!-- col -->
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <div class="form-group">
                                 <label for="secondWord"
                                        class="control-label">
                                    Second Word:
                                 </label>
                                 <input type="text" 
                                        name="secondWord" 
                                        id="secondWord" 
                                        placeholder="Single or hyphenated word" 
                                        pattern="^\s*[a-zA-Z]{3,}(-?[a-zA-Z])*\s*$" 
                                        class="form-control words" 
                                        required>
                              </div>  <!-- form-group -->
                           </div>  <!-- col-4 -->
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <div class="form-group">
                                 <label for="thirdWord"
                                        class="control-label">
                                    Third Word:
                                 </label>
                                 <input type="text" 
                                        name="thirdWord" 
                                        id="thirdWord" 
                                        placeholder="Single or hyphenated word" 
                                        pattern="^\s*[a-zA-Z]{3,}(-?[a-zA-Z])*\s*$" 
                                        class="form-control words" 
                                        required>
                              </div>  <!-- form-group -->
                           </div>  <!-- col-4 -->
                        </div>  <!-- row -->
                     </div>
                  </div>
               </div>  <!-- col -->
            </div>  <!-- row -->

            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Personal Note</h3>
                     </div>
                     <div class="panel-body">
                        <div class="form-group">
                           <label for="notes"
                                  class="control-label">
                              Enter Additional Remarks (optional):
                           </label> <br>
                           <textarea rows="3"
                                     name="notes"
                                     class="form-control"></textarea>
                        </div>  <!-- form-group -->
                     </div>
                  </div>
               </div>  <!-- col -->
            </div>  <!-- row -->

            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="panel-body">
                     <div style="text-align: center">
                        <button type="submit" name="doit" 
                                class="btn btn-primary"
                                disabled >
                           Submit Your Words
                        </button>
                     </div>
                  </div>  <!-- panel-body -->
               </div>  <!-- col -->
            </div>  <!-- row -->
         </div>  <!-- col-md-9 -->

         <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Words Others Selected</h3>
               </div>
               <div class="panel-body">
                  <?= buildAccordianWords( getWordsSubmitted( $conn ) ); ?>
               </div>  <!-- panel-body -->
            </div>  <!-- panel-default -->
         </div>  <!-- col-3 -->
      </div>  <!-- row -->
                     
      <input type="hidden" name="friendFirst" value="<?= $friendFirst ?>" />
      <input type="hidden" name="friendLast" value="<?= $friendLast ?>" />
   </form>
<?php 
   }
   else  // form submitted
   {
      if ( $status || $error )
      {
         if ( $status )
         {
            printf( "<div class='alert alert-success' role='alert'>
                        %s
                     </div>", $status );
         }

         if ( $error )
         {
            printf( "<div class='alert alert-danger' role='alert'>
                        %s
                     </div>", $error );
         }
      }
   }
?>

      <footer class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- <div class="panel panel-default"> -->
               <div class="panel-body well well-sm">
                  Problems or questions? &nbsp; 
                  Contact: <a href="mailto:frmcclurg@gmail.com">Fred McClurg</a>
               </div>  <!-- panel-body -->
            <!-- </div> -->  <!-- panel-default -->
         </div>  <!-- col-12 -->
      </footer>  <!-- row -->

</div> <!-- container-fluid -->

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>

<?php 
   /* include google analytics */
   require_once( 'include/analytics.php' );
?>
</body>
</html>
