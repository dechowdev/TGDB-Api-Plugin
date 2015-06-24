<?php
/**
 * Plugin Name: TheGamesDB Api Wrapper
 * Plugin URI: http://game-play.dk
 * Description: API Wrapper for TheGamesDB. Used to extract data.
 * Version: 1.0.0
 * Author: Lucas Dechow
 */

class gameDB{

    protected $apiUrl = 'http://thegamesdb.net/api/';

    protected $game;

    public function __construct(){
        // Set Plugin Path
        $this->pluginPath = dirname(__FILE__);
     
        // Set Plugin URL
        $this->pluginUrl = WP_PLUGIN_URL . '/game-api';
     
        
    }

    private function convertXMLArray($xml){
        $xmlbody  = simplexml_load_string($xml);
        $json = json_encode($xmlbody);
        $array = json_decode($json);
        
        return $array;
    }


    /**
     * Converts the json to xml
     * @param  string $xml A full string of the xml to be parsed
     * @return [type]      [description]
     */
    private function convertXMLJSON($xml){
        $xmlbody  = simplexml_load_string($xml);
        $json = json_encode($xmlbody);

        return $json;
    }

    /**
     * Get the games from TheGamesDB Api
     * @param  string $game string that contains the game title
     * @return array       Return an xml->json based array that 
     *                     contains the data information provided
     *                     by the API
     */
    public function getGames($game){
        $call = wp_remote_get($this->apiUrl . 'GetGame.php?name=' . $game);
        $body = wp_remote_retrieve_body($call);

        return gameDB::convertXMLArray($body);

    }

    public function getGamesList($game){
        $call = wp_remote_get($this->apiUrl . 'GetGamesList.php?name=' . $game);
        $body = wp_remote_retrieve_body($call);

        return gameDB::convertXMLArray($body);
    }

    /**
     * Get specific game from the ID
     * @param  int $id id that contains the game specific ID
     * @return array     Return the array containing every element.
     */
    public function getGame($id){
        $call = wp_remote_get($this->apiUrl . 'GetGame.php?id=' . $id);
        $body = wp_remote_retrieve_body($call);

        return gameDB::convertXMLArray($body);
    }
    /**
     * Get specific game box art from the ID
     * @param  int $id id that contains the specific game ID
     * @return string     Return the spefic URL for the game art.
     */
    public function getBoxArt($id){
        $call = wp_remote_get($this->apiUrl . 'GetArt.php?id=' . $id);
        $body = wp_remote_retrieve_body($call);

        return gameDB::convertXMLArray($body);
    }

    public function getPlatform($id){
      $call = wp_remote_get($this->apiUrl . 'GetPlatform.php?id=' . $id);
      $body = wp_remote_retrieve_body($call);

      return gameDB::convertXMLArray($body);
    }

    public function getPlatformsList(){
        $call = wp_remote_get($this->apiUrl . 'GetPlatformsList.php');
        $body = wp_remote_retrieve_body($call);

        return gameDB::convertXMLArray($body);
    }

}
/**
 * Example function to get games based on the title.
 * It utilizes the search function of the API and checks if there is
 * multiple results, if there is a match on any game it returns the title.
 * 
 * @param  string $name Title of the game (no spaces)
 * @return string       Returns the title of the game
 */
function exampleGetGame($name){
    $gameAPI = new gameDB();
    $games = $gameAPI->getGamesList($name);
    if (count($games->Game) > 1){
        //IF THERE IS MORE THAN ONE GAME IN THE OBJECT
        //FOREACH THROUGH THE OBJECT/ARRAY
        foreach ($games->Game as $game) {
            $id = $game->id;
            $game = $gameAPI->getGame($id);
            //var_dump($game);  
            $title = $game->Game->GameTitle;
            print_r($title);

            // return $game;
        }    
    } else {
        //GET SINGLE GAME FROM LISTING

        $game = $games->Game;
        $id = $game->id;
        $game = $gameAPI->getGame($id);
        $title = $game->Game->GameTitle;
        print_r($title);
        
        //return $game;
    }

}

$gameAPI = new gameDB();



