<?php
/*
require_once('config.php');
require_once('common.php');

// Context Menu
$context_menu = file_get_contents(COMPONENTS . "/filemanager/context_menu.json");
$context_menu = json_decode($context_menu,true);

// Right Bar
$right_bar = file_get_contents(COMPONENTS . "/right_bar.json");
$right_bar = json_decode($right_bar,true);
 
// Read Components, Plugins, Themes

$components = Common::readDirectory(COMPONENTS);
$plugins = Common::readDirectory(PLUGINS);
$themes = Common::readDirectory(THEMES);

// Theme
$theme = THEME;
if(isset($_SESSION['theme'])) {
  $theme = $_SESSION['theme'];
}
*/
?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codiad</title>
    <link rel="stylesheet" href="themes/default/jquery.toastmessage.css">
    <link rel="stylesheet" href="themes/default/reset.css">
    <link rel="stylesheet" href="themes/default/fonts.css">
    <link rel="stylesheet" href="themes/default/screen.css">
    <link rel="stylesheet" href="themes/default/active/screen.css">
    <link rel="stylesheet" href="themes/default/autocomplete/screen.css">
    <link rel="stylesheet" href="themes/default/editor/screen.css">
    <link rel="stylesheet" href="themes/default/fileext_textmode/screen.css">
    <link rel="stylesheet" href="themes/default/filemanager/screen.css">
    <link rel="stylesheet" href="themes/default/market/screen.css">
    <link rel="stylesheet" href="themes/default/project/screen.css">
    <link rel="stylesheet" href="themes/default/settings/screen.css">
    <link rel="stylesheet" href="themes/default/user/screen.css">    
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <style id="ace_editor.css">
    .ace_editor {position: relative;overflow: hidden;font: 12px/normal 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;direction: ltr;text-align: left;}
    .ace_scroller {position: absolute;overflow: hidden;top: 0;bottom: 0;background-color: inherit;-ms-user-select: none;-moz-user-select: none;-webkit-user-select: none;user-select: none;cursor: text;}
    .ace_content {position: absolute;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;min-width: 100%;}
    .ace_dragging .ace_scroller:before{position: absolute;top: 0;left: 0;right: 0;bottom: 0;content: '';background: rgba(250, 250, 250, 0.01);z-index: 1000;}
    .ace_dragging.ace_dark .ace_scroller:before{background: rgba(0, 0, 0, 0.01);}
    .ace_selecting, .ace_selecting * {cursor: text !important;}
    .ace_gutter {position: absolute;overflow : hidden;width: auto;top: 0;bottom: 0;left: 0;cursor: default;z-index: 4;-ms-user-select: none;-moz-user-select: none;-webkit-user-select: none;user-select: none;}
    .ace_gutter-active-line {position: absolute;left: 0;right: 0;}
    .ace_scroller.ace_scroll-left {box-shadow: 17px 0 16px -16px rgba(0, 0, 0, 0.4) inset;}
/*# sourceURL=ace/css/ace_editor.css */</style><style id="ace-tm">.ace-tm .ace_gutter {background: #f0f0f0;color: #333;}.ace-tm .ace_print-margin {width: 1px;background: #e8e8e8;}.ace-tm .ace_fold {background-color: #6B72E6;}.ace-tm {background-color: #FFFFFF;color: black;}.ace-tm .ace_cursor {color: black;}.ace-tm .ace_invisible {color: rgb(191, 191, 191);}.ace-tm .ace_storage,.ace-tm .ace_keyword {color: blue;}.ace-tm .ace_constant {color: rgb(197, 6, 11);}.ace-tm .ace_constant.ace_buildin {color: rgb(88, 72, 246);}.ace-tm .ace_constant.ace_language {color: rgb(88, 92, 246);}.ace-tm .ace_constant.ace_library {color: rgb(6, 150, 14);}.ace-tm .ace_invalid {background-color: rgba(255, 0, 0, 0.1);color: red;}.ace-tm .ace_support.ace_function {color: rgb(60, 76, 114);}.ace-tm .ace_support.ace_constant {color: rgb(6, 150, 14);}.ace-tm .ace_support.ace_type,.ace-tm .ace_support.ace_class {color: rgb(109, 121, 222);}.ace-tm .ace_keyword.ace_operator {color: rgb(104, 118, 135);}.ace-tm .ace_string {color: rgb(3, 106, 7);}.ace-tm .ace_comment {color: rgb(76, 136, 107);}.ace-tm .ace_comment.ace_doc {color: rgb(0, 102, 255);}.ace-tm .ace_comment.ace_doc.ace_tag {color: rgb(128, 159, 191);}.ace-tm .ace_constant.ace_numeric {color: rgb(0, 0, 205);}.ace-tm .ace_variable {color: rgb(49, 132, 149);}.ace-tm .ace_xml-pe {color: rgb(104, 104, 91);}.ace-tm .ace_entity.ace_name.ace_function {color: #0000A2;}.ace-tm .ace_heading {color: rgb(12, 7, 255);}.ace-tm .ace_list {color:rgb(185, 6, 144);}.ace-tm .ace_meta.ace_tag {color:rgb(0, 22, 142);}.ace-tm .ace_string.ace_regex {color: rgb(255, 0, 0)}.ace-tm .ace_marker-layer .ace_selection {background: rgb(181, 213, 255);}.ace-tm.ace_multiselect .ace_selection.ace_start {box-shadow: 0 0 3px 0px white;}.ace-tm .ace_marker-layer .ace_step {background: rgb(252, 255, 0);}.ace-tm .ace_marker-layer .ace_stack {background: rgb(164, 229, 101);}.ace-tm .ace_marker-layer .ace_bracket {margin: -1px 0 0 -1px;border: 1px solid rgb(192, 192, 192);}.ace-tm .ace_marker-layer .ace_active-line {background: rgba(0, 0, 0, 0.07);}.ace-tm .ace_gutter-active-line {background-color : #dcdcdc;}.ace-tm .ace_marker-layer .ace_selected-word {background: rgb(250, 250, 255);border: 1px solid rgb(200, 200, 250);}.ace-tm .ace_indent-guide {background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==") right repeat-y;}
/*# sourceURL=ace/css/ace-tm */</style><style>    .error_widget_wrapper {        background: inherit;        color: inherit;        border:none    }  
  .error_widget {        border-top: solid 2px;        border-bottom: solid 2px;        margin: 5px 0;        padding: 10px 40px;        white-space: pre-wrap;    }    .error_widget.ace_error, .error_widget_arrow.ace_error{        border-color: #ff5a5a    }    .error_widget.ace_warning, .error_widget_arrow.ace_warning{        border-color: #F1D817    }    .error_widget.ace_info, .error_widget_arrow.ace_info{        border-color: #5a5a5a    }    .error_widget.ace_ok, .error_widget_arrow.ace_ok{        border-color: #5aaa5a    }    .error_widget_arrow {        position: absolute;        border: solid 5px;        border-top-color: transparent!important;        border-right-color: transparent!important;        border-left-color: transparent!important;        top: -5px;    }</style>
</head>

<body>
    <script>
    var i18n = (function(lang) {
        return function(word,args) {
            var x;
            var returnw = (word in lang) ? lang[word] : word;
            for(x in args){
                returnw=returnw.replace("%{"+x+"}%",args[x]);   
            }
            return returnw;
        }
    })([])
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery-1.7.2.min.js"%3E%3C/script%3E'));</script>
    <script src="js/jquery-ui-1.8.23.custom.min.js"></script>
    <script src="js/jquery.css3.min.js"></script>
    <script src="js/jquery.easing.js"></script>
    <script src="js/jquery.toastmessage.js"></script>
    <script src="js/amplify.min.js"></script>
    <script src="js/localstorage.js"></script>
    <script src="js/jquery.hoverIntent.min.js"></script>
    <script src="js/system.js"></script>
    <script src="js/sidebars.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/message.js"></script>
    <script src="js/jsend.js"></script>
    <script src="js/instance.js?v=1533815389"></script>
    <div id="message"></div>
    
    <div id="workspace">
        <div id="sb-left" class="sidebar" style="left: 0px;">
            <div id="sb-left-title">
                <a id="lock-left-sidebar" class="icon icon-lock"></a>
                            </div>

            <div class="sb-left-content">
                <div id="context-menu" data-path="" data-type="">

                    <a class="directory-only" onclick="codiad.filemanager.createNode($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;),&#39;file&#39;);"><span class="icon-doc-text"></span>New File</a><a class="directory-only" onclick="codiad.filemanager.createNode($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;),&#39;directory&#39;);"><span class="icon-folder"></span>New Folder</a><hr class="directory-only"><a class="directory-only" onclick="codiad.filemanager.search($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-target"></span>Search</a><hr class="directory-only"><a class="directory-only" onclick="codiad.filemanager.uploadToNode($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-upload"></span>Upload Files</a><a class="both no-external" onclick="codiad.filemanager.openInBrowser($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-eye"></span>Preview</a><hr class="file-only no-external"><hr class="directory-only"><a class="both" onclick="codiad.filemanager.copyNode($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-doc"></span>Copy</a><a class="directory-only" onclick="codiad.filemanager.pasteNode($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-docs"></span>Paste</a><hr class="non-root"><a class="non-root" onclick="codiad.filemanager.renameNode($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-pencil"></span>Rename</a><a class="root-only" onclick="codiad.project.rename($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;),$(&#39;#context-menu&#39;).attr(&#39;data-name&#39;));"><span class="icon-pencil"></span>Rename Project</a><hr class="non-root"><a class="non-root" onclick="codiad.filemanager.deleteNode($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-cancel-circled"></span>Delete</a><hr class="both no-external"><a class="both no-external" onclick="codiad.filemanager.download($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-download"></span>Download</a><hr class="directory-only"><a class="directory-only" onclick="codiad.filemanager.rescan($(&#39;#context-menu&#39;).attr(&#39;data-path&#39;));"><span class="icon-arrows-ccw"></span>Rescan</a>
                </div>

                <div id="file-manager"><ul><li><a id="project-root" data-type="root" class="directory loading open" data-path="ide">ide</a></li></ul></div>

                <ul id="list-active-files" class="ui-sortable" style=""></ul>

            </div>
            
            <div id="side-projects" class="sb-left-projects">
                <div id="project-list" class="sb-project-list">
                
                    <div class="project-list-title">
                        <h2>Projects</h2>
                        <a id="projects-collapse" class="icon-down-dir icon" alt="Collapse"></a>
                                                <a id="projects-manage" class="icon-archive icon"></a>
                        <a id="projects-create" class="icon-plus icon" alt="Create Project"></a>
                    </div>
                    
                    <div class="sb-projects-content">  
                    
                    <ul>
                        <li ondblclick="codiad.project.open(&#39;ide&#39;);"><div class="icon-archive icon"></div>ide</li>                             
                    </ul>
                    </div>
                    
                </div>
            </div>
            <div class="sidebar-handle ui-draggable"><span>||</span></div>

        </div>

        <div id="cursor-position">Ln: 0 · Col: 0</div>

        <div id="editor-region" style="margin-left: 300px; height: 898px; margin-right: 0px;">
            <div id="editor-top-bar">
                <ul id="tab-list-active-files" class="ui-sortable"> </ul>
                <div id="tab-dropdown" style="display: none; margin-right: 0px;">
                    <a id="tab-dropdown-button" class="icon-down-open"></a>
                </div>
                <div id="tab-close" style="display: none; margin-right: 0px;">
                    <a id="tab-close-button" class="icon-cancel-circled" title="Close All"></a>
                </div>
                
                <div class="bar"></div>
            </div>

            <div id="root-editor-wrapper" style="height: 838px;"></div>

            <div id="editor-bottom-bar">
                <a id="settings" class="ico-wrapper"><span class="icon-doc-text"></span>Settings</a>
                
                                
                <div class="divider"></div>
                <a id="split" class="ico-wrapper"><span class="icon-layout"></span>Split</a>
                <div class="divider"></div>
                <a id="current-mode"><span class="icon-layout"></span></a>                
                <div class="divider"></div>
                <div id="current-file"></div>
            </div>
        </div>
        <div id="sb-right" class="sidebar" style="right: -190px;">
            <div class="sidebar-handle"><span><a class="icon-menu"></a></span></div>
            <div id="sb-right-title">
                <span id="lock-right-sidebar" class="icon-switch icon"></span>
            </div>
            <div class="sb-right-content">
                <a onclick="codiad.active.save();"><span class="icon-install bigger-icon"></span>Save</a><a onclick="codiad.active.saveAll();"><span class="icon-install bigger-icon"></span>Save All</a><hr><div class="sb-right-category">Plugins</div><hr><div class="sb-right-category">Administration</div><a onclick="codiad.project.list();"><span class="icon-archive bigger-icon"></span>Projects</a><a onclick="codiad.user.list();"><span class="icon-users bigger-icon"></span>Users</a><hr><div class="sb-right-category">System</div><a onclick="codiad.market.list();"><span class="icon-cloud bigger-icon"></span>Marketplace</a><a onclick="codiad.update.check();"><span class="icon-share bigger-icon"></span>Update Check</a><hr><div class="sb-right-category">Account</div><a onclick="codiad.settings.show();"><span class="icon-doc-text bigger-icon"></span>Settings</a><a onclick="codiad.user.password();"><span class="icon-flashlight bigger-icon"></span>Password</a><hr><a onclick="window.open(&#39;https://github.com/Codiad/Codiad/wiki&#39;);"><span class="icon-help bigger-icon"></span>Help</a><a onclick="codiad.user.logout();"><span class="icon-logout bigger-icon"></span>Logout</a>
            </div>
        </div>
    </div>
    <div id="modal-overlay" style="display: none;"></div>
    <div id="modal" class="ui-draggable" style="top: 15%; left: 50%; min-width: 500px; margin-left: -250px; display: none;"><div id="close-handle" class="icon-cancel" onclick="codiad.modal.unload();"></div><div id="drag-handle" class="icon-location"></div><div id="modal-content"></div></div>

    <iframe id="download" src="./Codiad_files/saved_resource.html"></iframe>

    <div id="autocomplete"><ul id="suggestions"></ul></div>


    <!-- ACE -->
    <script src="../Codiad-v.2.8.4/components/editor/ace-editor/ace.js"></script>

    <!-- COMPONENTS -->
    <script src="../Codiad-v.2.8.4/components/active/init.js"></script>"<script src="../Codiad-v.2.8.4/components/autocomplete/init.js"></script>"<script src="../Codiad-v.2.8.4/components/editor/init.js"></script>"<script src="../Codiad-v.2.8.4/components/fileext_textmode/init.js"></script>"<script src="../Codiad-v.2.8.4/components/filemanager/init.js"></script>"<script src="../Codiad-v.2.8.4/components/finder/init.js"></script>"<script src="../Codiad-v.2.8.4/components/keybindings/init.js"></script>"<script src="../Codiad-v.2.8.4/components/market/init.js"></script>"<script src="../Codiad-v.2.8.4/components/poller/init.js"></script>"<script src="../Codiad-v.2.8.4/components/project/init.js"></script>"<script src="../Codiad-v.2.8.4/components/settings/init.js"></script>"<script src="../Codiad-v.2.8.4/components/update/init.js"></script>"<script src="../Codiad-v.2.8.4/components/user/init.js"></script>"<script src="../Codiad-v.2.8.4/components/worker_manager/init.js"></script>"
</body>
</html>
