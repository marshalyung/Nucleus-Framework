<?php
/**
 * Definition of system messages to be shown to end-users
 *
 * @package     Config
 * @since       Feb 6, 2010
 * @version     1.0
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */
define('SIGN_IN_FAILED', 'Sign in failed! Either your username or password is incorrect.');
define('SESSION_EXPIRED', 'Sorry, but you need to sign in to access the intended page.');
define('MOD_MISSING', 'Sorry, the module you mentioned seems to be missing');
define('MOD_INDEX_MISSING', 'The "<em>index.php</em>" file for the intended module seems to be missing');
define('MOD_CFG_ERR', 'Your module\'s configuration appears to be incorrect');
define('PERMISSION_DENIED', 'Sorry, you do not have enough permission to perform the action');
define('MENU_STRUCT_ERROR', 'One of your menu\'s structure definition seems to be incorrect');
define('MENU_NOT_EXIST', 'This menu is either missing or has not been registered into Nucleus');
define('UPLOAD_FILESIZE_DENIED', 'The file you are trying to upload is too large');
define('UPLOAD_MIME_TYPE_DENIED', 'Sorry, we cannot allow this MIME type for security purpose');
define('UPLOAD_FILE_TYPE_DENIED', 'Sorry, we cannot allow this file extension for security purpose');
define('MIME_TYPE_LIST_ERROR', 'It seems like the definition for the list of allowed MIME types is wrongly defined');
define('FILE_TYPE_LIST_ERROR', 'It seems like the definition for the list of allowed file types is wrongly defined');
define('DUPLICATE_APPLICATION_NAME', 'The application name you specified has already exist. Please choose another name for your application');
define('INVALID_DIRECTORY', 'The path you specified is not a valid directory');
define('DIRECTORY_CREATION_FAILED', 'One or more directories creation has failed');
define('MAIL_SERVER_CONNECT_FAILED', 'We are unable to contact your mail server. Either it is very busy at the moment or your mail settings are incorrect. Please check your <a class="links" href="http://accounts.synapsesondemand.com/index.php?module=Mail&view=mail_account" target="_blank">e-mail settings</a> or try again later');
define('MAIL_CFG_INCOMPLETE', 'You have not added your e-mail account yet. Go to <a class="links" href="http://accounts.synapsesondemand.com/?module=Accounts&view=me" target="_blank">account settings</a> to add a new e-mail account to receive and send e-mails.');
define('MAILBOX_NOT_FOUND', 'The mailbox you were trying to open is not found');
?>