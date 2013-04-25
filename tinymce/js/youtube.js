/**
 * @author Justin Hunt <poodllsupport@gmail.com>
 */


var ed,url;
/*
if (url = tinyMCEPopup.getParam("media_external_list_url")) {
    document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');
}
*/

function tinymce_youtube_init() {
    ed = tinyMCEPopup.editor;
    document.getElementById('youtubetabset_container').innerHTML = tinymce_youtube_getTabSetHTML();
	tinymce_youtube_loadYUITabs();

}

// Replace designated div with a YUI tab set
function tinymce_youtube_loadYUITabs() {
YUI().use('tabview', function(Y) {
	var tabView = new Y.TabView({srcNode:'#youtubetabset_id'}); 
	tabView.render();
});
}

// Show upload form and browse list
//this will be called after user has auth'ed with google in popup
function tinymce_youtube_initTabsAfterLogin() {
	tinymce_youtube_displayBrowseList();
	tinymce_youtube_displayUploadForm();
}

//show the upload form in upload tab
//only called from initTabsAfterLogin
function tinymce_youtube_displayUploadForm() {
	var uploadtab	= document.getElementById('tabupload');
	if(uploadtab){
		uploadtab.innerHTML = tinymce_youtube_getUploaderHTML();
	}
}

//show the list of videos in browse list tab
//called from initTabsAfterLogin and onclick event of "browse list display" button
function tinymce_youtube_displayBrowseList() {
	var browsetab = document.getElementById('tablist');
	if(browsetab){
		browsetab.innerHTML = tinymce_youtube_getBrowseListHTML();
	}
}

//Insert video link back into htmlarea
function tinymce_youtube_insertYoutubeLink(vid) {
	if(!vid){
		var f = document.forms[0];
		vid = f.youtubevidid.value;
	}
	if(vid){
		var src = "http://www.youtube.com/watch?v=";
    	var linkname = "YouTube Anywhere";
    	var h = '<a href="'+ src + vid +'">'+linkname+'</a>';
    	ed.execCommand('mceInsertContent', false, h);
    }
    tinyMCEPopup.close();
}


	function tinymce_youtube_onUploadSuccess(event) {
			document.getElementById('youtubevidid').value=event.data.videoId;
	  }
	function tinymce_youtube_onProcessingComplete(event) {
			//document.getElementById('id_youtubeid').value=event.data.videoId;
	  }  
	function tinymce_youtube_onApiReady(event) {
			//var widget = event.target; //this might work, if global "widget" doesn't
			tinymce_youtube_widget.setVideoTitle(tinymce_youtube_videotitle);
			tinymce_youtube_widget.setVideoDescription(tinymce_youtube_videotitle);
			tinymce_youtube_widget.setVideoPrivacy(tinymce_youtube_videoprivacy); 
	  }
	function tinymce_youtube_directLoadYTRecorder(recorderid,videoname,privacy,width) {
			tinymce_youtube_videotitle = videoname;
			tinymce_youtube_videoprivacy=privacy;
			tinymce_youtube_widget = new YT.UploadWidget(recorderid, {
			  width: width,
			  webcamOnly: true,
			  events: {
            'onUploadSuccess': tinymce_youtube_onUploadSuccess,
            'onProcessingComplete': tinymce_youtube_onProcessingComplete,
            'onApiReady': tinymce_youtube_onApiReady
			}
		});
		
		}

tinyMCEPopup.onInit.add(tinymce_youtube_init);
