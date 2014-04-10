TGDB-Api-Plugin
===============

# Requirements
- PHP Version (5.3 | 5.2[?])
- WP Version (2.7)

A The Games DB wrapper Plugin for WordPress, utilises the wp_remote_get functions.



Core functionality...

At its core the wrapper plugin is meant to be activated and used in conjunction with other plugins.
It utilizes OOP based class principles to access and deliver data in a JSON format.
However, since the output is converted from XML to JSON it is indeed recommended to get the elements with a json_decode
or rewrite the internal functions to utilize the "convertXMLJSON" function.


# Yaddah yaddah yadaah
## How do I use this in my plugins.

As soon as you have registered/activated the plugin the functionality is within the gameDB class.

```
gameDB
```

That means if you want to get a list of games by name (referencing to the [GetGamesList](http://wiki.thegamesdb.net/index.php?title=GetGamesList) function of the API).
You simple do this

```
gameDB::getGamesList('string')
```

If you are really smart you reference the class by an variable...

```
$gamesAPI = gameDB;
$gamesAPI->getGamesList('string');
```

The output should be JSON and you should be able to retrieve the needed data for any game.

Here is a short property list (and their params):

```
function getGames(string) //Gets games based upon the name (string) utilizes the GetGame of the API
function getGamesList(string) //Gets games based upon the name (string) utilizes the GetGamesList of the API
function getGame(int) //Gets a single game based upon the ID (int) of the game utilizes the GetGame of the API with the param of ID.
function getBoxArt(int) //Gets a single game's boxart based upon the ID (int) utilizes the GetArt of the API.
```

AS ALWAYS!! - CACHE YOUR DATA!!
We dont want to be rough on the kind folks over at TheGamesDB therefore i encourage to cache the results as you retrieve them.
Do NOT simple spam the API as it will get lost by EVERYONE then...

To read more about the output and the XML data retrieved by the API [read more here](http://wiki.thegamesdb.net/index.php?title=API_Introduction "TheGamesDB Api Documentation")
