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

defined('MOODLE_INTERNAL') || die();

/**
 * Plugin for YouTube TinyMCE Editor subplugin 
 * Crowdfunded by many cool people.
 *
 * @package   tinymce_youtube
 * @copyright 2013 Justin Hunt {@link http://www.poodll.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//youtubelib.php
global $CFG;
require_once("$CFG->libdir/editor/tinymce/plugins/youtube/youtubelib.php");
 
class tinymce_youtube extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('youtube');
    protected $component = 'tinymce_youtube';
	protected $ytconfig = null;

    protected function update_init_params(array &$params, context $context,
            array $options = null) {
			
		global $USER, $PAGE;
            
            
        		//use tinymce/youtube:filechooser capability
		if($this->get_config('role_eval')=='0'){
			//If they don't have permission
			if(!has_capability('tinymce/youtube:accessible', $context) ){
				return;
			 }

		//use checkboxes from settings page
		}else{
			$roles = get_user_roles($context, $USER->id, true);
			$allowed = false;
			$allowedroles = $this->get_config('allowedroles');
		
			
			if(!empty($allowedroles)){
				$allowedroles = explode(',',$allowedroles);
				foreach($roles as $r){
					switch($r->shortname){
						//case 'guest': $allowed = $this->get_config('allow_guest'); break;
						case 'guest': $allowed = array_search('allow_guest',$allowedroles)!==false; break;
						case 'user': $allowed = array_search('allow_authuser',$allowedroles)!==false; break;
						case 'frontpage': $allowed = array_search('allow_frontpage',$allowedroles)!==false; break;
						case 'student': $allowed = array_search('allow_student',$allowedroles)!==false; break;
						case 'teacher': $allowed = array_search('allow_noneditteacher',$allowedroles)!==false; break;
						case 'editingteacher': $allowed = array_search('allow_teacher',$allowedroles)!==false; break;
						case 'coursecreator': $allowed = array_search('allow_coursecreator',$allowedroles)!==false; break;
						case 'manager': $allowed = array_search('allow_manager',$allowedroles)!==false; break;
					}
					if($allowed){break;}
				}//end of for each
			}//end of if empty allowedroles
			
			//if we still are not authenticated, check if we have the admin role
			//if not we deny access
			if(!$allowed){
				if(!($this->get_config('allow_admin') && has_capability('moodle/site:config', $context))) {return;}
			}
		}//end of if us capabilities
		
		
	
		//init youtube api
		$this->ytconfig = $this->get_ytconfig();
		$ytargs = Array('component'=>$this->component,'config'=>$this->ytconfig);
		$yt = new youtubeapi($ytargs);
		
		//pass tabset html onto where JS can get at it
		$params['youtube_tabset'] = $yt->get_youtube_tabset();
		$params['uploader_html'] = get_string('uploadavideodetails', $this->component) 
					. $yt->get_uploader_iframe_html();
		$params['browselist_html'] = get_string('browsevideosdetails', $this->component) 
					. $yt->get_browser_iframe_html();
		$params['browselist_button_html'] = get_string('browsevideosdetails', $this->component) 
					. $yt->get_youtube_browselist_displaybutton();
					


        // Add button after emoticon button in advancedbuttons3.
        $added = $this->add_button_after($params, 3, 'youtube', 'moodleemoticon', false);

        // Note: We know that the emoticon button has already been added, if it
        // exists, because I set the sort order higher for this. So, if no
        // emoticon, add after 'image'.
        if (!$added) {
            $this->add_button_after($params, 3, 'youtube', 'image');
        }

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
    }
	
	public function get_ytconfig(){
		global $CFG, $USER;
		
		//create our video title, and replace any suspicous chars that might mess up javascript
		$videotitle = fullname($USER) . ' using YouTube Anywhere';
		$videotitle = str_replace('\'','-',$videotitle);
		$videotitle = str_replace('\"','-',$videotitle);
		
		//Add youtube tabset
		$config = new youtube_settings();
		$config->set('videotitle',$videotitle);
		$config->set('tabsetid','youtubetabset_id');
		$config->set('devkey',$this->get_config('devkey'));
		$config->set('authtype',$this->get_config('authtype'));
		$config->set('masteruser',$this->get_config('youtube_masteruser'));
		$config->set('masterpass',$this->get_config('youtube_masterpass'));
		$config->set('clientid',$this->get_config('youtube_clientid'));
		$config->set('secret',$this->get_config('youtube_secret'));
		$config->set('allow_manual',$this->get_config('allow_manual'));
		$config->set('allow_browse',$this->get_config('allow_browse'));
		$config->set('allow_webcam',$this->get_config('allow_webcam'));
		$config->set('allow_uploads',$this->get_config('allow_uploads'));
		$config->set('videoprivacy',$this->get_config('videoprivacy'));
		$config->set('videocategory',$this->get_config('videocategory'));
		$config->set('allow_ytcomment',$this->get_config('allow_ytcomment'));
		$config->set('allow_ytrate',$this->get_config('allow_ytrate'));
		$config->set('allow_ytrespond',$this->get_config('allow_ytrespond'));
	
		//eg /mod/assign/submission/youtube
		$config->set('modroot','/lib/editor/tinymce/plugins/youtube');
		//eg /mod/assign/view.php
		//$config->set('returnurl',$PAGE->url);
		$config->set('returnurl',$CFG->httpswwwroot . '/lib/editor/tinymce/plugins/youtube/youtube_callback.php');
		$config->set('shortdesc','Youtube Anywhere');
		
		return $config;
	}

    protected function get_sort_order() {
        return 110;
    }
}
