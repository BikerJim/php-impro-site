<?php

    // these two constants are used to create root-relative web addresses
    // and absolute server paths throughout all the code

	define("BASE_URL","/practice/");
	define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"] . "/practice/");
   /*
    * This is the DB stuff and is unique to your database
   */
	define("DB_HOST","localhost"); // if hosted on the same webserver
	define("DB_NAME","nameofdatabase"); // whatever you called your database
	define("DB_PORT","3306"); // default: 3306
     /*
      * The DB_USER should be a non-root user, enabled only for
      * SELECT, UPDATE, DELETE, INSERT duties
     */
	define("DB_USER","web_username"); 
	define("DB_PASS","securepasswordhere");
	define("CAN_REGISTER", "any");
	define("DEFAULT_ROLE", "member");
 	define("SECURE", FALSE); // Development ONLY!!! TRUE when in production
