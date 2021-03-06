<?php
/**
 *  Copyright 2011 Wordnik, Inc.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

/**
 *
 * NOTE: This class is auto generated by the swagger code generator program. Do not edit the class manually.
 */
class WordsApi {

	function __construct($apiClient) {
	  $this->apiClient = $apiClient;
	}

  /**
	 * searchWords
	 * Searches words
   * query, string: Search query (required)
   * includePartOfSpeech, string: Only include these comma-delimited parts of speech (optional)
   * excludePartOfSpeech, string: Exclude these comma-delimited parts of speech (optional)
   * caseSensitive, string: Search case sensitive (optional)
   * minCorpusCount, int: Minimum corpus frequency for terms (optional)
   * maxCorpusCount, int: Maximum corpus frequency for terms (optional)
   * minDictionaryCount, int: Minimum number of dictionary entries for words returned (optional)
   * maxDictionaryCount, int: Maximum dictionary definition count (optional)
   * minLength, int: Minimum word length (optional)
   * maxLength, int: Maximum word length (optional)
   * skip, int: Results to skip (optional)
   * limit, int: Maximum number of results to return (optional)
   * @return WordSearchResults
	 */

   public function searchWords($query, $includePartOfSpeech=null, $excludePartOfSpeech=null, $caseSensitive=null, $minCorpusCount=null, $maxCorpusCount=null, $minDictionaryCount=null, $maxDictionaryCount=null, $minLength=null, $maxLength=null, $skip=null, $limit=null) {

  		//parse inputs
  		$resourcePath = "/words.{format}/search/{query}";
  		$resourcePath = str_replace("{format}", "json", $resourcePath);
  		$method = "GET";
      $queryParams = array();
      $headerParams = array();

      if($caseSensitive != null) {
  		  $queryParams['caseSensitive'] = $this->apiClient->toQueryValue($caseSensitive);
  		}
  		if($includePartOfSpeech != null) {
  		  $queryParams['includePartOfSpeech'] = $this->apiClient->toQueryValue($includePartOfSpeech);
  		}
  		if($excludePartOfSpeech != null) {
  		  $queryParams['excludePartOfSpeech'] = $this->apiClient->toQueryValue($excludePartOfSpeech);
  		}
  		if($minCorpusCount != null) {
  		  $queryParams['minCorpusCount'] = $this->apiClient->toQueryValue($minCorpusCount);
  		}
  		if($maxCorpusCount != null) {
  		  $queryParams['maxCorpusCount'] = $this->apiClient->toQueryValue($maxCorpusCount);
  		}
  		if($minDictionaryCount != null) {
  		  $queryParams['minDictionaryCount'] = $this->apiClient->toQueryValue($minDictionaryCount);
  		}
  		if($maxDictionaryCount != null) {
  		  $queryParams['maxDictionaryCount'] = $this->apiClient->toQueryValue($maxDictionaryCount);
  		}
  		if($minLength != null) {
  		  $queryParams['minLength'] = $this->apiClient->toQueryValue($minLength);
  		}
  		if($maxLength != null) {
  		  $queryParams['maxLength'] = $this->apiClient->toQueryValue($maxLength);
  		}
  		if($skip != null) {
  		  $queryParams['skip'] = $this->apiClient->toQueryValue($skip);
  		}
  		if($limit != null) {
  		  $queryParams['limit'] = $this->apiClient->toQueryValue($limit);
  		}
  		if($query != null) {
  			$resourcePath = str_replace("{" . "query" . "}",
  			                            $this->apiClient->toPathValue($query), $resourcePath);
  		}
  		//make the API Call
      if (! isset($body)) {
        $body = null;
      }
  		$response = $this->apiClient->callAPI($resourcePath, $method,
  		                                      $queryParams, $body,
  		                                      $headerParams);


      if(! $response){
          return null;
        }

  		$responseObject = $this->apiClient->deserialize($response,
  		                                                'WordSearchResults');
  		return $responseObject;

      }
  /**
	 * getWordOfTheDay
	 * Returns a specific WordOfTheDay
   * date, string: Fetches by date in yyyy-MM-dd (optional)
   * @return WordOfTheDay
	 */

   public function getWordOfTheDay($date=null) {

  		//parse inputs
  		$resourcePath = "/words.{format}/wordOfTheDay";
  		$resourcePath = str_replace("{format}", "json", $resourcePath);
  		$method = "GET";
      $queryParams = array();
      $headerParams = array();

      if($date != null) {
  		  $queryParams['date'] = $this->apiClient->toQueryValue($date);
  		}
  		//make the API Call
      if (! isset($body)) {
        $body = null;
      }
  		$response = $this->apiClient->callAPI($resourcePath, $method,
  		                                      $queryParams, $body,
  		                                      $headerParams);


      if(! $response){
          return null;
        }

  		$responseObject = $this->apiClient->deserialize($response,
  		                                                'WordOfTheDay');
  		return $responseObject;

      }
  /**
	 * reverseDictionary
	 * Reverse dictionary search
   * query, string: Search term (required)
   * findSenseForWord, string: Restricts words and finds closest sense (optional)
   * includeSourceDictionaries, string: Only include these comma-delimited source dictionaries (optional)
   * excludeSourceDictionaries, string: Exclude these comma-delimited source dictionaries (optional)
   * includePartOfSpeech, string: Only include these comma-delimited parts of speech (optional)
   * excludePartOfSpeech, string: Exclude these comma-delimited parts of speech (optional)
   * expandTerms, string: Expand terms (optional)
   * sortBy, string: Attribute to sort by (optional)
   * sortOrder, string: Sort direction (optional)
   * minCorpusCount, int: Minimum corpus frequency for terms (optional)
   * maxCorpusCount, int: Maximum corpus frequency for terms (optional)
   * minLength, int: Minimum word length (optional)
   * maxLength, int: Maximum word length (optional)
   * includeTags, string: Return a closed set of XML tags in response (optional)
   * skip, string: Results to skip (optional)
   * limit, int: Maximum number of results to return (optional)
   * @return DefinitionSearchResults
	 */

   public function reverseDictionary($query, $findSenseForWord=null, $includeSourceDictionaries=null, $excludeSourceDictionaries=null, $includePartOfSpeech=null, $excludePartOfSpeech=null, $expandTerms=null, $sortBy=null, $sortOrder=null, $minCorpusCount=null, $maxCorpusCount=null, $minLength=null, $maxLength=null, $includeTags=null, $skip=null, $limit=null) {

  		//parse inputs
  		$resourcePath = "/words.{format}/reverseDictionary";
  		$resourcePath = str_replace("{format}", "json", $resourcePath);
  		$method = "GET";
      $queryParams = array();
      $headerParams = array();

      if($query != null) {
  		  $queryParams['query'] = $this->apiClient->toQueryValue($query);
  		}
  		if($findSenseForWord != null) {
  		  $queryParams['findSenseForWord'] = $this->apiClient->toQueryValue($findSenseForWord);
  		}
  		if($includeSourceDictionaries != null) {
  		  $queryParams['includeSourceDictionaries'] = $this->apiClient->toQueryValue($includeSourceDictionaries);
  		}
  		if($excludeSourceDictionaries != null) {
  		  $queryParams['excludeSourceDictionaries'] = $this->apiClient->toQueryValue($excludeSourceDictionaries);
  		}
  		if($includePartOfSpeech != null) {
  		  $queryParams['includePartOfSpeech'] = $this->apiClient->toQueryValue($includePartOfSpeech);
  		}
  		if($excludePartOfSpeech != null) {
  		  $queryParams['excludePartOfSpeech'] = $this->apiClient->toQueryValue($excludePartOfSpeech);
  		}
  		if($minCorpusCount != null) {
  		  $queryParams['minCorpusCount'] = $this->apiClient->toQueryValue($minCorpusCount);
  		}
  		if($maxCorpusCount != null) {
  		  $queryParams['maxCorpusCount'] = $this->apiClient->toQueryValue($maxCorpusCount);
  		}
  		if($minLength != null) {
  		  $queryParams['minLength'] = $this->apiClient->toQueryValue($minLength);
  		}
  		if($maxLength != null) {
  		  $queryParams['maxLength'] = $this->apiClient->toQueryValue($maxLength);
  		}
  		if($expandTerms != null) {
  		  $queryParams['expandTerms'] = $this->apiClient->toQueryValue($expandTerms);
  		}
  		if($includeTags != null) {
  		  $queryParams['includeTags'] = $this->apiClient->toQueryValue($includeTags);
  		}
  		if($sortBy != null) {
  		  $queryParams['sortBy'] = $this->apiClient->toQueryValue($sortBy);
  		}
  		if($sortOrder != null) {
  		  $queryParams['sortOrder'] = $this->apiClient->toQueryValue($sortOrder);
  		}
  		if($skip != null) {
  		  $queryParams['skip'] = $this->apiClient->toQueryValue($skip);
  		}
  		if($limit != null) {
  		  $queryParams['limit'] = $this->apiClient->toQueryValue($limit);
  		}
  		//make the API Call
      if (! isset($body)) {
        $body = null;
      }
  		$response = $this->apiClient->callAPI($resourcePath, $method,
  		                                      $queryParams, $body,
  		                                      $headerParams);


      if(! $response){
          return null;
        }

  		$responseObject = $this->apiClient->deserialize($response,
  		                                                'DefinitionSearchResults');
  		return $responseObject;

      }
  /**
	 * getRandomWords
	 * Returns an array of random WordObjects
   * includePartOfSpeech, string: CSV part-of-speech values to include (optional)
   * excludePartOfSpeech, string: CSV part-of-speech values to exclude (optional)
   * sortBy, string: Attribute to sort by (optional)
   * sortOrder, string: Sort direction (optional)
   * hasDictionaryDef, string: Only return words with dictionary definitions (optional)
   * minCorpusCount, int: Minimum corpus frequency for terms (optional)
   * maxCorpusCount, int: Maximum corpus frequency for terms (optional)
   * minDictionaryCount, int: Minimum dictionary count (optional)
   * maxDictionaryCount, int: Maximum dictionary count (optional)
   * minLength, int: Minimum word length (optional)
   * maxLength, int: Maximum word length (optional)
   * limit, int: Maximum number of results to return (optional)
   * @return array[WordObject]
	 */

   public function getRandomWords($includePartOfSpeech=null, $excludePartOfSpeech=null, $sortBy=null, $sortOrder=null, $hasDictionaryDef=null, $minCorpusCount=null, $maxCorpusCount=null, $minDictionaryCount=null, $maxDictionaryCount=null, $minLength=null, $maxLength=null, $limit=null) {

  		//parse inputs
  		$resourcePath = "/words.{format}/randomWords";
  		$resourcePath = str_replace("{format}", "json", $resourcePath);
  		$method = "GET";
      $queryParams = array();
      $headerParams = array();

      if($hasDictionaryDef != null) {
  		  $queryParams['hasDictionaryDef'] = $this->apiClient->toQueryValue($hasDictionaryDef);
  		}
  		if($includePartOfSpeech != null) {
  		  $queryParams['includePartOfSpeech'] = $this->apiClient->toQueryValue($includePartOfSpeech);
  		}
  		if($excludePartOfSpeech != null) {
  		  $queryParams['excludePartOfSpeech'] = $this->apiClient->toQueryValue($excludePartOfSpeech);
  		}
  		if($minCorpusCount != null) {
  		  $queryParams['minCorpusCount'] = $this->apiClient->toQueryValue($minCorpusCount);
  		}
  		if($maxCorpusCount != null) {
  		  $queryParams['maxCorpusCount'] = $this->apiClient->toQueryValue($maxCorpusCount);
  		}
  		if($minDictionaryCount != null) {
  		  $queryParams['minDictionaryCount'] = $this->apiClient->toQueryValue($minDictionaryCount);
  		}
  		if($maxDictionaryCount != null) {
  		  $queryParams['maxDictionaryCount'] = $this->apiClient->toQueryValue($maxDictionaryCount);
  		}
  		if($minLength != null) {
  		  $queryParams['minLength'] = $this->apiClient->toQueryValue($minLength);
  		}
  		if($maxLength != null) {
  		  $queryParams['maxLength'] = $this->apiClient->toQueryValue($maxLength);
  		}
  		if($sortBy != null) {
  		  $queryParams['sortBy'] = $this->apiClient->toQueryValue($sortBy);
  		}
  		if($sortOrder != null) {
  		  $queryParams['sortOrder'] = $this->apiClient->toQueryValue($sortOrder);
  		}
  		if($limit != null) {
  		  $queryParams['limit'] = $this->apiClient->toQueryValue($limit);
  		}
  		//make the API Call
      if (! isset($body)) {
        $body = null;
      }
  		$response = $this->apiClient->callAPI($resourcePath, $method,
  		                                      $queryParams, $body,
  		                                      $headerParams);


      if(! $response){
          return null;
        }

  		$responseObject = $this->apiClient->deserialize($response,
  		                                                'array[WordObject]');
  		return $responseObject;

      }
  /**
	 * getRandomWord
	 * Returns a single random WordObject
   * includePartOfSpeech, string: CSV part-of-speech values to include (optional)
   * excludePartOfSpeech, string: CSV part-of-speech values to exclude (optional)
   * hasDictionaryDef, string: Only return words with dictionary definitions (optional)
   * minCorpusCount, int: Minimum corpus frequency for terms (optional)
   * maxCorpusCount, int: Maximum corpus frequency for terms (optional)
   * minDictionaryCount, int: Minimum dictionary count (optional)
   * maxDictionaryCount, int: Maximum dictionary count (optional)
   * minLength, int: Minimum word length (optional)
   * maxLength, int: Maximum word length (optional)
   * @return WordObject
	 */

   public function getRandomWord($includePartOfSpeech=null, $excludePartOfSpeech=null, $hasDictionaryDef=null, $minCorpusCount=null, $maxCorpusCount=null, $minDictionaryCount=null, $maxDictionaryCount=null, $minLength=null, $maxLength=null) {

  		//parse inputs
  		$resourcePath = "/words.{format}/randomWord";
  		$resourcePath = str_replace("{format}", "json", $resourcePath);
  		$method = "GET";
      $queryParams = array();
      $headerParams = array();

      if($hasDictionaryDef != null) {
  		  $queryParams['hasDictionaryDef'] = $this->apiClient->toQueryValue($hasDictionaryDef);
  		}
  		if($includePartOfSpeech != null) {
  		  $queryParams['includePartOfSpeech'] = $this->apiClient->toQueryValue($includePartOfSpeech);
  		}
  		if($excludePartOfSpeech != null) {
  		  $queryParams['excludePartOfSpeech'] = $this->apiClient->toQueryValue($excludePartOfSpeech);
  		}
  		if($minCorpusCount != null) {
  		  $queryParams['minCorpusCount'] = $this->apiClient->toQueryValue($minCorpusCount);
  		}
  		if($maxCorpusCount != null) {
  		  $queryParams['maxCorpusCount'] = $this->apiClient->toQueryValue($maxCorpusCount);
  		}
  		if($minDictionaryCount != null) {
  		  $queryParams['minDictionaryCount'] = $this->apiClient->toQueryValue($minDictionaryCount);
  		}
  		if($maxDictionaryCount != null) {
  		  $queryParams['maxDictionaryCount'] = $this->apiClient->toQueryValue($maxDictionaryCount);
  		}
  		if($minLength != null) {
  		  $queryParams['minLength'] = $this->apiClient->toQueryValue($minLength);
  		}
  		if($maxLength != null) {
  		  $queryParams['maxLength'] = $this->apiClient->toQueryValue($maxLength);
  		}
  		//make the API Call
      if (! isset($body)) {
        $body = null;
      }
  		$response = $this->apiClient->callAPI($resourcePath, $method,
  		                                      $queryParams, $body,
  		                                      $headerParams);


      if(! $response){
          return null;
        }

  		$responseObject = $this->apiClient->deserialize($response,
  		                                                'WordObject');
  		return $responseObject;

      }

}

