<?php
	if ( !@constant("THIS_DOMAIN") ) {
		require_once("./eCraft-library/eCraft-appconfig-user.php"); 
	}
    
   /*page_open(array(
					"sess"=>"local_Session",
					"auth"=>"local_Default_Auth"
					));
	*/
    page_open(array(
					"sess"=>"User_Session",
					"auth"=>"local_Default_Auth" 
    ));   
    
    $page_id    = isset($_GET["page_id"])   ? $_GET["page_id"]  : ( isset($_POST["page_id"])    ? $_POST["site_id"] : '' );
    $infoArr    = explode("/",$_SERVER["PATH_INFO"]);
    $page_name  = $infoArr[(count($infoArr)-1)];
 
    include(THIS_DOMAIN_PATH."/eCraft-appheader.php");
    //include(THIS_PATH."/eCraft-appheader.php");

	$variables["full_url"] = $_SERVER["PATH_INFO"] ;
	$variables["page_name"] = $page_name ;


    if ( !empty($page_name) || !empty($page_id) ) {
        if ( empty($page_id) ) {
            $page_name = eregi_replace("\.html|\.php|\.asp|\.jsp", "", $page_name);
            
            $condition = " WHERE ". PREFIX.TABLE_STATIC_PAGES .".page_name='". $page_name ."' "
                            ." AND ". PREFIX.TABLE_STATIC_PAGES .".page_status='1' AND ".PREFIX.TABLE_STATIC_PAGES.".domain_ids LIKE '%,".SITE_ID.",%'";

            $query = "SELECT page_id FROM ". PREFIX.TABLE_STATIC_PAGES ." ". $condition ;
            if ( $db->query($query) && $db->nf()>0 && $db->next_record() ) {
               $current_page_id = $page_id = $db->f("page_id");				
            }
        }
        
		if(empty($page_id)){
			/**************
			If page_id ==0 that means page name is changed or that page is not exist.
			STEP 1 - Check Current page in Page_Url table and redirect it to the selected URL 
					 If current page is not found in Page_Url then redirect it to home page			
			***************/
			
			$sql = "SELECT old_page_name, redirect_page_id  FROM ". TABLE_STATIC_PAGES_URL." WHERE  "." old_page_name = '".$page_name."' ORDER BY do_e DESC LIMIT 0,1 "		 ;
			$db->query( $sql );
			if($db->nf() > 0 ){
				while (	$db->next_record()	) {
					$page_id = $db->f("redirect_page_id"); 
					$murl = sprintf(URL_S, getPageName($db, $page_id));  
					$murl .= ".html";  
					header("Location:".$murl."");					
				    
				}
			}else{
				header("Location:". THIS_DOMAIN ."");
			}
		}
		
        $condition = " WHERE ". PREFIX.TABLE_STATIC_PAGES .".page_id = '". $page_id ."' "
                        ." AND ". PREFIX.TABLE_STATIC_PAGES .".page_status = '1' "
                        ." AND (". PREFIX.TABLE_STATIC_PAGES .".page_access = '0' ";
						
		
        if ( $logged_in ) {
            $condition .= " OR ". PREFIX.TABLE_STATIC_PAGES .".page_access ='2' ";
        }
        else {
            $condition .= " OR ". PREFIX.TABLE_STATIC_PAGES .".page_access ='1' ";
        }
        $condition .= ")  AND ".PREFIX.TABLE_STATIC_PAGES.".domain_ids LIKE '%,".SITE_ID.",%'" ;	
        
        //$query = "SELECT * FROM ". PREFIX.TABLE_STATIC_PAGES ." ". $condition ;
		
		$query = "SELECT ".PREFIX.TABLE_STATIC_PAGES.".*,".TABLE_TEMPLATES.".template FROM ". PREFIX.TABLE_STATIC_PAGES ." 
		LEFT JOIN ".TABLE_TEMPLATES." ON ".TABLE_TEMPLATES.".id=".PREFIX.TABLE_STATIC_PAGES.".template_id ". $condition ;
		
        if ( $db->query($query) && $db->nf()>0 && $db->next_record() ) {
            $data = processSQLData($db->result());
            //$MAIN_CONTENT	= stripslashes( $db->f("template") );
			
			$MAIN_CONTENT	= $data['template'];
            if ( $data["show_heading"] ) {
                $variables["PAGE_HEADING"]  = $data["heading"];
            }
            if ( !empty($data["meta_keyword"]) ) {
                $variables["PAGE_KEYWORDS"]   = $data["meta_keyword"];
            }
            if ( !empty($data["meta_desc"]) ) {
                $variables["PAGE_DESC"]   = $data["meta_desc"];
            }
            $variables["PAGE_CONTENT"]  = $data["content"];
        }
        else {
            /*
			$query = "SELECT ".TABLE_TEMPLATES.".template FROM ".TABLE_TEMPLATES." WHERE ".TABLE_TEMPLATES.".default_template='1' LIMIT 0,1 " ;
			if ( $db->query($query) && $db->nf()>0 && $db->next_record() ) {
				$data = processSQLData($db->result());
				$MAIN_CONTENT	= $data['template'];
			}	
			$variables["PAGE_CONTENT"]  = $s->fetch("noPage.html");
			*/
			header("Location:". THIS_DOMAIN ."");
        }
    }
    else {
        /*
		$query = "SELECT ".TABLE_TEMPLATES.".template FROM ".TABLE_TEMPLATES." WHERE ".TABLE_TEMPLATES.".default_template='1' LIMIT 0,1 " ;
		if ( $db->query($query) && $db->nf()>0 && $db->next_record() ) {
			$data = processSQLData($db->result());
			$MAIN_CONTENT	= $data['template'];
		}	
		$variables["PAGE_CONTENT"]  = $s->fetch("noPage.html");
		*/
		header("Location:". THIS_DOMAIN ."");
    }
    $variables["full_url"] ="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $s->assign("variables",$variables);
    $s->assign("current_page_id",$current_page_id);
    $PAGE_CONTENT1 = $s->fetch("string:".$variables["PAGE_CONTENT"]);
    $s->assign("CONTENT", $PAGE_CONTENT1);
	
	$MAIN_CONTENT1 = $s->fetch("string:".$MAIN_CONTENT);
	$s->assign("MAIN_CONTENT", $MAIN_CONTENT1);
	$s->display("0-eCraft-homepage.html");
	
    
?>