<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['facility/(:any)'] = "FacilityManagenent/$1";
$route['facility/(:any)/(:any)'] = "FacilityManagenent/$1/$1";
$route['facility'] = "FacilityManagenent/index";

$route['loungeM/(:any)'] = "LoungeManagenent/$1";
$route['loungeM/(:any)/(:any)'] = "LoungeManagenent/$1/$1";
$route['loungeM/(:any)/(:any)/(:any)'] = "LoungeManagenent/$1/$1/$1";
$route['loungeM'] = "LoungeManagenent/index";

$route['motherM/(:any)'] = "MotherManagenent/$1";
$route['motherM/(:any)/(:any)'] = "MotherManagenent/$1/$1";
$route['motherM/(:any)/(:any)/(:any)'] = "MotherManagenent/$1/$1/$1";
$route['motherM'] = "MotherManagenent/index";

$route['babyM/(:any)'] = "BabyManagenent/$1";
$route['babyM/(:any)/(:any)'] = "BabyManagenent/$1/$1";
$route['babyM/(:any)/(:any)/(:any)'] = "BabyManagenent/$1/$1/$1";
$route['babyM'] = "BabyManagenent/index";

$route['staffM/(:any)'] = "StaffManagenent/$1";
$route['staffM/(:any)/(:any)'] = "StaffManagenent/$1/$1";
$route['staffM/(:any)/(:any)/(:any)'] = "StaffManagenent/$1/$1/$1";
$route['staffM'] = "StaffManagenent/index";

$route['videoM/(:any)'] = "VideoManagenent/$1";
$route['videoM/(:any)/(:any)'] = "VideoManagenent/$1/$1";
$route['videoM'] = "VideoManagenent/index";

$route['smsM/(:any)'] = "SmsManagenent/$1";
$route['smsM/(:any)/(:any)'] = "SmsManagenent/$1/$1";
$route['smsM'] = "SmsManagenent/index";

$route['supplimentM/(:any)'] = "SupplimentManagenent/$1";
$route['supplimentM/(:any)/(:any)'] = "SupplimentManagenent/$1/$1";
$route['supplimentM'] = "SupplimentManagenent/index";

$route['Miscellaneous/(:any)'] = "MiscellaneousManagenent/$1";
$route['Miscellaneous/(:any)/(:any)'] = "MiscellaneousManagenent/$1/$1";
$route['Miscellaneous'] = "MiscellaneousManagenent/index";

$route['employeeM/(:any)'] = "EmployeeManagenent/$1";
$route['employeeM/(:any)/(:any)'] = "EmployeeManagenent/$1/$1";
$route['employeeM/(:any)/(:any)/(:any)'] = "EmployeeManagenent/$1/$1/$1";
$route['employeeM'] = "EmployeeManagenent/index";

$route['Location/(:any)'] = "LocationManagenent/$1";
$route['Location/(:any)/(:any)'] = "LocationManagenent/$1/$1";
$route['Location'] = "LocationManagenent/index";

$route['enquiryM/(:any)'] = "EnquiryManagenent/$1";
$route['enquiryM/(:any)/(:any)'] = "EnquiryManagenent/$1/$1";
$route['enquiryM'] = "EnquiryManagenent/index";

$route['notificationM/(:any)'] = "NotificationManagenent/$1";
$route['notificationM/(:any)/(:any)'] = "NotificationManagenent/$1/$1";
$route['notificationM'] = "NotificationManagenent/index";

$route['coachM/(:any)'] = "CoachManagenent/$1";
$route['coachM/(:any)/(:any)'] = "CoachManagenent/$1/$1";
$route['coachM'] = "CoachManagenent/index";

$route['counsellingM/(:any)'] = "CounsellingManagenent/$1";
$route['counsellingM/(:any)/(:any)'] = "CounsellingManagenent/$1/$1";
$route['counsellingM'] = "CounsellingManagenent/index";

$route['GenerateReportM/(:any)'] = "GenerateReport/$1";
$route['GenerateReportM/(:any)/(:any)'] = "GenerateReport/$1/$1";
$route['GenerateReportM/(:any)/(:any)/(:any)'] = "GenerateReport/$1/$1/$1";
$route['GenerateReportM'] = "GenerateReport/index";

$route['MemoryM/(:any)'] = "MemoryManagenent/$1";
$route['MemoryM/(:any)/(:any)'] = "MemoryManagenent/$1/$1";
$route['MemoryM/(:any)/(:any)/(:any)'] = "MemoryManagenent/$1/$1/$1";
$route['MemoryM'] = "MemoryManagenent/index";

$route['ProfileM/(:any)'] = "ProfileManagement/$1";
$route['ProfileM/(:any)/(:any)'] = "ProfileManagement/$1/$1";
$route['ProfileM/(:any)/(:any)/(:any)'] = "ProfileManagement/$1/$1/$1";
$route['ProfileM'] = "ProfileManagement/index";