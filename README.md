DayZAdmin for the DayZ hive
==================

DayZAdmin is a DayZ Administration panel that was originally coded for the server pack Bliss. Bliss then got abandoned and Reality was born. Reality has now switched to the DayZMod database and DayZAdmin supports all features using the DayZMod schema.

==================
Requirements
==================
- MySQL 5.4 or higher
- Apache 2.2 or higher
- PHP 5.3 
- Correctly installed and configured Battleye RCON
- FTP Access to your server - (OPTIONAL)

==================
Features
==================
- Lists of players and vehicles.
- Player/vehicle inventory, states and position.
- Inventory and backpack string editors.
- Teleportation, skin changes, reset humanity, reviving, killing, healing and medical status options via the panel.
- Configurable administrator access levels to the panel.
- Google maps API based map with players, vehicles and deployables - (optional tracking of players and vehicles).
- Inventory check for unknown items.
- Search for items, vehicles, players.
- Rcon-based online players list, kick-ban features and global messaging.
- Reset Players locations.
- Leaderboard
- Stats and player search
- View player Chat/BeLogs - (Requires FTP if panel is not hosted on the same computer as the server)

==================
Installation
==================
- 1: Import the sql file called dayz.sql located in the folder called sql to the same MySQL database as your server.
- 2: Rename the file called config.php-dist in the main directory to config.php.
- 3: Edit config.php and set it to the right values. This is highly important!
- The default credentials are: admin/123456

==================
Updating
==================
- Check for any new files to run in the sql/updates folder.
- Check that your config.php is up to date with newer versions of the config.php-dist.
