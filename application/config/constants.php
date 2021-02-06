<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

 #### Contants Variable sign for form Fields Name in hindi, Other hindi word #### 

define('REQUIRED', '<span class="text-red">*</span>');	

/*define('SEHMATI_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/images/sehmati_patra/');
define('IMAGE_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/images/');
define('SIGN_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/images/sign/');
define('MOTHER_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/images/mother_images/');
define('PDFDirectory', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/PdfFile/');
define('BABY_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/images/baby_images/');
define('babyWeightDirectory', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/images/baby_images/weight');
define('REPORT_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/mncu/assets/images/investigation_images/');

define('BABY_IMAGE', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/images/baby_images/');
define('MOTHER_IMAGE', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/images/mother_images/');
define('VIDEO_URL', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/video/');
define('PDF_FILE', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/PdfFile/');
define('SIGN_IMAGE', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/sign/');
define('IMAGE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/images/');
define('SIGN_URL', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/images/sign/');
define('NurseProfile', 'http://'.$_SERVER['HTTP_HOST'].'/mncu/assets/nurse/');*/

define('APP_NAME', 'kmcV2');
define('folderName', 'kmcV2Development');

define('sehmatiPatra', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/sehmatiPatra/');
define('imageDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/');
define('signDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/sign/');
define('loungeDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/lounge/');
define('motherDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/motherImages/');
define('padDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/motherImages/pad/');
define('pdfDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/pdfFile/');
define('babyDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/babyImages/');
define('babyWeightDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/babyImages/weight/');
define('babyTemperaturetDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/babyImages/temperature');
define('commentDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/babyImages/comment/');
define('reportDirectory', $_SERVER['DOCUMENT_ROOT'].'/'.folderName.'/assets/images/investigationImages/');

define('sehmatiPatraUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/sehmatiPatra/');
define('babyDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/babyImages/');
define('motherDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/motherImages/');
define('videoDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/video/');
define('videoThumbnailDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/video/thumbnail/');
define('pdfDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/pdfFile/');
define('imageDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/');
define('signDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/sign/');
define('babyWeightDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/babyImages/weight/');
define('babyTemperaturetDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/babyImages/temperature/');
define('commentDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/babyImages/comment/');
define('loungeDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/lounge/');
define('investigationDirectoryUrl', 'http://'.$_SERVER['HTTP_HOST'].'/'.folderName.'/assets/images/investigationImages/');

//directory for storing images related babywisedoctorround api images



define('PushAPI_KEY', 'AAAAqjwzoi4:APA91bHSs95rX3nvPGVAuOPCt4-eqcRL4A1TB4-Wc0tLLmzNgkzout4wAH_AEaHxBw3of06OyjBEhx0-DksHSlHrENeXIG-wbx_jXAVTnYqNbWyTRmeyL7jsYVrdRp3BAhdt3zngEpU1');

define('PASSWORD','password');
define('EMAIL','email');
define('STATUS','status');
define('FORM_SUMMIT', 'फोन नंबर। सीएमएस / एमओआईसी का');	

define('DASHBOARD','Dashboard Control Pannel');   #  For Dashboard लाउंज प्रबंधित करें
define('MANAGE_LOUNGE','लाउंज प्रबंधित करें');   #  For MANAGE_LOUNGE
define('ADD_LOUNGE', 'नई लाउंज जोड़ें') ; # for Add Lounge

define('SELECT_FACILITY','चयन सुविधा');   #  For SELECT facility Drop Down  लाउंज प्रबंधित करें
define('CHOOSE_FACILITY', 'सुविधा का चयन करें') ; # for Add Lounge
define('FACILITIES', 'सुविधाएं') ; # for Add Lounge

define('NEW_FACILITY', 'नई सुविधा') ; # for Add Lounge

define('SR_NO', 'नई सुविधा') ; # for Add Lounge


define('FACILITY_NAME', 'सुविधा का नाम');
define('FACILITY_MANGEMENT_TYPE', 'सुविधा प्रबंधन प्रकार');

define('PUBLIC_MNG', 'जनता');
define('PRIVATE_FOR_PROFIT', 'निजी लाभ के लिए');

define('PRIVATE_CHARITY', 'निजी चैरिटी');
define('TYPE_OF_FACILITIES', 'सुविधाओं का प्रकार');


define('DH', 'डीएच');

define('CHC', 'सीएचसी');

define('PHC', 'पीएचसी');

define('SUB_CENTER', 'उप-केन्द्र');

define('MEDICAL_COLL', 'चिकित्सा महाविद्यालय');

define('SPECIALITY_HOSPITAL', 'स्पेशलिटी अस्पताल');


define('KMC_LOUNGE_PRESENT', 'KMC लाउंज मौजूद है?');

define('YES', 'हाँ');
define('NO', 'नहीं');

define('TYPE_OF_CARING_FOR_NEWBORN', 'नवजात शिशु के लिए देखभाल का प्रकार ?');

define('NICU','एन.आई.सी.यू');
define('SNCU','एस.एन.सी.यू');
define('NBSU','एन.बी.एस.यू');
define('NBCC','एन.बी.सी.सी');
define('ADDRESS','पूरा पता');

define('VILL_TOWN_CITYNAME', 'ग्राम / नगर / शहर का नाम');

define('BLOCK_NAME', 'ब्लॉक का नाम');

define('DISTRICT_NAME', 'जिला का नाम');
define('STATE_NAME', 'राज्य का नाम');
define('COUNTRY_NAME', 'देश का नाम');

define('ADMINISTRATION_PHONE_NUMBER', 'प्रशासनिक फ़ोन नंबर');

define('CMS_MIOC_NAME', 'सीएमएस / एमओआईसी नाम');

define('PHONE_NO_CMS_MIOC_NAME', 'फोन नंबर। सीएमएस / एमओआईसी का');
define('PROJECT_NAME', 'KMC');
define('PROJECTNAME', 'The Kangaroo Care Project');
define('PACKAGE', 'com.kmc.android');
define('RegistrationContent', 'Baby Via AdmissionId');
define('VIEW_BUTTON', 'View');
define('EDIT_BUTTON', 'Edit');
define('DATA_PER_PAGE', '20');


/*define('MANAGE_LOUNGE','लाउंज प्रबंधित करें');   #  For MANAGE_LOUNGE*/

