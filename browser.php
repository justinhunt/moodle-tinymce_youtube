<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file is loaded in an iframe in the YouTube Anywhere TinyMCE Plugin 
 * Crowdfunded by many cool people.
 *
 * @package    tinymce_youtube
 * @copyright 2012 Justin Hunt {@link http://www.poodll.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../../../config.php');
require_once('youtubelib.php');

global $PAGE, $USER;


// we get the request parameters:
$video_title = optional_param('videotitle', 'YouTube Anywhere',PARAM_TEXT); // title of video

//we need to set the page context
require_login();
$user_context = context_user::instance($USER->id);
$PAGE->set_context($user_context);
$PAGE->set_url($CFG->wwwroot.'/lib/editor/tinymce/plugins/youtube/browser.php');


	// load the youtube submission plugin
	require_once($CFG->dirroot . '/lib/editor/tinymce/classes/plugin.php');
	$ytplugin = editor_tinymce_plugin::get("youtube");
	$ytconfig = $ytplugin->get_ytconfig();
	$ytargs = Array('component'=>'tinymce_youtube','config'=>$ytconfig);
	
	$ytapi = new youtubeapi($ytargs);
	if(empty($ytapi)) {
		die;
	}
	
	//return the html
	echo $ytapi->fetch_youtube_browselist();