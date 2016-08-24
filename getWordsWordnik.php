<?php
   require_once('include/formUtils.php');
   require_once('include/wordnik/wordnik/Swagger.php');
   require_once('include/wordnik/wordnik/WordsApi.php');
   $myAPIKey = 'a2a73e7b926c924fad7001ca3111acd55af2ffabf50eb4ae5';
   $client = new APIClient( $myAPIKey, 'http://api.wordnik.com/v4' );
   
   // use worknik word api
   $wordsApi = new WordsApi( $client );

   // initialize function parameters
   $wordParam = sprintf( "*%s*", $_REQUEST['term'] );  // use wildcards
   
   $includePartOfSpeech = null;
   $excludePartOfSpeech = null;
   $caseSensitive  =  FALSE;
   $minCorpusCount = null;
   $maxCorpusCount = null;
   $minDictionaryCount = 1;
   $maxDictionaryCount = null;
   $minLength = 3;
   $maxLength = null;
   $skip = null;
   $limit = 10;
   $obj = $wordsApi->searchWords( $wordParam, $includePartOfSpeech, $excludePartOfSpeech, $caseSensitive, $minCorpusCount, $maxCorpusCount, $minDictionaryCount, $maxDictionaryCount, $minLength, $maxLength, $skip, $limit );
   // printf( "<pre>%s</pre><p>\n", var_export( $obj, TRUE ) );
   
   $wordObjList = $obj->searchResults;
   $wordList = array();
   
   foreach ( $wordObjList as $wordObj )
   {
   	$word = $wordObj->word;
	   $initalCase = firstLetterWordUpperCase( $word );
   	array_push( $wordList, $initalCase );
   	
   	// printf( "%s<br>", $word );
   }

   sort( $wordList );
   $wordJson = json_encode( $wordList );
  
   printf( "%s", $wordJson );
?>