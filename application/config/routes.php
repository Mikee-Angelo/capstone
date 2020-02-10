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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//AUTHENTICATION MICROSERVICE
$route['api/v1/login/student'] = 'Auth/student';
$route['api/v1/login/admin'] = 'Auth/admin';
$route['api/v1/login/faculty'] = 'Auth/faculty';

//STUDENTS MICROSERVICE
$route['api/v1/students'] = 'Students/index';

//ADMIN MICROSERVICE
$route['api/v1/admin'] = 'Admin/index';

//COURSES MICROSERVICE
$route['api/v1/courses'] = 'Course/index';

//DEPARTMENTS MICROSERVICE
$route['api/v1/departments'] = 'Departments/index';

//SUBJECT MICROSERVICE
$route['api/v1/subjects'] = 'Subjects/index';

//REPORTS MICROSERVICE
$route['api/v1/reports'] = 'Reports/index';

//REPORTS MICROSERVICE
$route['api/v1/faculty'] = 'Faculty/index';

//REPORTS MICROSERVICE
$route['api/v1/faculty'] = 'Faculty/index';
$route['api/v1/faculty/degree'] = 'Faculty/degree';
$route['api/v1/faculty/taught'] = 'Faculty/taught';
$route['api/v1/faculty/qualifications'] = 'Faculty/qualifications';

//GENDER 
$route['api/v1/genders'] = 'Gender/index';
//CITIZENSHIP 
$route['api/v1/citizenships'] = 'Citizenship/index';
//CIVIL STATUS 
$route['api/v1/civil-status'] = 'Civilstatus/index';
//STATUS 
$route['api/v1/status'] = 'Status/index';
//REPORT ACTION 
$route['api/v1/actions'] = 'Action/index';
//FACULTY TYPES
$route['api/v1/types'] = 'Types/index';