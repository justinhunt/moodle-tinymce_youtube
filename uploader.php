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
$showform = optional_param('showform', 0,PARAM_INT); // to show the form(lets rcord) or not(recording finished)
$status = optional_param('status', 0,PARAM_INT); // request status
$video_id = optional_param('id', '', PARAM_TEXT); // youtube id of video
$code = optional_param('code', 0,PARAM_INT); // error code
$video_title = optional_param('videotitle', 'YouTube Anywhere',PARAM_TEXT); // title of video

//we need to set the page context
require_login();
$user_context = context_user::instance($USER->id);
$PAGE->set_context($user_context);

//if we are returning from a youtube upload we need to process the returned info in JS
if($showform==0){
	if($status==200){
		?>
		<html>
			<head>
				<script type="text/javascript">
					function process_youtube_return()
					{
						var vfield = parent.document.getElementById('youtubevidid');
						vfield.value = '<?php echo $video_id; ?>';
						//if auto saving, uncomment this
						//parent.document.getElementById('id_submitbutton').click();
					}
				</script>
			</head>

			<body onload="process_youtube_return()" >
			<h3><?php echo get_string('uploadsuccessful', 'tinymce_youtube'); ?></h3>
			<b><?php echo get_string('pleasesave', 'tinymce_youtube'); ?></b>
			</body>
		</html>
		<?php
	}else{
		echo get_string('uploadfailed', 'tinymce__youtube');
		echo "<br />code:" . $code;
	}
	
//if we are going to return we prepare the page and recorder
}else {

	// load the youtube submission plugin
	require_once($CFG->dirroot . '/lib/editor/tinymce/classes/plugin.php');
	$ytplugin = editor_tinymce_plugin::get("youtube");
	$ytconfig = $ytplugin->get_ytconfig();
	$ytargs = Array('component'=>'tinymce_youtube','config'=>$ytconfig);
	
	$ytapi = new youtubeapi($ytargs);
	if(empty($ytapi)) {
		die;
	}
	//set up the page
	$PAGE->set_context($user_context);
	$PAGE->set_url($CFG->wwwroot.'/lib/editor/tinymce/plugins/youtube/uploader.php');

	?>

	<div style="text-align: center;">
	<?php 
				$yt = $ytapi->init_youtube_api();
				echo $ytapi->fetch_youtube_uploadform($yt,$video_title);

	?>
	</div>
	<?php
	}