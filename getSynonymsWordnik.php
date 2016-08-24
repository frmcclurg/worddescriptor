<?php
   require_once('include/formUtils.php');
   require_once('include/wordnik/wordnik/Swagger.php');
   $myAPIKey = 'a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5';
   $client = new APIClient( $myAPIKey, 'http://api.wordnik.com/v4' );
   
   $wordParam = $_REQUEST['word'];
   
   // use worknik word api
   $wordApi = new WordApi( $client );

   $relationshipTypes = null; 
   $useCanonical = TRUE;
   $limitPerRelationshipType = 100;
   $obj = $wordApi->getRelatedWords( $wordParam, $relationshipTypes, $useCanonical, $limitPerRelationshipType);
   // printf( "<pre>%s</pre><p>\n", var_export( $obj, TRUE ) );
   
   // exclude these word categories
   $excludeTypes = array( "cross-reference", 
   		                 "rhyme",
   		                 // "same-context",
   		                 "unknown" );
   
   $words = array();
   
   foreach( $obj as $category )
   {
   	$wordType = $category->relationshipType;
   	
      if ( ! in_array( $wordType, $excludeTypes ) )
      {
      	if ( $wordType == "etymologically-related-term" )
      	{
            $wordType = "related-term";
      	}

         $wordType = firstLetterWordUpperCase( $wordType );
         // printf( "%s<br>\n", $wordType );

         $words[$wordType] = array();
      
         foreach( $category->words as $word )
         {
         	if ( isValidWord( $word ) )
         	{
               $word = firstLetterWordUpperCase( $word );
               // printf( "&nbsp; &nbsp; &nbsp; %s<br>\n", $word );
               array_push( $words[$wordType], $word );
         	}
         }
      }
   }
?>
   
<script>
$(function() {
   $( "#tabs" ).tabs({
      collapsible: true
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
      
});  // $(function() {
</script>
   
<div id="tabs">
   <ul>
<?php 
   foreach( $words as $wordType => $wordList )
   {
      printf( "      <li><a href='#%s'>%s</a></li>\n", $wordType, $wordType );
   }
?>
   </ul>

<?php
   foreach( $words as $wordType => $wordList )
   {
      printf( "   <div id='%s'>\n", $wordType );
      	
      sort( $wordList );
      
      foreach( $wordList as $word )
      {
         printf( "      <a class='btn btn-info btn-xs thesaurus'
                  data-record-word='%s'>%s</a>\n", $word, $word );
      }

      printf( "   </div>\n" );
   }
?>

</div>