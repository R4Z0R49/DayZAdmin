DayZAdmin for the DayZ hive and the Reality private hive
==================

DayZAdmin is a DayZ Administration panel that was originally coded for the server pack Bliss. Bliss then got abandoned and Reality was born. Not all features of the panel currently support the DayZMod but we are working on it as Reality is switching their database around to be similar to the DayZMod database.

==================
Requirements
==================
*MySQL 5.4 or higher
*Apache 2.2 or higher
*PHP 5.3 
*Correctly installed and configured Battleye RCON
*Linux Support - (Close pending path issues)
*FTP Access to your server - (OPTIONAL)

==================
Features
==================
*Lists of players and vehicles.
*Player/vehicle inventory, states and position.
*Inventory and backpack string editors.
*Teleportation, skin changes, reset humanity, reviving, killing, healing and medical status options via the panel.
*Reset humanity, reviving, killing, healing and medical status options via the panel - (Only Reality at the moment).
*Configurable administrator access levels to the panel.
*Google maps API based map with players, vehicles and deployables - (optional tracking of players and vehicles).
*Inventory check for unknown items.
*Search for items, vehicles, players.
*Rcon-based online players list, kick-ban features and global messaging.
*Reset Players locations.
*Leaderboard
*Stats and player search
*View player chat/belogs - (Requires FTP)

==================
Installation
==================
*Import dayz.sql in the sql folder to your database.
*Rename config.php-dist to config.php.
*Edit config.php and set to the right values. This is highly important!
*The default login is: admin/123456

==================
Updating
==================
*Check for any new files to run in the sql/updates folder.
*Check that your config.php is up to date with the new config.php-dist if it has been edited


