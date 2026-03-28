<?php
//IMathAS Math Config File.  Adjust settings here!

//database access settings
$dbserver = "127.0.0.1";
$dbname = "IMathAS";
$dbusername = "IMathAS";
$dbpassword = "mzpS8u7Cbvrdj26L";

//error reporting level.  Set to 0 for production servers.
error_reporting(E_ALL & ~E_NOTICE);

//GROUP: PATH SETTINGS
//web path to install
//web root to imathas:  http://yoursite.com $imasroot
//set = "" if installed in web root dir
$imasroot = "/IMathAS";

//base site url - use when generating full URLs to site pages.
$httpmode = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')
|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']=='https')
	? 'https://' : 'http://';
	$GLOBALS['basesiteurl'] = $httpmode . Sanitize::domainNameWithPort($_SERVER['HTTP_HOST']) . $imasroot;

//absolute path or full url to Mimetex CGI, for math image fallback
//if you do not have a local install, feel free to use:
//$mathimgurl = "https://www.imathas.com/cgi-bin/mimetex.cgi";
$mathimgurl = "http://localhost/cgi-bin/mimetex.cgi";
//$mathimgurl = "/cgi-bin/mimetex.cgi";

//lokale installation auf netmath
//$mathimgurl = "https://netmath.vcrp.de/cgi-bin/mimetex.cgi";


//This is used to change the session file path different than the default.
  //This is usually not necessary unless your site is on a server farm, or
  //you're on a shared server and want more security of session data.
  //This may also be needed to allow setting the garbage collection time limit
  //so that session data isn't removed after 24 minutes.
  //Make sure this directory has write access by the server process.
  //$sessionpath = '/tmp/persistent/imathas/sessions';

  //math live chat server - comment out to not use
  //Chat uses its own database tables, and draws user info from the
  //query string rather than from the IMathAS user tables, so you
  //can use the chat server on a different IMathAS install
  //to reduce the server load on the main install.
  //use this URL to use the local server:
  $mathchaturl = "$imasroot/mathchat/index.php";

$CFG['GEN']['livepollserver'] ="netmath.vcrp.de";
$CFG['GEN']['livepollpassword'] = "y99v7aDPOIU";


// GROUP: USER RIGHTS

// Anmelden als Gast guest ohne Passwort ermöglichen (guestaccount) !!! ID !!!
//if you want to allow people to create guest accounts by just logging in with username "guest",
  //provide an arrary of course ids to automatically enroll them in
$CFG['GEN']['guesttempaccts'] = array();
$CFG['GEN']['filewhitelist'] = [ ".jpg", ".jpeg", ".png", ".gif", ".webp", ".heic", ".tiff", ".bmp", ".svg", ".docx", ".xlsx", ".pptx", ".doc", ".xls", ".ppt", ".pdf", ".rtf", ".txt", ".odt", ".ods", ".odp", ".pages", ".numbers", ".key", ".nb", ".nbp", ".mw", ".mws", ".m", ".mat", ".mlx", ".tex", ".zip", ".rar", ".7z", ".tar.gz", ".mp4", ".mov", ".avi", ".mkv", ".mp3", ".m4a", ".imas"];

//should non-admins be allowed to create new non-group libraries?
//on a single-school install, set to true; for larger installs that plan to
//use the instructor-groups features, set to false
$allownongrouplibs = true;

//should anyone be allowed to import/export questions and libraries from the
//course page?  Intended for easy sharing between systems, but the course page
//is cleaner if turned off.
$allowcourseimport = false;

//allow installation of macro files by admins?  macro files contain a large
//security risk.  If you are going to have many admins, and don't trust the
//security of their passwords, you should set this to false.  Installing
//macros is equivalent in security risk to having FTP access to the IMathAS
//server.
//For single-admin systems, it is recommended you leave this as false, and
//change it when you need to install a macro file.  Do install macro files
//using the web system; a help file is automatically generated when you install
//through the system
$allowmacroinstall = true;

//template user id
//Generally not needed.  Use if you want a list of Template courses in the
//copy course items page.  Set = to a user's ID who will serve as the
//template holder instructor.  Add that user to all courses to list as a
//template
//$templateuser = 10;

// GROUP: ORGANIZATION SPECIFIC SETTINGS

$CFG['locale'] = "de_DE.UTF-8";
//$CFG['locale'] = "de";

//`$CFG['nocommathousandsseparator']`: set to `true` to disallow the use of comma as a thousands separator in large numbers.
$CFG['nocommathousandsseparator'] = true;

//The name for this installation.  For personalization
$installname = "IMathAS";

//login prompts
$loginprompt = "Username";
$longloginprompt = "Enter a username.  Use only numbers, letters, or the _ character.";
$loginformat = '/^[\w+\-]+$/';

//require email confirmation of new users?
$emailconfirmation = false;

//email to send notices from
$sendfrom = "imathas@yoursite.edu";

//color shift icons as deadline approaches?
$colorshift = true;

//path settings
//web path to install
$imasroot = "";

//base site url - use when generating full URLs to site pages.
$httpmode = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
	? 'https://' : 'http://';
$GLOBALS['basesiteurl'] = $httpmode . Sanitize::domainNameWithPort($_SERVER['HTTP_HOST']) . $imasroot;

//mimetex path
$mathimgurl = "http://www.imathas.com/cgi-bin/mimetex.cgi";

//enable lti?
$enablebasiclti = true;

//allow nongroup libs?
$allownongrouplibs = false;

//allow course import of questions?
$allowcourseimport = false;

//allow macro install?
$allowmacroinstall = true;

//use more secure password hashes? requires PHP 5.3.7+
$CFG['GEN']['newpasswords'] = 'only';
$CFG['GEN']['headerinclude'] = "headerincludehsrm.php";
$CFG['locale'] = 'de';
//session path 
//$sessionpath = "";

//Amazon S3 access for file upload 

//$AWSkey = "";

//$AWSsecret = "";

//$AWSbucket = "";


//Uncomment to change the default course theme, also used on the home & admin page:
$defaultcoursetheme = "hsrm.css";

//To change loginpage based on domain/url/etc, define $loginpage here

//no need to change anything from here on
  /* Connecting, selecting database */
  // MySQL with PDO_MYSQL
  try {
    $DBH = new PDO("mysql:host=$dbserver;dbname=$dbname;charset=latin1", $dbusername, $dbpassword);
    $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
    $GLOBALS["DBH"] = $DBH;
  } catch(PDOException $e) {
    die("Could not connect to database: " . $e->getMessage());
  }
  $DBH->query("set session sql_mode=''");

	  unset($dbserver);
	  unset($dbusername);
	  unset($dbpassword);

?>