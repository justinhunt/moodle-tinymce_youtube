YouTube Anywhere for Moodle 2.4 and above

This plugin was a community effort and was funded by contributions. 
A list of the contributors follows:
======================
Tetsuo Kimura
StraighterLine
Waleed Jameel
Richard Oelmann
Classroom Revolution, LLC

Other Contributors
======================
Don Hinkelman
Rex Lorenzo
Jason Palmer
Daran Price
Ben Reynolds
flizotte
bessette
lindstromfredg
Julian Ridden
Roland Sherwood
Philippe Petitqueux
alfieismydog
kdc_teach1

Introduction
===========
The YouTube Anywhere plugin for Moodle's TinyMCE allows users to upload or record video directly into YouTube, and to select from previously uploaded YouTube videos. The video is inserted into the HTML area for display. The video file is stored on YouTube, though it is accessible from Moodle. YouTube Anywhere will only work on Moodle 2.4 and greater.

Requirements
==============
*	Moodle 2.4 or greater
*	Internet access
*	Multimedia plugins filter enabled (to turn YouTube links into YouTube players)
*	YouTube API keys (developer key, OAUTH2 client id, OAUTH2 secret). These are available free of charge from YouTube/Google. 

Installation
==============
The YouTube Anywhere plugin is contained in the youtube folder. That folder should be placed in the following directory of a Moodle installation: [PATH TO MOODLE]/lib/editor/tinymce/plugins
Other folders in that directory will include, spellchecker and moodlemedia.

Once the folder is in place Moodle will be able to install the plugin. Login as the site administrator. Moodle should detect the YouTube Anywhere plugin and present a page with plugin information and the option to proceed to install a new plugin. If Moodle does not automatically direct you to this page, you can go there from the Moodle menu:
Site Administration -> Notifications
 
Follow the prompts to install the plugin. On the last step Moodle will show the settings page for YouTube Anywhere. The settings can be accessed by the administrator at any time from the Moodle menu: 
Site Administration -> Plugins -> Text Editors->TinyMCE HTML Editor -> YouTube Anywhere

Post Installation Settings
==============
You will need several keys to authorize access to the YouTube API.
A YouTube Developers Key can be obtained at https://code.google.com/apis/youtube/dashboard .

A Google OAUTH client id and OAUTH secret are also required. 
More information and explanation on how to get them is here:
http://docs.moodle.org/24/en/Google_OAuth_2.0_setup

There are two authentication methods possible, "master account" and "student account." 
If using master account authentication, you will need to enter a valid YouTube username and password.

More detailed documentation can be found in a PDF file, that should accompany this plugin.

Justin Hunt 2013/04/22
poodllsupport@gmail.com





