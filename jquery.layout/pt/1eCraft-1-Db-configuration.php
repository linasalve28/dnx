<?php
	
/*******************************************************************************************************************
	* Sujeet Maanke is the owner of this Application Product.
	* Copyright of the programming code of this Application Product is with Sujeet Maanke
	* This product and all its future version and its entire programming code is the sole property of Sujeet Maanke. 
	* Any type of copy or reproduction without the consent of Sujeet Maanke is prohibited.
	* PRECISION is authorized by Sujeet Maanke to resell the user licenses of this Application Product.
	* Under any circumstances the ownership of this product is of Sujeet Maanke
	* All Rights Reserved. Copyright 2007 Sujit Manke - PRECISION
	* eCraft ver 16.0 Build 2013
	* Purpose of the file - It contains the Configuration of the product like Paths, Variables etc.
********************************************************************************************************************/
	
 
	$ddomain = preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']); // provides the domain name without www. 
	define('DB_HOST_COMMON','localhost');
	define('DB_USER_COMMON','mywebsit_myprsr1');
	define('DB_PASS_COMMON','TR#DK34DKT3D3d%2DK34DKTR#33JTR#FDK34DKTR#334DsFkR#33#2#sdf#G');
	define('DB_NAME_COMMON','mywebsit_manageec_mainecraftdb');
	
	define('TABLE_AUTH_DOMAIN', "eCraft_1_Auth_Domain");  
	
	class DB_Common
	{
		public static function makeConnection()
		{
			$con = mysql_connect(DB_HOST_COMMON, DB_USER_COMMON, DB_PASS_COMMON );
			if ( ! $con )
				die( "Couldn't connect to MySQL. Check eCraft-1-Db-configuration common file ".mysql_error());
				
			mysql_select_db( DB_NAME_COMMON, $con ) or die( "Couldn't open {DB_NAME_COMMON} database. ".mysql_error() );
			
			return( $con );
		}

		public static function closeConnection( $con )
		{
			mysql_close( $con );
		}
	}	
	
	
	$con = DB_Common::makeConnection();	
	$query = "SELECT id, db_host, db_name, db_user, db_pass,since_dt,domain,default_home_page, no_pages,upload_folder,ref_site_id  FROM ". TABLE_AUTH_DOMAIN."
			WHERE  "." domain = '".$ddomain."' AND status='1' " ;			
	$result = mysql_query($query,$con);
	if( mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)){
			
			$GLOBALS['db_host'] = $row['db_host'];  
			$GLOBALS['db_name']  = $row['db_name']; 
			$GLOBALS['db_user']  = $row['db_user']; 
			$GLOBALS['db_pass']  = $row['db_pass']; 
			$GLOBALS['user_domain']   = $row['domain']; 
			$GLOBALS['upload_folder']   = $row['upload_folder']; 
			$GLOBALS['default_home_page']   = $row['default_home_page']; 
			$GLOBALS['domain_id']  = $row['id']; 
			if(!empty($row['ref_site_id'])){
				$GLOBALS['domain_id']  = $row['ref_site_id']; 
			}
		} 
		DB_Common::closeConnection($con);
	}else{
		echo "<div style=\"padding-top:30px;\"><h1>Please check contact your service provider, as details of ".$ddomain." not found.</h1></div>";
		DB_Common::closeConnection($con);
		exit;
	}
	 
?>