*We are using the site minecraftlist.org as an example. Website layout can be different.*

https://minecraftlist.org/api/v1/{type}/{api_key}/{username}

The parameters:
* type 
    * check - for checking if the username has voted for this server during the last 24 hours
    * claim - to set a vote during the last 24 hours for the username as claimed, ran only after the check
* api_key is assigned to the server upon the registration and can be found on the server page (visible to the owner only)
* Username - name of the player to check

Returns: 
* JSON indicating if the user has voted during the last 24 hours and if the vote has been claimed **OR** 
* JSON with an error indication upon an error*

Examples:

**To check whether a player has voted in the last 24 hours**


https://minecraftlist.org/api/v1/{type}/{api_key}/{username}

type = check
Parameter | Description | Data Type | Required
-------------- | --------------- | --------------- | ----------------
Type | Type of check | String | Yes
Api_key | Server API Key | String | Yes
Username | Username of player | String | Yes

https://minecraftlist.org/api/v1/check/VAbnUR5EoJlw48t39LjT/troll

*If voted is true and claimed is false then this line is returned:*

> {"username":"troll","voted":true,"claimed":false,"type":"check"}

After the plugin finds voted: true and claimed: false, plugin goes on to attempt to claim the vote

*If voted returns true and claimed is true then this line is returned:*
> {"username":"troll","voted":true,"claimed":true,"type":"check"}

The plugin then doesnt go on to attempt to claim the vote.

*If voted returns false:*
> {"username":"troll","voted":false,"claimed":false,"type":"check"}

Plugin doesnt attempt to claim the vote

**To set a vote as claimed for a player**

Type = claim
Parameter | Description | Data Type | Required
-------------- | --------------- | --------------- | ----------------
Type | Type of check | String | Yes
Api_key | Server API Key | String | Yes
Username | Username of player | String | Yes

https://minecraftlist.org/api/v1/claim/VAbnUR5EoJlw48t39LjT/troll

*Returns:*
> {"username":"troll","voted":true,"claimed":true,"type":"claim"}

Voted:
True if the player has voted

Claimed:
claimed will be "true" if the claim was successful, false otherwise

Example error messages:
>{"error":"Incorrect API key"}

>{"error":"Wrong method specified"}
