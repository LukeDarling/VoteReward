**Please read the API specification prior to reading this specification for an explanation of the API**

The file contains JSON with API description for the plugin. The name of the file can be any name. The extension of the file **HAS** to be .vrc

Example file for a server on minecraftlist.org, filename MinecraftList.org.vrc
>{"name":"MinecraftList.org","website":"https://minecraftlist.org","check":"https://minecraftlist.org/api/v1/check/VAbnUR5EoJlw48t39LjT/{USERNAME}","claim":"https://minecraftlist.org/api/v1/claim/VAbnUR5EoJlw48t39LjT/{USERNAME}"}

Parameter | Description | Data Type | Required
-------------- | --------------- | --------------- | ----------------
Name | Name of the file | String | Yes
Website | Website URL | String | Yes
Check | URL for checks for specifed api key and username {USERNAME} | String | Yes
Claim | URL for claiming vote for specified api key and username {USERNAME} | String | Yes

Check: Where the plugin should go to check whether a user voted. This can be any page on your site as long as you provide the api key as part of the link and a place for the plugin to add the username via {USERNAME}.

Claim: Where the plugin should go to check whether a user claimed a vote. This can be any page on your site as long as you provide the api key as part of the link and a place for the plugin to add the username via {Username}
