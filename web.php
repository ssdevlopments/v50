<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['XSS']], function () {
	
	Route::get('/', function () {
		
		Session::put('sess_institute_type', 'School');
		Session::put('institute_code', 'APSHIS');
		Session::put('session_code', '2019-20_APSHIS');
		Session::put('institute_name', 'Dhaulakuan Army School');
		Session::put('logo_url', '');
		
		Session::put('role_codes', '');
		
		Session::put('user_code', 'admin001');
		Session::put('user_name', 'admin001');
		
		Session::put('primary_role_code','');
		Session::put('display_name', 'admin001');
		
		Session::put('profile_image_url', '');
		Session::put('password_status', '');
		
		Session::put('session_name', '2019-20');
		Session::put('session_date_from', '2019-04-01');
		Session::put('session_date_to', '2020-03-31');
		
	});
	
	// Route::get('/','LoginController@index');
	Route::get('/logout/{role_code}','LoginController@logout');
	Route::post('/postLogin','LoginController@postLogin');
	Route::get('/choose-session/{role_code}','LoginController@chooseSession')->name('chooseSessionPage');
	Route::get('/choose-session/{role_code}','LoginController@chooseSessionPage');
	Route::post('/postChooseSession','LoginController@postChooseSession');
	/* SUPER ADMIN ROUTES*/
	Route::get('/su_login','super\SUController@index');
	Route::post('/super/postLogin','super\SUController@postLogin');
	Route::group(['middleware' => 'usersession'], function () {
		Route::get('/dashboard/getDashboard/{role_code}','super\SUController@getDashboard');
		Route::get('/dashboard/{dashboard_page}/{role_code}','super\SUController@dashboardPage')->name('homePage');
	});
});

Route::group(['middleware' => 'usersession'], function () {
	Route::group(['middleware' => ['XSS']], function () {
		/* SCHOOL ROUTES*/
		$school_groups = [
	    'school', 'k12academics','k12studentadmin'
		];
		foreach ($school_groups as $group)
		{

		    Route::prefix($group)->group(function () {
				
				
				Route::get('/dashboard','School\SetupController@dashboardPage');
				
				/*Manage Master*/
				Route::get('/master-page','School\SetupController@masterPage');
				
				Route::get('/master-page/api/SELECT_SESSION','School\SetupController@selectSession');
				Route::post('/master-page/api/SESSION_CHKDUCPLICATE','School\SetupController@sessionCheckDuplicate');
				Route::post('/master-page/api/SESSION_CHK_STATUS','School\SetupController@sessionCheckStatus');
				Route::get('/master-page/api/SELECT_ALL_SESSION','School\SetupController@selectAllSession');

				Route::get('/master-page/api/SELECT_ALL_COURSE','School\SetupController@selectAllCourse');
				Route::get('/master-page/api/SELECT_ALL_COURSE_AJAX','School\SchoolCommonController@selectAllCourseAjax');

				// Common
				Route::get('/master-page/api/SELECT_ALL_CLASS_BY_COURSE_AJAX','School\SchoolCommonController@selectAllClassByCourseAjax');
				Route::get('/master-page/api/SELECT_ALL_SECTION_BY_COURSE_CLASS_AJAX','School\SchoolCommonController@selectAllSectionByCourseClassAjax');

				Route::get('/master-page/api/SELECT_ALL_CLASS','School\SetupController@selectAllClass');
				Route::get('/master-page/api/SELECT_ALL_CLASS_AJAX','School\SchoolCommonController@selectAllClassAjax');

				Route::get('/master-page/api/SELECT_ALL_SECTION','School\SetupController@selectAllSection');
				Route::get('/master-page/api/SELECT_ALL_SECTION_AJAX','School\SchoolCommonController@selectAllSectionAjax');
				Route::get('/master-page/api/SELECT_ALL_GROUP_VALUE_AJAX','School\SchoolCommonController@selectAllGroupValueAjax');
				Route::get('/master-page/api/SELECT_ALL_GENCODE_DESC/{code_group}','School\SchoolCommonController@selectAllGenCodeAjax');

				Route::get('/master-page/api/SELECT_ALL_SUBJECT','School\SetupController@selectAllSubject');
				Route::get('/master-page/api/SELECT_ALL_SUBJECT_AJAX','School\SchoolCommonController@selectAllSubjectAjax');

				Route::get('/master-page/api/SELECT_ALL_GROUP_VALUE','School\SetupController@selectAllGroup');
				Route::get('/master-page/api/SELECT_ENTITY','School\SetupController@selectAllDocument');
				Route::get('/master-page/api/SELECT_ALL_HOUSE','School\SetupController@selectAllHouse');

				Route::post('/master-page/api/AddSession','School\SetupController@saveSession');
				Route::post('/master-page/api/editSession','School\SetupController@editSession');
				Route::post('/master-page/api/DeleteSession','School\SetupController@DeleteSession');
				Route::post('/master-page/api/AddCourse','School\SetupController@saveCourse');
				Route::post('/master-page/api/DeleteCourse','School\SetupController@DeleteCourse');
				Route::post('/master-page/api/AddClass','School\SetupController@saveClass');
				Route::post('/master-page/api/DeleteClass','School\SetupController@DeleteClass');
				Route::post('/master-page/api/AddSection','School\SetupController@saveSection');
				Route::post('/master-page/api/DeleteSection','School\SetupController@DeleteSection');
				Route::post('/master-page/api/AddSubject','School\SetupController@saveSubject');
				Route::post('/master-page/api/DeleteSubject','School\SetupController@DeleteSubject');
				Route::post('/master-page/api/AddGroup','School\SetupController@saveGroup');
				Route::post('/master-page/api/DeleteGroup','School\SetupController@DeleteGroup');
				Route::post('/master-page/api/AddHouse','School\SetupController@saveHouse');
				Route::post('/master-page/api/DeleteHouse','School\SetupController@DeleteHouse');
				
				Route::get('/master-page/api/SELECT_ENTITY','School\SetupController@selectEntity');
				Route::get('/master-page/api/SELECT_ALL_DOCUMENT','School\SetupController@selectAllDocuments');
				Route::post('/master-page/api/SAVE_DOCUMENTS','School\SetupController@saveAllDocuments');
				

				Route::get('/master-page/api/SELECT_ALL_CCSubjects','School\MappingController@selectAllCCSubjects');
				Route::get('/master-page/api/SELECT_ALL_CCSections','School\MappingController@selectAllCCSections');
				Route::get('/master-page/api/SELECT_ALL_CCOptional','School\MappingController@selectAllCCOptionals');

			// Attendance
				Route::get('/attendance-page','School\SetupController@attendancePage');
				Route::get('/attendance-page/api/ATTENDANCE_PERIOD','School\SchoolAttendanceController@attendanceperiod');
				Route::get('/attendance-page/api/ATTENDANCE_HOLIDAY','School\SchoolAttendanceController@attendanceholiday');
				Route::post('/attendance-page/api/INSERT_PERIOD','School\SchoolAttendanceController@insertperiod');
				Route::post('/attendance-page/api/DELETE_PERIOD','School\SchoolAttendanceController@deleteperiod');
				Route::post('/attendance-page/api/INSERT_HOLIDAY','School\SchoolAttendanceController@insertholiday');
				
				Route::get('/manage/attendance','School\SchoolAttendanceController@attendanceManagePage');
				Route::get('/attendance/api/SELECT_ALL_ATTN_SUBJECTS','School\SchoolAttendanceController@selectAllAttnSubjects');
				Route::get('/attendance/api/GET_ATTN_DATES','School\SchoolAttendanceController@getattndates');
				Route::get('/attendance/api/DELETE_ATTN_DATES','School\SchoolAttendanceController@deleteattndates');
				Route::get('/attendance/entry/{ccs_code}','School\SchoolAttendanceController@attendanceEntryPage');

				Route::get('/attendance/{ccs_code}/{subject_code}/{attendance_id}','School\SchoolAttendanceController@attendanceedit');
				Route::get('/attendance/api/SAVE_ATTENDACE','School\SchoolAttendanceController@saveattendace');

			// Assignments
				Route::get('/section/assignment','School\AssignmentController@sectionAssignmentListPage');
				Route::get('/student/section/assign/entry/{ccs_code}','School\AssignmentController@sectionAssignmentEntryPage');
				Route::post('/student/section/assign/entry/order','School\AssignmentController@sectionAssignmentEntryPageOrder');
				Route::post('/student/section/assign/entry/save','School\AssignmentController@sectionAssignmentEntryPageSave');
				Route::get('/student/section/assign/excel/upload','School\AssignmentController@sectionAssignmentExcelUploadPage');
				Route::get('/student/section/assign/excel/download','School\ExcelExportController@sectionAssignmentExcelDownload');
				Route::post('/student/section/assign/excel/preview','School\ExcelImportController@sectionAssignmentExcelPreview');
				Route::post('/student/section/assign/excel/save','School\AssignmentController@sectionAssignmentExcelSave');
				Route::get('/assign-page/api/SELECT_ALL_SECTION','School\AssignmentController@getAllSections');

				Route::get('/subjects/assignment','School\AssignmentController@subjectAssignmentListPage');
				Route::get('/student/subjects/assign/entry/{ccs_code}','School\AssignmentController@subjectsAssignmentEntryPage');
				Route::post('/student/subjects/assign/entry/ajax','School\AssignmentController@subjectsAssignmentEntryPageAjax');
				Route::post('/student/subjects/assign/entry/save','School\AssignmentController@subjectsAssignmentEntryPageSave');
			// Upload
				
				Route::get('/student/subject/assign/excel/upload','School\AssignmentController@subjectAssignmentExcelUploadPage');
				Route::get('/student/subject/assign/api/SELECT_ALL_COURSE_CODE_OPTIONAL','School\AssignmentController@selectallcoursecodeoptional');
				Route::get('/student/subject/assign/api/SELECT_NO_OF_OPTIONAL_BY_COURSE_CLASS','School\subjectassignController@selectnoofoptionalbycourseclass');
				Route::get('/student/subject/assign/excel/download','School\ExcelExportController@subjectAssignmentExcelDownload');
				Route::post('/student/subject/assign/excel/preview','School\ExcelImportController@subjectAssignmentExcelPreview');
				Route::post('/student/subject/assign/excel/save','School\AssignmentController@subjectAssignmentExcelSave');
				


				Route::get('/assign-page/api/SELECT_ALL_SUBJECT','School\AssignmentController@selectAllSubjects');


				Route::get('/assign-page/api/SELECT_ALL_STUDENT_ADMNO','School\AssignmentController@selectallstudentadmno');
				Route::get('/assign-page/api/SELECT_BY_FILTER','School\AssignmentController@selectbyfilter');
				Route::get('/assign-page/api/SELECT_ALL_COMPULSORY_SUBJECTS','School\AssignmentController@selectallcompulsorysubjects');
				Route::get('/assign-page/api/SELECT_ALL_OPTIONAL_SUBJECTS','School\AssignmentController@selectAllOptionalSubjects');
				Route::post('/subject-assign/optional/student-wise/save','School\AssignmentController@saveOptionalSubjectsStudentWise');





				Route::get('/teacher/assignment','School\AssignmentController@teacherAssignmentListPage');
				Route::get('/teacher/assignment/page/{ccs_code}','School\AssignmentController@getStudentAssignSubjectPage');
				Route::post('/teacher/assignment/page/save','School\AssignmentController@saveStudentAssignSubject');
				
			// User Setup
				Route::get('/users/roles/','School\SetupController@userSetupPage');
				Route::get('/user-setup/api/SELECTEMP','School\SetupController@userSetupPageSelectEmployee');
				Route::get('/user-setup/api/SELECTSTUDENT','School\SetupController@userSetupPageSelectStudent');
				Route::post('/user-setup/api/RESETPASSWORD','School\SetupController@userSetupPageResetPassword');
				Route::post('/user-setup/api/CHANGESTATUS','School\SetupController@userSetupPageChangeStatus');
				Route::get('/user-setup/api/SELECT_ROLE','School\SetupController@userSetupPageSelectRole');
				Route::post('/user-setup/api/CHANGEROLECODE','School\SetupController@userSetupPageChangeRoleCode');

			// Mappings
				Route::get('/mappings','School\MappingController@mappingsPage');
				Route::post('/mappings/api/DELETESUBJECT','School\MappingController@deletesubject');
				Route::post('/mappings/api/DELETESECTIONS','School\MappingController@deletesections');
				Route::post('/mappings/api/DELETEOPTIONAL','School\MappingController@deleteoptional');
				Route::get('/mappings/api/K12_SUBJECT_TYPE','School\MappingController@k12subjecttype');
				Route::post('/mappings/api/SAVESUBJECT','School\MappingController@savesubject');
				Route::post('/mappings/api/UPDATESUBJECT','School\MappingController@updatesubject');
				Route::post('/mappings/api/SAVESECTION','School\MappingController@savesection');
				Route::post('/mappings/api/UPDATESECTION','School\MappingController@updatesection');
				Route::post('/mappings/api/SAVEOPTIONAL','School\MappingController@saveoptional');
			
			//topics
				Route::get('/mappings/{ccs_code}','School\MappingController@topicpage');
				Route::get('/mappings/api/SELECTTOPICS','School\MappingController@selecttopics');
				Route::post('/mappings/api/INSERT_SUBJECT_TOPIC','School\MappingController@insertsubjecttopic');
				Route::post('/mappings/api/DELETE_SUBJECT_TOPIC','School\MappingController@delete_subject_topic');


			// Students
				Route::get('/students','School\StudentsController@getStudentsPage');
				Route::get('/students/api/SELECT_CATEGORY_1_AJAX','School\StudentsController@selectAllCategoryOne');
				Route::get('/students/api/SELECT_CATEGORY_2_AJAX','School\StudentsController@selectAllCategoryTwo');
				Route::get('/students/api/ADMISSION_TYPE_AJAX','School\StudentsController@selectAdmissionType');
				Route::get('/master-page/api/SELECT_CERTIFICATE_TYPE','School\StudentsController@selectCertificateType');
				Route::get('/students/api/SELECT_HOUSE_AJAX','School\StudentsController@selectHouse');
				Route::get('/students/api/SELECT_ALL_STUDENTS','School\StudentsController@selectAllStudents');
				Route::get('/students/api/SELECT_SERVICE_CATEGORY','School\StudentsController@selectServiceCategory');
				Route::post('/students/api/ADD_STUDENT','School\StudentsController@addStudent');
				Route::post('/students/api/Delete_STUDENT','School\StudentsController@Delete_STUDENT');

				Route::get('/students/api/GET_ASSIGNED_SECTION_DETAILS','School\StudentsController@GET_ASSIGNED_SECTION_DETAILS');
				Route::get('/students/api/SELECT_STATE','School\StudentsController@SELECT_STATE');
				Route::get('/students/api/CITY_BY_STATE','School\StudentsController@CITY_BY_STATE');
				Route::post('/students/api/ADD_CONTACT','School\StudentsController@ADD_CONTACT');
				Route::post('/students/api/UPLOAD_DOCUMENT','School\StudentsController@UPLOAD_DOCUMENT');
				Route::get('/students/api/ACHIEVEMENT_CATEGORY','School\StudentsController@ACHIEVEMENT_CATEGORY');
				Route::get('/students/api/ACHIEVEMENT_SUB_CATEGORY','School\StudentsController@ACHIEVEMENT_SUB_CATEGORY');
				Route::get('/students/api/SAVE_PREVIOUS_SCHOOL_DETAILS','School\StudentsController@SAVE_PREVIOUS_SCHOOL_DETAILS');
				
				Route::get('/students/api/CHKDUPLICATE','School\StudentsController@CHKDUPLICATE');
				Route::get('/students/api/SEARCHSTUDENT','School\StudentsController@SEARCHSTUDENT');
				
				Route::get('/students/STU_CERTIFICATE','School\StudentsController@stu_certificatePage');
				Route::get('/students/TC_NUMBER_AUTO_REQUIRED','School\StudentsController@tc_number_auto_required');
				Route::get('/students/SELECT_SPECIFIC_TEMPLATE','School\StudentsController@select_specific_template');
				Route::post('/students/SAVE_SPECIFIC_TEMPLATE','School\StudentsController@save_specific_template');
				Route::get('/students/STU_CERTIFICATE_PDF','School\StudentsController@stu_certificatePdfPage');
				
				//FEE
				Route::get('/fee/due/creation/list','School\Fee\dueController@dueCreationListPage');
				Route::get('/fee/due/creation/selectAll','School\Fee\dueController@SelectAll');
				
				Route::get('/fee/due/creation/debitCreate','School\Fee\dueController@debitCreate');
				Route::get('/fee/due/creation/debitmodify','School\Fee\dueController@debitmodify');
				Route::get('/fee/due/creation/getDate','School\Fee\dueController@getDate');
				
				Route::get('/fee/due/creation/getStudentInfo','School\Fee\dueController@getStudentInfo');
				Route::get('/fee/due/creation/getDebitCreateData','School\Fee\dueController@getDebitCreateData');
				
				Route::get('/fee/due/creation/getDebitModifyData','School\Fee\dueController@getDebitModifyData');
				Route::post('/fee/due/creation/submitModifyDue','School\Fee\dueController@submitModifyDue');
				
								
				
				
				
				
				Route::get('school/students/api/GET_PROFILE_INFO','School\StudentsController@GET_PROFILE_INFO');
				
				
				// Test PDF
				Route::get('/testpdf','School\PDFController@test');
				
				//
				Route::get('/students/info/download/in/excel','School\ExcelExportController@studentTemplateWithDetailsExcelDownload');

			// Notifications
				Route::get('/send/sms','School\NotificationController@sendSMSPage');
				Route::get('/sms/api/SELECT_ALL_MESSAGE','School\NotificationController@selectAllMessage');
				Route::get('/sms/api/SELECT_ALL_MESSAGE_EMP','School\NotificationController@selectAllMessageEmp');

				Route::get('/sms/api/SELECT_ALL_DEPT','School\NotificationController@selectAllDept');
				Route::get('/sms/api/SELECT_ALL_EMPLOYEE_BY_DEPARTMENT','School\NotificationController@selectAllEmployeeByDepartment');
				Route::get('/sms/api/SELECT_ALL_COURSE','School\NotificationController@selectAllCourse');
				Route::get('/sms/api/SELECT_ALL_CLASS_BY_COURSE','School\NotificationController@selectAllClassByCourse');
				Route::get('/sms/api/SELECT_ALL_SECTION_BY_COURSE_CLASS','School\NotificationController@selectAllSectionByCourseClass');
				Route::get('/sms/api/SELECT_ALL_STUDENTS','School\NotificationController@selectAllStudent');
				Route::post('/sms/api/SEND_MESSAGE','School\NotificationController@sendMessage');
				Route::get('/sms/api/GET_SHARED_LIST','School\NotificationController@getSharedList');
				Route::post('/sms/api/DELETE_UPLOADED_SMS_NOTIFICATION','School\NotificationController@deleteUploadedSmsNotification');
				Route::post('/sms/api/SEND_MESSAGE_EMP','School\NotificationController@sendMessageEmp');
				Route::get('/sms/api/GET_SHARED_LIST_EMP','School\NotificationController@getSharedListEmp');

				Route::get('/send/documents','School\NotificationController@sendDocumentsPage');
				
				Route::get('/send/notifications','School\NotificationController@sendNotificationPage');

				Route::get('/notifications/api/SELECT_ALL_STUDENTS','School\NotificationController@selectAllStudents');
				Route::get('/master-page/api/SELECT_ALL_DEPARTMENT','School\NotificationController@getDepartment');
				Route::get('/notifications/api/SELECT_ALL_EMPLOYEE_BY_DEPARTMENT','School\NotificationController@getAllEmp');
				
				Route::post('/notifications/api/SEND_NOTIFICATIONS','School\NotificationController@sendNotifications');
				Route::post('/notifications/api/SEND_NOTIFICATIONS_EMP','School\NotificationController@sendNotificationsEmp');
				Route::post('/notifications/api/SELECT_ALL_MESSAGE','School\NotificationController@selectmessage');
				Route::post('/notifications/api/DELETE_UPLOADED_SMS_NOTIFICATION','School\NotificationController@deletenotification');
				
				Route::post('/notifications/api/SEND_DOCUMENTS','School\NotificationController@sendDocuments');
				Route::post('/notifications/api/SEND_DOCUMENTS_EMP','School\NotificationController@sendDocumentsEmp');
				Route::get('/notifications/api/SELECT_ALL_DOCUMENTS','School\NotificationController@selectAllDocuments');
				Route::get('/notifications/api/SELECT_ALL_DOCUMENTS_EMP','School\NotificationController@selectAllDocuments');
					
			// Exam
				Route::get('/exam/setup','School\ExamSetupController@examSetupPage');

				Route::get('/exam/api/SELECT_ALL_TYPES','School\ExamSetupController@selectAllTypes');
				Route::post('/exam/api/SAVEEXAMTYPE','School\ExamSetupController@saveExamType');
				Route::post('/exam/api/DELETEEXAMTYPE','School\ExamSetupController@DeleteExamType');

				Route::get('/exam/api/SELECT_ALL_EXAMS','School\ExamSetupController@selectAllExams');
				Route::post('/exam/api/SAVEEXAMSSS','School\ExamSetupController@saveExamss');
				Route::post('/exam/api/DELETEEXAM','School\ExamSetupController@DeleteExam');

				Route::get('/master-page/api/SELECT_ALL_EXAM_TYPE_AJAX','School\ExamSetupController@selectAllExamTypeAjax');
				Route::get('/master-page/api/SELECT_ALL_SUBJECTS_BY_COURSE_CLASS_AJAX','School\ExamSetupController@SelectAllSubjectsbyCourseClassAjax');

				Route::get('/exam/api/SELECT_ALL_SUBJECTS','School\ExamSetupController@selectAllExamSubjects');
				Route::get('/exam/api/STORE_SUBJECTS','School\ExamSetupController@StoreSubjects');
				Route::post('/exam/api/DELETE_EXAM_SUBJECT','School\ExamSetupController@DeleteExamSubject');

				Route::get('/exam/mappings','School\ExamMappingController@examMappingPage');
				Route::get('/exam/api/SELECT_EXAM_COURSE_CLASS_WISE_AJAX','School\ExamMappingController@selectExamCcWise');
				Route::get('/exam/api/SELECT_ALL_EXAM_MAPPING','School\ExamMappingController@selectAllExamMapping');
				Route::get('/exam/api/SELECT_ALL_EXAMS_BY_COURSE_CLASS','School\ExamMappingController@selectAllExamByCourseClass');
				Route::post('/exam/api/STORE_MAPPINGS','School\ExamMappingController@StoreMapping');
				Route::post('/exam/api/EDIT_MAPPINGS','School\ExamMappingController@EditMapping');
				Route::post('/exam/api/DELETE_MAPPINGS','School\ExamMappingController@DeleteMapping');

			// Mark Entry
				Route::get('/exam/mark/entry','School\ExamMarkEntryController@markEntryPage');
				Route::get('/exam/api/SELECT_ALL_EXAM_MARKENTRY','School\ExamMarkEntryController@SelectAllExamMarkentry');
				Route::get('/exam/mark/entry/screen/{ccs_code}','School\ExamMarkEntryController@markEntryScreenPage');
				Route::get('/exam/mark/entry/screen/by/excel/multiple/subjects/{ccs_code}','School\ExamMarkEntryController@markEntryScreenMultipleSubjectsExcelPage');
					
			// Reportcard
				Route::get('/report/cards','School\ReportcardController@reportcardPage');
				Route::get('/reportcard/api/SELECT_ALL_SIGNATURE','School\ReportcardController@selectAllSignatures');
				Route::post('/reportcard/api/saveSignature','School\ReportcardController@saveSignature');
				Route::post('/reportcard/api/deleteSignature','School\ReportcardController@deleteSignature');

				Route::get('/reportcard/api/SELECT_ALL_PTMS','School\ReportcardController@selectAllPTM');
				Route::post('/reportcard/api/savePTM','School\ReportcardController@savePTM');
				Route::post('/reportcard/api/deletePTM','School\ReportcardController@deletePTM');

				Route::get('/reportcard/api/SELECT_ALL_REPORTCARD','School\ReportcardController@selectAllReportcards');

				Route::get('/reportcard/api/SELECT_REPORTCARD_CODE','School\ReportcardController@SELECT_REPORTCARD_CODE');
				Route::post('/reportcard/api/INSERT_REPORTCARD','School\ReportcardController@INSERT_REPORTCARD');
				Route::post('/reportcard/api/EDIT_REPORTCARD','School\ReportcardController@EDIT_REPORTCARD');
				Route::post('/reportcard/api/DELETE_REPORTCARD','School\ReportcardController@DELETE_REPORTCARD');
				Route::post('/reportcard/api/FREEZE_REPORTCARD','School\ReportcardController@FREEZE_REPORTCARD');
				Route::post('/reportcard/api/PUBLISH_REPORTCARD','School\ReportcardController@PUBLISH_REPORTCARD');

				Route::post('/reportcard/api/SELECT_ALL_SIGNATURES','School\ReportcardController@SELECT_ALL_SIGNATURES');
				Route::post('/reportcard/api/SAVE_SIGNATURES','School\ReportcardController@SAVE_SIGNATURES');
				Route::post('/reportcard/api/GENERATE_CARDS_EXAM_MAPPING','School\ReportcardController@GENERATE_CARDS_EXAM_MAPPING');

				Route::post('/reportcard/api/SAVE_EXAM_MAPPING','School\ReportcardController@SAVE_EXAM_MAPPING');

				Route::post('/reportcard/api/SELECT_TERM_DETAILS','School\ReportcardController@SELECT_TERM_DETAILS');
				Route::post('/reportcard/api/SAVE_TERM_DETAILS','School\ReportcardController@SAVE_TERM_DETAILS');

				Route::post('/reportcard/api/reportcard_setup_ptm_ajax','School\ReportcardController@reportcard_setup_ptm_ajax');
				Route::post('/reportcard/api/SAVE_PTM_DETAILS','School\ReportcardController@SAVE_PTM_DETAILS');

				Route::get('/reportcard/api/SHOW_TEMPLATE','School\ReportcardController@SHOW_TEMPLATE');
				Route::get('/reportcard/api/SELECT_ALL_STUDENTS_FOR_REPORTCARD_TEMPLATE','School\ReportcardController@SELECT_STUDENTS_FOR_REPORTCARD_TEMPLATE');
				Route::get('/reportcard/api/RC1920','School\ReportcardController@SELECT_ALL_STUDENTS_FOR_REPORTCARD_TEMPLATE');
				Route::post('/reportcard/api/GET_SECTION_CODE_BY_ADMISSION_NO','School\ReportcardController@GET_SECTION_CODE_BY_ADMISSION_NO');
				// kkk
			
			// Health & Hygeniue
				Route::get('/report/cards/health/hygiene/entry','School\HealthHygieneMarkentryController@healthhygienemarkentry');
				Route::get('/reportcard/get/GET_ALL_STUDENT','School\HealthHygieneMarkentryController@getStudentData');
				Route::get('/reportcard/get/GET_FREEZE_DATA','School\HealthHygieneMarkentryController@getFreezeData');
				Route::get('/reportcard/get/GET_HEALTH_DETAILS','School\HealthHygieneMarkentryController@heathDetails');
				Route::post('/reportcard/get/DATA_SAVE','School\HealthHygieneMarkentryController@saveData');
				Route::get('/reportcard/api/SELECT_ALL_REPORTCARD_BY_COURSE_CLASS','School\HealthHygieneMarkentryController@selectAllReportcardByCourseClass');
					
					
					
				Route::get('/reportcard/health_hygienen/download','School\HealthHygieneExcelController@healthhygieneexceldownload');
				Route::get('/reportcard/health_hygienen/download/GET_ALL_STUDENT/{download_excel}','School\HealthHygieneExcelController@getStudentData');
				Route::get('/reportcard/health_hygienen/download/api/SELECT_ALL_REPORTCARD_BY_COURSE_CLASS','School\HealthHygieneExcelController@selectAllReportcardByCourseClass');
				
				
				// kkk
				Route::get('/reportcard/health_hygienen/download/GET_ALL_STUDENT/download/excel','School\HealthHygieneUploadController@healthHygieneExcelDownload');

				Route::get('/reportcard/health_hygienen/upload','School\HealthHygieneUploadController@healthhygieneexcelupload');

				Route::post('/reportcard/health_hygienen/upload/EXCEL_PREVIEW','School\HealthHygieneUploadController@excel_preview');

				Route::get('/reportcard/health_hygienen/upload/DOWNLOAD_EXCEL','School\HealthHygieneUploadController@download_excel');
				Route::post('/reportcard/health_hygienen/upload/SAVE_MARKS','School\HealthHygieneUploadController@save_data');
				Route::post('/reportcard/health_hygienen/upload/GET_FREEZE_STATUS','School\HealthHygieneUploadController@get_freeze_status');
				// kkk
				
				

			// Reports
				Route::get('/reports/monthly/attendance','School\MonthlyAttendanceController@monthlyAttendanceReportsPage');
				Route::get('/reports/monthly/attendance/GET_DATA','School\MonthlyAttendanceController@monthlyAttendanceReportsGetData');
					
				Route::get('/reports/attendance/tracker/tree','School\MonthlyAttendanceController@attendanceTrackerTreePage');
				

				Route::get('/studentstrengthreport','School\MonthlyAttendanceController@studentStrengthReport');
				Route::get('/studentstrengthreport/GET_STUDENT_DATA/{report_type}/{download_excel}','School\MonthlyAttendanceController@studentStrengthReportData');


			// Student Profile
				Route::get('/student/view/notifications','School\NotificationController@studentNotificationPage');
				Route::get('/student/attendance/reports','School\StudentAttendanceController@attendance');
				Route::get('/student/marks/reports','School\StudentAttendanceController@markPage');
				
				Route::get('/student/leave/apply','School\StudentAttendanceController@leavePage');
				Route::get('/student/leave/apply/SELECT_DATA','School\StudentAttendanceController@getLeaveData');
				Route::post('/student/leave/apply/insert','School\StudentAttendanceController@insertLeaveData');
				
				Route::get('/student/get/reports/cards','School\StudentAttendanceController@getReportCards');


			// Techer Profile
				Route::get('/teachers/teacher_attendance','School\teachers\TeacherAttendanceController@attendancePage');
				Route::get('/teachers/attendance/api/SELECT_ALL_ATTN_SUBJECTS','School\teachers\TeacherAttendanceController@selectAllAttnSubjects');
				Route::get('/teachers/attendance/entry/{ccs_code}','School\teachers\TeacherAttendanceController@attendanceEntryPage');
				Route::get('/teachers/attendance/api/GET_ATTN_DATES','School\teachers\TeacherAttendanceController@getattndates');
				Route::get('/teachers/attendance/api/DELETE_ATTN_DATES','School\teachers\TeacherAttendanceController@deleteattndates');
				Route::get('/teachers/attendance/{ccs_code}/{subject_code}/{attendance_id}','School\teachers\TeacherAttendanceController@attendanceedit');
				Route::get('/teachers/attendance/api/SAVE_ATTENDACE','School\teachers\TeacherAttendanceController@saveattendace');

			//common page of teachers
				Route::get('/teachers/attendance/api/SELECT_ALL_COURSE_AJAX','School\teachers\TeacherAttendanceController@selectAllCourseAjax');
				Route::get('/teachers/attendance/api/SELECT_ALL_CLASS_BY_COURSE_AJAX','School\teachers\TeacherAttendanceController@selectAllClassByCourseAjax');
				Route::get('/teachers/attendance/api/SELECT_ALL_SECTION_BY_COURSE_CLASS_AJAX','School\teachers\TeacherAttendanceController@selectAllSectionByCourseClassAjax');

				//mark entry
				Route::get('/teachers/mark_entry','School\teachers\MarkEntryController@markentry');
				Route::get('/teachers/mark/entry/{ccse_code}','School\teachers\MarkEntryController@markEntryPage');
				Route::get('/teachers/mark-entry/api/SELECT_ALL_MARK_ENTRY','School\teachers\MarkEntryController@selectallmarkentry');
				Route::post('/teachers/mark-entry/api/SELECT_ALL_STUDENT','School\teachers\MarkEntryController@selectallstudent');
				Route::post('/teachers/mark-entry/api/SAVE_STUDENT','School\teachers\MarkEntryController@savestudent');
		

		    });

		}
	
	
	// Not use
	$x = "x";
	if($x == "x")
	{	
	    /**
	    * SUPER ADMIN PAGES SUPER ADMIN CONTROLLER ROUTES STARTS
	    */
			Route::get('/superadmin/managemodule/{role_code}','super\SUController@managemodulePage');
			Route::get('/superadmin/manageinstitutegroup/{role_code}','super\SUController@manageinstitutegroup');
			Route::get('/superadmin/manageinstitute/{role_code}','super\SUController@manageinstitute');
			Route::get('/superadmin/manageresource/{role_code}','super\SUController@manageresource');
			Route::get('/superadmin/managerole/{role_code}','super\SUController@managerole');
			Route::get('/superadmin/custom_fields/{role_code}','super\SUController@customfields');
			Route::get('/superadmin/user_functionality_access/{role_code}','super\SUController@user_functionality_access');
			Route::get('/superadmin/activity_access_schedule/{role_code}','super\SUController@activity_access_schedule');
			Route::get('/superadmin/mastersetup_mapping/{role_code}','super\SUController@mastersetup_mapping');
			Route::get('/superadmin/money_receipt_template/{role_code}','super\SUController@money_receipt_template');
			Route::get('/superadmin/codedescription/{role_code}','super\SUController@codedescription');
	        Route::get('/superadmin/pg_master/{role_code}','super\SUController@pg_master');
	        Route::get('/admin/usercertificatetemplate/{role_code}','super\SUController@usercertificatetemplate');
	    /**
	    * SUPER ADMIN PAGES Super Admin CONTROLLER ROUTES END
	    */

	    /**
	    * ADMIN PAGES Super Admin CONTROLLER ROUTES Starts
	    */
	        Route::get('/admin/institute_setup/{role_code}','admin\AdminController@institute_setup');
	        Route::get('/admin/attendance_devicesetup/{role_code}','admin\AdminController@attendance_devicesetup');
	        Route::get('/admin/manageuser/{role_code}','admin\AdminController@manageuser');
	        Route::get('/admin/email_setup/{role_code}','admin\AdminController@email_setup');
	        Route::get('/admin/sms_setup/{role_code}','admin\AdminController@sms_setup');
	    /**
	    * ADMIN PAGES Super Admin CONTROLLER ROUTES END
	    */

	   /**
	    * ADMIN PAGES Payroll CONTROLLER ROUTES Starts
	    */
	        Route::get('/payroll/component_master_set/{role_code}','PayrollAdminController@component_master_set');
	        Route::get('/payroll/payroll_salary_setup/{role_code}','PayrollAdminController@payroll_salary_setup');
	        Route::get('/payroll/payroll_calculation/{role_code}','PayrollAdminController@payroll_calculation');
	        Route::get('/payroll/payroll_itsetup/{role_code}', 'PayrollAdminController@payroll_itsetup');
	        Route::get('/payroll/statutory_setup_ui/{role_code}', 'PayrollAdminController@statutory_setup_ui');
			Route::get('/payroll/payroll_emp_view/{role_code}', 'PayrollAdminController@payroll_emp_view');
			Route::get('/payroll/signature_setup_ui/{role_code}', 'PayrollAdminController@signature_setup_ui');
			Route::get('/payroll/report_setup/{role_code}', 'PayrollAdminController@report_setup');
	        Route::get('/payroll/payroll_report/{role_code}','PayrollAdminController@payroll_report');
			Route::get('/payroll/payroll_salary_slip_report/{role_code}','PayrollAdminController@payroll_salary_slip_report');
			Route::get('/payroll/payroll_salary_sheet_report/{role_code}','PayrollAdminController@payroll_salary_sheet_report');;
			Route::get('/payroll/payroll_payment_advice_report/{role_code}','PayrollAdminController@payroll_payment_advice_report');
			Route::get('/payroll/payroll_epfo_jk_report/{role_code}','PayrollAdminController@payroll_epfo_jk_report');
			Route::get('/payroll/payroll_epfo_report/{role_code}','PayrollAdminController@payroll_epfo_report');
			Route::get('/payroll/payroll_esic_report/{role_code}','PayrollAdminController@payroll_esic_report');
			Route::get('/payroll/payroll_professional_tax_report/{role_code}','PayrollAdminController@payroll_professional_tax_report');
			Route::get('/payroll/payroll_tds_report/{role_code}','PayrollAdminController@payroll_tds_report');
			Route::get('/payroll/payroll_monthly_tds_report/{role_code}','PayrollAdminController@payroll_monthly_tds_report');
			Route::get('/payroll/payroll_advance_loan_report/{role_code}','PayrollAdminController@payroll_advance_loan_report');
			Route::get('/payroll/payroll_security_report/{role_code}','PayrollAdminController@payroll_security_report');
			Route::get('/payroll/payroll_epf_loan_report/{role_code}','PayrollAdminController@payroll_epf_loan_report');
			Route::get('/payroll/payroll_annual_report/{role_code}','PayrollAdminController@payroll_annual_report');
			Route::get('/payroll/payroll_form16_report/{role_code}','PayrollAdminController@payroll_form16_report');
	        Route::get('/payroll/actual_approval_ui/{role_code}', 'PayrollAdminController@actual_approval');
	        Route::get('/payroll/payroll_itdeclarations/{role_code}', 'PayrollAdminController@payroll_itdeclarations');
	        Route::get('/payroll/payroll_tds_calculation/{role_code}', 'PayrollAdminController@payroll_tds_calculation');

	    /* ADMIN PAGES Payroll CONTROLLER ROUTES END*/
	/**
	    * ADMIN PAGES BUDGET CONTROLLER ROUTES Starts
	    */

	    Route::get('/budget/budget_setup_assign/{role_code}','budget\BudgetAdminController@budget_setup_assign');
	    Route::get('/budget/budget_vs_actual_amout/{role_code}','budget\BudgetAdminController@budget_vs_actual_amout');
	    Route::get('/budget/budget_vs_actual_graph/{role_code}','budget\BudgetAdminController@budget_vs_actual_graph');
	    Route::get('/budget/budget_planning/{role_code}','budget\BudgetAdminController@budget_planning');
	    /**
	    * ADMIN PAGES BUDGET CONTROLLER ROUTES END
	*/
	/**
	    * TRANSPORT CONTROLLER ROUTES Starts
	    */
	    Route::get('/transport/transport_general_setup/{role_code}','transport\TransportAdminController@transport_general_setup');
		//Setup/Master-2/
	    Route::get('/transport/transport_vehicle_setup/{role_code}','transport\TransportAdminController@transport_vehicle_setup');

	    /**
	    * TRANSPORT CONTROLLER ROUTES END
	    */

	    /**
	    * SUPER ADMIN PAGES ROUTES START
	    */

			/*Manage Module Requests Start*/
			Route::get('/superadmin/managemodule/GetDefineModuleData/{role_code}','super\ManageModuleController@GetDefineModuleData');
			Route::post('/superadmin/managemodule/InsertDefineModuleData/{role_code}','super\ManageModuleController@InsertDefineModuleData');
			Route::post('/superadmin/managemodule/UpdateDefineModuleData/{role_code}','super\ManageModuleController@UpdateDefineModuleData');
			Route::get('/superadmin/managemodule/DeleteDefineModuleData/{role_code}','super\ManageModuleController@DeleteDefineModuleData');
			Route::get('/superadmin/managemodule/GetDefineSubModuleData/{role_code}','super\ManageModuleController@GetDefineSubModuleData');
			Route::post('/superadmin/managemodule/InsertDefineSubModuleData/{role_code}','super\ManageModuleController@InsertDefineSubModuleData');
			Route::post('/superadmin/managemodule/UpdateDefineSubModuleData/{role_code}','super\ManageModuleController@UpdateDefineSubModuleData');
			Route::get('/superadmin/managemodule/DeleteDefineSubModuleData/{role_code}','super\ManageModuleController@DeleteDefineSubModuleData');
			/*Manage Module Requests End*/

			/*Manage Resource Requests Start*/
			Route::get('/superadmin/manageresource/GetDefineResourceData/{role_code}','super\ManageResourceController@GetDefineResourceData');
			Route::get('/superadmin/manageresource/GetFolderData/{role_code}','super\ManageResourceController@GetFolderData');
			Route::post('/superadmin/manageresource/InsertDefineResourceData/{role_code}','super\ManageResourceController@InsertDefineResourceData');
			Route::post('/superadmin/manageresource/UpdateDefineResourceData/{role_code}','super\ManageResourceController@UpdateDefineResourceData');
			Route::get('/superadmin/manageresource/DeleteDefineResourceData/{role_code}','super\ManageResourceController@DeleteDefineResourceData');
			Route::get('/superadmin/manageresource/GetDefineResourceGroupData/{role_code}','super\ManageResourceController@GetDefineResourceGroupData');
			Route::post('/superadmin/manageresource/InsertDefineResourceGroupData/{role_code}','super\ManageResourceController@InsertDefineResourceGroupData');
			Route::post('/superadmin/manageresource/UpdateDefineResourceGroupData/{role_code}','super\ManageResourceController@UpdateDefineResourceGroupData');
			Route::get('/superadmin/manageresource/DeleteDefineResourceGroupData/{role_code}','super\ManageResourceController@DeleteDefineResourceGroupData');
			Route::get('/superadmin/manageresource/GetResourceToResourceGroupMappingData/{role_code}','super\ManageResourceController@GetResourceToResourceGroupMappingData');
			Route::post('/superadmin/manageresource/InsertResourceToResourceGroupData/{role_code}','super\ManageResourceController@InsertResourceToResourceGroupData');
			Route::post('/superadmin/manageresource/UpdateResourceToResourceGroupData/{role_code}','super\ManageResourceController@UpdateResourceToResourceGroupData');
			Route::get('/superadmin/manageresource/DeleteResourceToResourceGroupData/{role_code}','super\ManageResourceController@DeleteResourceToResourceGroupData');
			Route::post('/superadmin/manageresource/AddBulkResourceToResourceGroupData/{role_code}','super\ManageResourceController@AddBulkResourceToResourceGroupData');
			Route::get('/superadmin/manageresource/GetSubModuleToResourceGroupMappingData/{role_code}','super\ManageResourceController@GetSubModuleToResourceGroupMappingData');
			Route::get('/superadmin/manageresource/GetSubModuleData/{role_code}','super\ManageResourceController@GetSubModuleData');
			Route::post('/superadmin/manageresource/InsertSubModuleToResourceGroupData/{role_code}','super\ManageResourceController@InsertSubModuleToResourceGroupData');
			Route::post('/superadmin/manageresource/UpdateSubModuleToResourceGroupData/{role_code}','super\ManageResourceController@UpdateSubModuleToResourceGroupData');
			Route::get('/superadmin/manageresource/DeleteSubModuleToResourceGroupData/{role_code}','super\ManageResourceController@DeleteSubModuleToResourceGroupData');
			Route::post('/superadmin/manageresource/AddBulkSubModuleToResourceGroupData/{role_code}','super\ManageResourceController@AddBulkSubModuleToResourceGroupData');
	        /*Manage Resource Requests End*/

	        /*Master Setup Mapping Requests Start*/
	        Route::get('/superadmin/mastersetup_mapping/GetcmbModuleRoleData/{role_code}','super\MasterSetupMappingController@GetcmbModuleRoleData');
	        Route::get('/superadmin/mastersetup_mapping/GetSetupMappingRoleData/{role_code}','super\MasterSetupMappingController@GetSetupMappingRoleData');
	        Route::post('/superadmin/mastersetup_mapping/GetChkModuleRoleOperation/{role_code}','super\MasterSetupMappingController@GetChkModuleRoleOperation');
	        Route::get('/superadmin/mastersetup_mapping/GetSetupMappingUsergroupData/{role_code}','super\MasterSetupMappingController@GetSetupMappingUsergroupData');
	        Route::post('/superadmin/mastersetup_mapping/GetChkModuleUsergroupOperation/{role_code}','super\MasterSetupMappingController@GetChkModuleUsergroupOperation');
	        Route::get('/superadmin/mastersetup_mapping/GetSetupMappingConfigurationData/{role_code}','super\MasterSetupMappingController@GetSetupMappingConfigurationData');
	        Route::post('/superadmin/mastersetup_mapping/GetChkModuleConfigurationOperation/{role_code}','super\MasterSetupMappingController@GetChkModuleConfigurationOperation');
	        Route::get('/superadmin/mastersetup_mapping/GetcmbInstituteModuleData/{role_code}','super\MasterSetupMappingController@GetcmbInstituteModuleData');
	        Route::get('/superadmin/mastersetup_mapping/GetSetupMappingInstituteModuleData/{role_code}','super\MasterSetupMappingController@GetSetupMappingInstituteModuleData');
	        Route::post('/superadmin/mastersetup_mapping/GetChkInstituteModuleOperation/{role_code}','super\MasterSetupMappingController@GetChkInstituteModuleOperation');
	        Route::get('/superadmin/mastersetup_mapping/GetSetupMappingInstitutePrimaryRoleData/{role_code}','super\MasterSetupMappingController@GetSetupMappingInstitutePrimaryRoleData');
	        /*Master Setup Mapping Requests Start*/

	        /*Money Receipt Template Requests Start*/
	        Route::get('/superadmin/money_receipt_template/GetMoneyReceiptData/{role_code}','super\MoneyReceiptTemplateController@GetMoneyReceiptData');
	        Route::get('/superadmin/money_receipt_template/GetcmbTemplateTypeData/{role_code}','super\MoneyReceiptTemplateController@GetcmbTemplateTypeData');
	        Route::get('/superadmin/money_receipt_template/GetcmbEntityTypeData/{role_code}','super\MoneyReceiptTemplateController@GetcmbEntityTypeData');
	        Route::post('/superadmin/money_receipt_template/InsertTemplate/{role_code}','super\MoneyReceiptTemplateController@InsertTemplate');
	        Route::post('/superadmin/money_receipt_template/UpdateTemplate/{role_code}','super\MoneyReceiptTemplateController@UpdateTemplate');
	        Route::get('/superadmin/money_receipt_template/DeleteTemplate/{role_code}','super\MoneyReceiptTemplateController@DeleteTemplate');
	        /*Money Receipt Template Requests Start*/

			/*Code Description Requests Start*/
			Route::get('/superadmin/codedescription/GetDefineCategoryData/{role_code}','super\CodeDescriptionController@GetDefineCategoryData');
			Route::post('/superadmin/codedescription/InsertDefineCategoryData/{role_code}','super\CodeDescriptionController@InsertDefineCategoryData');
			Route::post('/superadmin/codedescription/UpdateDefineCategoryData/{role_code}','super\CodeDescriptionController@UpdateDefineCategoryData');
			Route::get('/superadmin/codedescription/DeleteDefineCategoryData/{role_code}','super\CodeDescriptionController@DeleteDefineCategoryData');
			Route::get('/superadmin/codedescription/GetDefineCodeDescriptionData/{role_code}','super\CodeDescriptionController@GetDefineCodeDescriptionData');
			Route::post('/superadmin/codedescription/InsertDefineCodeDescriptionData/{role_code}','super\CodeDescriptionController@InsertDefineCodeDescriptionData');
			Route::post('/superadmin/codedescription/UpdateDefineCodeDescriptionData/{role_code}','super\CodeDescriptionController@UpdateDefineCodeDescriptionData');
			Route::get('/superadmin/codedescription/DeleteDefineCodeDescriptionData/{role_code}','super\CodeDescriptionController@DeleteDefineCodeDescriptionData');
			/*Code Description Requests End*/
			/*Manage Institute_DEFINE Requests Start*/
	        Route::get('/superadmin/manageinstitute/GetDefine_data/{role_code}','super\ManageInstituteController@GetDefine_data');
	        Route::get('/superadmin/manageinstitute/InstDefineInsGrp/{role_code}','super\ManageInstituteController@InstDefineInsGrp');
	        Route::get('/superadmin/manageinstitute/InstDefineGrpLvl/{role_code}','super\ManageInstituteController@InstDefineGrpLvl');
	        Route::get('/superadmin/manageinstitute/InstDefineInsType/{role_code}','super\ManageInstituteController@InstDefineInsType');
	        Route::get('/superadmin/manageinstitute/GetInstSessionStatus/{role_code}','super\ManageInstituteController@GetInstSessionStatus');
	        Route::get('/superadmin/manageinstitute/GetDefineSession/{role_code}','super\ManageInstituteController@GetDefineSession');
	        Route::post('/superadmin/manageinstitute/InsertDefine/{role_code}','super\ManageInstituteController@InsertDefine');
	        Route::post('/superadmin/manageinstitute/UpdateDefine/{role_code}','super\ManageInstituteController@UpdateDefine');
	        Route::get('/superadmin/manageinstitute/DeleteDefine/{role_code}','super\ManageInstituteController@DeleteDefine');
			/*Manage Institute_INSTITUTE MODULE MAPPING Requests Start*/
	        Route::get('/superadmin/manageinstitute/GetcmbInstituteModuleData/{role_code}','super\ManageInstituteController@GetcmbInstituteModuleData');
	        Route::get('/superadmin/manageinstitute/GetInstituteModuleMappingRoleData/{role_code}','super\ManageInstituteController@GetInstituteModuleMappingRoleData');
	        Route::post('/superadmin/manageinstitute/GetChkInstituteModuleMapping/{role_code}','super\ManageInstituteController@GetChkInstituteModuleMapping');
	        /*Manage Institute_ADMIN USER Requests Start*/
	        Route::get('/superadmin/manageinstitute/GetAdminUserDataTable/{role_code}','super\ManageInstituteController@GetAdminUserDataTable');
	        Route::post('/superadmin/manageinstitute/InsertAdminUser/{role_code}','super\ManageInstituteController@InsertAdminUser');
	        Route::post('/superadmin/manageinstitute/UpdateAdminUser/{role_code}','super\ManageInstituteController@UpdateAdminUser');

	        //Manage Institut Group
			Route::get('/superadmin/manageinstitutegroup/GetManageInstitutegroupData/{role_code}','super\ManageInstituteGroupController@GetManageInstitutegroupData');
			Route::get('/superadmin/manageinstitutegroup/GetGroup/{role_code}','super\ManageInstituteGroupController@GetGroup');
	        Route::get('/superadmin/manageinstitutegroup/PrimarySchool/{role_code}','super\ManageInstituteGroupController@PrimarySchool');
	        Route::post('/superadmin/manageinstitutegroup/InsertGroup/{role_code}','super\ManageInstituteGroupController@InsertGroup');
	        Route::post('/superadmin/manageinstitutegroup/UpdateGroup/{role_code}','super\ManageInstituteGroupController@UpdateGroup');
	        Route::get('/superadmin/manageinstitutegroup/DeleteGroup/{role_code}','super\ManageInstituteGroupController@DeleteGroup');
	        //superadmin/manageinstitutegroup/SliderImages
	        Route::get('/superadmin/manageinstitutegroup/GetManageSliderImageData/{role_code}','super\ManageInstituteGroupController@GetManageSliderImageData');
	        Route::get('/superadmin/manageinstitutegroup/Group/{role_code}','super\ManageInstituteGroupController@Group');
	        Route::post('/superadmin/manageinstitutegroup/InsertSlider/{role_code}','super\ManageInstituteGroupController@InsertSlider');
	        Route::post('/superadmin/manageinstitutegroup/UpdateSlider/{role_code}','super\ManageInstituteGroupController@UpdateSlider');
	        Route::get('/superadmin/manageinstitutegroup/DeleteSlider/{role_code}','super\ManageInstituteGroupController@DeleteSlider');
	        //superadmin/manageinstitutegroup/Directorate User
	        Route::get('/superadmin/manageinstitutegroup/GetManageDirectrate/{role_code}','super\ManageInstituteGroupController@GetManageDirectrate');
	        Route::post('/superadmin/manageinstitutegroup/InsertDirectorateUser/{role_code}','super\ManageInstituteGroupController@InsertDirectorateUser');
	        Route::post('/superadmin/manageinstitutegroup/UpdateDirectorateUser/{role_code}','super\ManageInstituteGroupController@UpdateDirectorateUser');
	        Route::get('/superadmin/manageinstitutegroup/DeleteDirectorateUser/{role_code}','super\ManageInstituteGroupController@DeleteDirectorateUser');
	        Route::get('/superadmin/manageinstitutegroup/ResetDirectorateUserPassword/{role_code}','super\ManageInstituteGroupController@ResetDirectorateUserPassword');
	        Route::get('/superadmin/manageinstitutegroup/GetStatus/{role_code}','super\ManageInstituteGroupController@GetStatus');

			/*Manage Institute Requests END*/
			/*Manage Role Requests Start*/
			Route::get('/superadmin/managerole/GetManageRoleDefineData/{role_code}','super\ManageRoleController@GetManageRoleDefineData');
			Route::get('/superadmin/managerole/GetManageRoleDefineDashboardData/{role_code}','super\ManageRoleController@GetManageRoleDefineDashboardData');
			Route::post('/superadmin/managerole/INSERTROLE/{role_code}','super\ManageRoleController@INSERTROLE');
			Route::post('/superadmin/managerole/UPDATEROLE/{role_code}','super\ManageRoleController@UPDATEROLE');
			Route::get('/superadmin/managerole/DELETEROLE/{role_code}','super\ManageRoleController@DELETEROLE');
			Route::get('/superadmin/managerole/GetManageRoleUserGroupData/{role_code}','super\ManageRoleController@GetManageRoleUserGroupData');
			Route::post('/superadmin/managerole/INSERTUSERGROUP/{role_code}','super\ManageRoleController@INSERTUSERGROUP');
			Route::post('/superadmin/managerole/UPDATEUSERGROUP/{role_code}','super\ManageRoleController@UPDATEUSERGROUP');
			Route::get('/superadmin/managerole/DELETEUSERGROUP/{role_code}','super\ManageRoleController@DELETEUSERGROUP');
			Route::get('/superadmin/managerole/GetManageRoleResourceGroupData/{role_code}','super\ManageRoleController@GetManageRoleResourceGroupData');
			Route::get('/superadmin/managerole/GetManageRoleResourceGroupUserGroupNameData/{role_code}','super\ManageRoleController@GetManageRoleResourceGroupUserGroupNameData');
			Route::get('/superadmin/managerole/GetManageRoleResourceGroupRoleNameData/{role_code}','super\ManageRoleController@GetManageRoleResourceGroupRoleNameData');
			Route::get('/superadmin/managerole/GetManageRoleResourceGroupResourceGroupNameData/{role_code}','super\ManageRoleController@GetManageRoleResourceGroupResourceGroupNameData');
			Route::get('/superadmin/managerole/GetManageRoleResourceGroupAccessTypeData/{role_code}','super\ManageRoleController@GetManageRoleResourceGroupAccessTypeData');
			Route::post('/superadmin/managerole/INSERTASSIGNUSERGROUPROLERESOURCE/{role_code}','super\ManageRoleController@INSERTASSIGNUSERGROUPROLERESOURCE');
			Route::post('/superadmin/managerole/UPDATEASSIGNUSERGROUPROLERESOURCE/{role_code}','super\ManageRoleController@UPDATEASSIGNUSERGROUPROLERESOURCE');
			Route::get('/superadmin/managerole/DELETEASSIGNUSERGROUPROLERESOURCE/{role_code}','super\ManageRoleController@DELETEASSIGNUSERGROUPROLERESOURCE');
			/*Manage Role Requests END*/
			/*Custom Fields Requests Start*/
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntityTypeData/{role_code}','super\CustomFieldController@GetCustomFieldsEntityTypeData');
			Route::post('/superadmin/custom_fields/INSERT_ENTITY_TYPE/{role_code}','super\CustomFieldController@INSERT_ENTITY_TYPE');
			Route::post('/superadmin/custom_fields/UPDATE_ENTITY_TYPE/{role_code}','super\CustomFieldController@UPDATE_ENTITY_TYPE');
			Route::get('/superadmin/custom_fields/DELETE_ENTITY_TYPE/{role_code}','super\CustomFieldController@DELETE_ENTITY_TYPE');
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntitySubTypeData/{role_code}','super\CustomFieldController@GetCustomFieldsEntitySubTypeData');
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntitySubTypeEntityTypeNameData/{role_code}','super\CustomFieldController@GetCustomFieldsEntitySubTypeEntityTypeNameData');
			Route::post('/superadmin/custom_fields/INSERT_ENTITY_SUBTYPE/{role_code}','super\CustomFieldController@INSERT_ENTITY_SUBTYPE');
			Route::post('/superadmin/custom_fields/UPDATE_ENTITY_SUBTYPE/{role_code}','super\CustomFieldController@UPDATE_ENTITY_SUBTYPE');
			Route::get('/superadmin/custom_fields/DELETE_ENTITY_SUBTYPE/{role_code}','super\CustomFieldController@DELETE_ENTITY_SUBTYPE');
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntityFieldsData/{role_code}','super\CustomFieldController@GetCustomFieldsEntityFieldsData');
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntityFieldsInstituteNameData/{role_code}','super\CustomFieldController@GetCustomFieldsEntityFieldsInstituteNameData');
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntityFieldsEntityTypeNameData/{role_code}','super\CustomFieldController@GetCustomFieldsEntityFieldsEntityTypeNameData');
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntityFieldsEntitySubTypeNameData/{role_code}','super\CustomFieldController@GetCustomFieldsEntityFieldsEntitySubTypeNameData');
			Route::get('/superadmin/custom_fields/GetCustomFieldsEntityFieldsFieldTypeData/{role_code}','super\CustomFieldController@GetCustomFieldsEntityFieldsFieldTypeData');
			Route::post('/superadmin/custom_fields/INSERT_ENTITY_FIELDS/{role_code}','super\CustomFieldController@INSERT_ENTITY_FIELDS');
			Route::post('/superadmin/custom_fields/UPDATE_ENTITY_FIELDS/{role_code}','super\CustomFieldController@UPDATE_ENTITY_FIELDS');
			Route::get('/superadmin/custom_fields/DELETE_ENTITY_FIELDS/{role_code}','super\CustomFieldController@DELETE_ENTITY_FIELDS');
			/*Custom Fields Requests END*/
			/*User Functinality Access Requests Start*/
			Route::get('/superadmin/user_functionality_access/GetDefineFunctionalityData/{role_code}','super\UserFunctionalityAccessController@GetDefineFunctionalityData');
			Route::post('/superadmin/user_functionality_access/INSERT_FUNCTIONALITY/{role_code}','super\UserFunctionalityAccessController@INSERT_FUNCTIONALITY');
			Route::post('/superadmin/user_functionality_access/UPDATE_FUNCTIONALITY/{role_code}','super\UserFunctionalityAccessController@UPDATE_FUNCTIONALITY');
			Route::get('/superadmin/user_functionality_access/DELETE_FUNCTIONALITY/{role_code}','super\UserFunctionalityAccessController@DELETE_FUNCTIONALITY');
			/*User Functinality Access Requests END*/
			/*Activity Access Schedule Requests Start*/
			Route::get('/superadmin/activity_access_schedule/GetDefineActivityData/{role_code}','super\ActivityAccessScheduleController@GetDefineActivityData');
			Route::post('/superadmin/activity_access_schedule/INSERT_ACTIVITY/{role_code}','super\ActivityAccessScheduleController@INSERT_ACTIVITY');
			Route::post('/superadmin/activity_access_schedule/UPDATE_ACTIVITY/{role_code}','super\ActivityAccessScheduleController@UPDATE_ACTIVITY');
			Route::get('/superadmin/activity_access_schedule/DELETE_ACTIVITY/{role_code}','super\ActivityAccessScheduleController@DELETE_ACTIVITY');
			/*Activity Access Schedule Requests END*/
			/*Workflow Setup Requests Start*/
	        Route::get('/workflow/workflow_setup/{role_code}','super\SUController@workflow_setup');
	        Route::get('/workflow/workflow_setup/GetWorkflowTypeData/{role_code}','super\WorkFlowSetupController@GetWorkflowTypeData');
	        Route::post('/workflow/workflow_setup/InsertWorkflow/{role_code}','super\WorkFlowSetupController@InsertWorkflow');
	        Route::post('/workflow/workflow_setup/editDataForWorkFlowType/{role_code}','super\WorkFlowSetupController@editDataForWorkFlowType');
	        Route::get('/workflow/workflow_setup/deleteDataForWorkFlowType/{role_code}','super\WorkFlowSetupController@deleteDataForWorkFlowType');
	        Route::get('/workflow/workflow_setup/GetcmbModuleRoleData/{role_code}','super\WorkFlowSetupController@GetcmbModuleRoleData');
	        /*Workflow Setup Requests END*/
	        /*Payment Gatway pg_master start*/
	        Route::get('/superadmin/pg_master/{role_code}','super\SUController@pg_master');
	        Route::get('/superadmin/pg_master/GetPg_MasterData/{role_code}','super\pg_masterController@GetPg_MasterData');
	        Route::post('/superadmin/pg_master/InsertPgMaster/{role_code}','super\pg_masterController@InsertPgMaster');
	        Route::post('/superadmin/pg_master/UpdatePgMaster/{role_code}','super\pg_masterController@UpdatePgMaster');
	        Route::get('/superadmin/pg_master/deletePg_Master/{role_code}','super\pg_masterController@deletePg_Master');
	        Route::get('/superadmin/pg_master/GetPg_ParameterData/{role_code}','super\pg_masterController@GetPg_ParameterData');
	        Route::get('/superadmin/pg_master/GetcmbPgCodeData/{role_code}','super\pg_masterController@GetcmbPgCodeData');
	        Route::get('/superadmin/pg_master/GetcmbtxtPgCodeData/{role_code}','super\pg_masterController@GetcmbtxtPgCodeData');
	        Route::post('/superadmin/pg_master/InsertPgParameter/{role_code}','super\pg_masterController@InsertPgParameter');
	        Route::post('/superadmin/pg_master/UpdatePgParameter/{role_code}','super\pg_masterController@UpdatePgParameter');
	        Route::get('/superadmin/pg_master/deletePg_Parameter/{role_code}','super\pg_masterController@deletePg_Parameter');
	        Route::get('/superadmin/pg_master/GetPg_InstMappingData/{role_code}','super\pg_masterController@GetPg_InstMappingData');
	        Route::get('/superadmin/pg_master/GetcmbFilterInstituteData/{role_code}','super\pg_masterController@GetcmbFilterInstituteData');
	        Route::get('/superadmin/pg_master/GetcmbFilterPaymentCodeData/{role_code}','super\pg_masterController@GetcmbFilterPaymentCodeData');
	        Route::get('/superadmin/pg_master/GetDebitAccountList/{role_code}','super\pg_masterController@GetDebitAccountList');
	        Route::post('/superadmin/pg_master/GetDebitAccount/{role_code}','super\pg_masterController@GetDebitAccount');
	        Route::get('/superadmin/pg_master/GetInstituteMappingParameter/{role_code}','super\pg_masterController@GetInstituteMappingParameter');
	        Route::post('/superadmin/pg_master/SaveInstMapParameter/{role_code}','super\pg_masterController@SaveInstMapParameter');

	        /*Payment Gatway pg_master end*/

	        /*Admin User Certificate Template start*/
	        Route::get('/admin/usercertificatetemplate/GetCertificateTemplateData/{role_code}','super\UserCertificateTemplateController@GetCertificateTemplateData');
	        Route::get('/admin/usercertificatetemplate/GetcmbTemplateTypeData/{role_code}','super\UserCertificateTemplateController@GetcmbTemplateTypeData');
	        Route::get('/admin/usercertificatetemplate/GetcmbEntityTypeData/{role_code}','super\MoneyReceiptTemplateController@GetcmbEntityTypeData');
	        Route::post('/admin/usercertificatetemplate/InsertTemplate/{role_code}','super\UserCertificateTemplateController@InsertTemplate');
	        Route::post('/admin/usercertificatetemplate/UpdateTemplate/{role_code}','super\UserCertificateTemplateController@UpdateTemplate');
	        Route::get('/admin/usercertificatetemplate/DeleteTemplate/{role_code}','super\UserCertificateTemplateController@DeleteTemplate');
	        /*Admin User Certificate Template end*/
	        

	    /**
	    * SUPER ADMIN PAGES ROUTS END
	    */

	    /**
	    * ADMIN PAGES ROUTS START
	    */
	        /*Admin Institute Setup start*/
	        Route::get('/admin/institute_setup/GetInstituteSliderImageData/{role_code}','admin\InstituteSetupController@GetInstituteSliderImageData');
	        Route::post('/admin/institute_setup/InsertSliderImage/{role_code}','admin\InstituteSetupController@InsertSliderImage');
	        Route::post('/admin/institute_setup/UpdateSliderImage/{role_code}','admin\InstituteSetupController@UpdateSliderImage');
	        Route::get('/admin/institute_setup/DeleteSliderImage/{role_code}','admin\InstituteSetupController@DeleteSliderImage');
	        Route::get('/admin/institute_setup/GetInstituteLogo/{role_code}','admin\InstituteSetupController@GetInstituteLogo');
	        Route::post('/admin/institute_setup/UpdateInstituteLogo/{role_code}','admin\InstituteSetupController@UpdateInstituteLogo');

	        /*Admin Institute Setup end*/

	        /*Admin Email Setup start*/
			Route::get('/admin/email_setup/GetEmailSetupData/{role_code}','admin\EmailSetupController@GetEmailSetupData');
			Route::get('/admin/email_setup/GetEmailSetupMailTypeData/{role_code}','admin\EmailSetupController@GetEmailSetupMailTypeData');
			Route::post('/admin/email_setup/InsertEmail/{role_code}','admin\EmailSetupController@InsertEmail');
			Route::post('/admin/email_setup/UpdateEmail/{role_code}','admin\EmailSetupController@UpdateEmail');
			Route::get('/admin/email_setup/DeleteEmail/{role_code}','admin\EmailSetupController@DeleteEmail');
	        /*Admin Email Setup end*/

	        /*Admin SMS Setup start*/
			Route::get('/admin/sms_setup/GetSmsSetupData/{role_code}','admin\SmsSetupController@GetSmsSetupData');
			Route::get('/admin/sms_setup/GetSmsSetupTypeData/{role_code}','admin\SmsSetupController@GetSmsSetupTypeData');
			Route::post('/admin/sms_setup/InsertSms/{role_code}','admin\SmsSetupController@InsertSms');
			Route::post('/admin/sms_setup/UpdateSms/{role_code}','admin\SmsSetupController@UpdateSms');
	        Route::get('/admin/sms_setup/DeleteSms/{role_code}','admin\SmsSetupController@DeleteSms');
	        /*Admin SMS Setup  end*/

	        /*Admin Attendance Device Setup start*/
	        Route::get('/admin/attendance_devicesetup/Getattendance_deviceData/{role_code}','admin\attendancedevicesetupController@Getattendance_deviceData');
	        Route::get('/admin/attendance_devicesetup/GetcmbModuleData/{role_code}','admin\attendancedevicesetupController@GetcmbModuleData');
	        Route::get('/admin/attendance_devicesetup/GetcmbEntityTypeData/{role_code}','admin\attendancedevicesetupController@GetcmbEntityTypeData');
	        Route::post('/admin/attendance_devicesetup/InsertAttendanceDevice/{role_code}','admin\attendancedevicesetupController@InsertAttendanceDevice');
	        Route::post('/admin/attendance_devicesetup/UpdateAttendanceDevice/{role_code}','admin\attendancedevicesetupController@UpdateAttendanceDevice');
	        Route::get('/admin/attendance_devicesetup/delete_attendance_devicesetup/{role_code}','admin\attendancedevicesetupController@delete_attendance_devicesetup');
	         /*Admin Attendance Device Setup End*/

	         /*Admin Manage User start*/
	         Route::get('/admin/manageuser/GetmanageuserData/{role_code}','admin\manageuserController@GetmanageuserData');
	         Route::get('/admin/manageuser/GetcmbPrimaryRoleData/{role_code}','admin\manageuserController@GetcmbPrimaryRoleData');
	         Route::get('/admin/manageuser/GetcmbUserlistData/{role_code}','admin\manageuserController@GetcmbUserlistData');
	         Route::post('/admin/manageuser/InsertDefineUser/{role_code}','admin\manageuserController@InsertDefineUser');
	         Route::post('/admin/manageuser/UpdateDefineUser/{role_code}','admin\manageuserController@UpdateDefineUser');
	         Route::get('/admin/manageuser/deleteDefineUser/{role_code}','admin\manageuserController@deleteDefineUser');
	         Route::get('/admin/manageuser/GetcmbUsergroupData/{role_code}','admin\manageuserController@GetcmbUsergroupData');
	         Route::get('/admin/manageuser/GetcmbUserData/{role_code}','admin\manageuserController@GetcmbUserData');
	         Route::get('/admin/manageuser/GetAssignUserGrpData/{role_code}','admin\manageuserController@GetAssignUserGrpData');
	         Route::get('/admin/manageuser/PasswordResetDefineUser/{role_code}','admin\manageuserController@PasswordResetDefineUser');
	         Route::get('/admin/manageuser/GetcmbUserName1Data/{role_code}','admin\manageuserController@GetcmbUserName1Data');
	         Route::get('/admin/manageuser/GetcmbUserGroup1Data/{role_code}','admin\manageuserController@GetcmbUserGroup1Data');
	         Route::get('/admin/manageuser/GetcmbInstituteData/{role_code}','admin\manageuserController@GetcmbInstituteData');
	         Route::post('/admin/manageuser/InsertAssignUserusergrp/{role_code}','admin\manageuserController@InsertAssignUserusergrp');
	         Route::post('/admin/manageuser/UpdateAssignUserusergrp/{role_code}','admin\manageuserController@UpdateAssignUserusergrp');
	         Route::get('/admin/manageuser/deleteAssignUserusergrp/{role_code}','admin\manageuserController@deleteAssignUserusergrp');
	         Route::get('/admin/manageuser/GetAddAssignUser/{role_code}','admin\manageuserController@GetAddAssignUser');
	          /*Admin Manage User End*/
	    /**
	    * ADMIN PAGES ROUTS END
	    */

	    /**
	    * ADMIN PAGE PAYROLL ROUTES START
	    */
	        /*Admin Component Master Setup start*/
	        Route::get('/payroll/component_master_set/GetComponentMasterSet_data/{role_code}','payroll\component_master_setController@GetComponentMasterSet_data');
	        Route::post('/payroll/component_master_set/InsertComponentMasterSet/{role_code}','payroll\component_master_setController@InsertComponentMasterSet');
	        Route::get('/payroll/component_master_set/DeleteComponentMasterSet/{role_code}','payroll\component_master_setController@DeleteComponentMasterSet');
	        Route::post('/payroll/component_master_set/UpdateComponentMasterSet/{role_code}','payroll\component_master_setController@UpdateComponentMasterSet');
	        /*Admin Component Master Setup End*/
	        /*Salary Setup Start*/
	        Route::get('/payroll/payroll_salary_setup/GetEmployeeJobType/{role_code}','payroll\PayrollSalarySetupController@GetEmployeeJobType');
	        Route::get('/payroll/payroll_salary_setup/GetEmployeeType/{role_code}','payroll\PayrollSalarySetupController@GetEmployeeType');
	        Route::get('/payroll/payroll_salary_setup/GetDesignation/{role_code}','payroll\PayrollSalarySetupController@GetDesignation');
	        Route::get('/payroll/payroll_salary_setup/GetFinancialYear/{role_code}','payroll\PayrollSalarySetupController@GetFinancialYear');
	        Route::post('/payroll/payroll_salary_setup/GetSalarySetupData/{role_code}','payroll\PayrollSalarySetupController@GetSalarySetupData');
	        Route::post('/payroll/payroll_salary_setup/GetOldSalarySetupData/{role_code}','payroll\PayrollSalarySetupController@GetOldSalarySetupData');
	        Route::post('/payroll/payroll_salary_setup/GetEmployeelist/{role_code}','payroll\PayrollSalarySetupController@GetEmployeelist');
	        Route::post('/payroll/payroll_salary_setup/GetPayScale/{role_code}','payroll\PayrollSalarySetupController@GetPayScale');
	        Route::post('/payroll/payroll_salary_setup/GetCompList/{role_code}','payroll\PayrollSalarySetupController@GetCompList');
	        Route::post('/payroll/payroll_salary_setup/SaveSalarySetup/{role_code}','payroll\PayrollSalarySetupController@SaveSalarySetup');
	        Route::post('/payroll/payroll_salary_setup/DeleteSalarySetup/{role_code}','payroll\PayrollSalarySetupController@DeleteSalarySetup');
			Route::get('/payroll/payroll_salary_setup/SalarySetupTemplateDownload/{role_code}','payroll\PayrollSalarySetupController@SalarySetupTemplateDownload');
			Route::post('/payroll/payroll_salary_setup/SalarySetupPreview/{role_code}','payroll\PayrollSalarySetupController@SalarySetupPreview');
	        /*Salary Setup End*/
	        /*Calculation Start*/
	       	Route::get('/payroll/payroll_calculation/GetFinacialYear/{role_code}','payroll\PayrollCalculationController@GetFinacialYear');
	        Route::get('/payroll/payroll_calculation/GetEmployeeType/{role_code}','payroll\PayrollCalculationController@GetEmployeeType');
	        Route::get('/payroll/payroll_calculation/GetDesignation/{role_code}','payroll\PayrollCalculationController@GetDesignation');
	        Route::post('/payroll/payroll_calculation/GetEarningsData/{role_code}','payroll\PayrollCalculationController@GetEarningsData');
	        Route::post('/payroll/payroll_calculation/GetDeductionsData/{role_code}','payroll\PayrollCalculationController@GetDeductionsData');
	        Route::post('/payroll/payroll_calculation/GetAddPaymentData/{role_code}','payroll\PayrollCalculationController@GetAddPaymentData');
	        Route::post('/payroll/payroll_calculation/GetAddDeductionData/{role_code}','payroll\PayrollCalculationController@GetAddDeductionData');
	        Route::post('/payroll/payroll_calculation/SalaryCalculation/{role_code}','payroll\PayrollCalculationController@SalaryCalculation');
	        Route::post('/payroll/payroll_calculation/DeleteAllSalary/{role_code}','payroll\PayrollCalculationController@DeleteAllSalary');
	        Route::post('/payroll/payroll_calculation/DeleteEmpSalarySetup/{role_code}','payroll\PayrollCalculationController@DeleteEmpSalarySetup');
	        /*Calculation End*/
	        /*Payroll itSetup start*/
	        Route::get('/payroll/payroll_itsetup/GetFinancialYrData/{role_code}', 'payroll\payroll_itsetupController@GetFinancialYrData');
	        Route::post('/payroll/payroll_itsetup/InsertFinancialYrData/{role_code}', 'payroll\payroll_itsetupController@InsertFinancialYrData');
	        Route::post('/payroll/payroll_itsetup/UpdateFinancialYrData/{role_code}', 'payroll\payroll_itsetupController@UpdateFinancialYrData');
	        Route::get('/payroll/payroll_itsetup/DeleteFinancialYr/{role_code}', 'payroll\payroll_itsetupController@DeleteFinancialYr');
	        Route::get('/payroll/payroll_itsetup/GetPayDaysData/{role_code}', 'payroll\payroll_itsetupController@GetPayDaysData');
	        Route::post('/payroll/payroll_itsetup/UpdatePayDays/{role_code}', 'payroll\payroll_itsetupController@UpdatePayDays');
	        Route::get('/payroll/payroll_itsetup/GetComponentData/{role_code}', 'payroll\payroll_itsetupController@GetComponentData');
	        Route::get('/payroll/payroll_itsetup/GetComponentName/{role_code}', 'payroll\payroll_itsetupController@GetComponentName');
	        Route::get('/payroll/payroll_itsetup/GetAllComponentData/{role_code}', 'payroll\payroll_itsetupController@GetAllComponentData');
	        Route::post('/payroll/payroll_itsetup/InsertComponentData/{role_code}', 'payroll\payroll_itsetupController@InsertComponentData');
	        Route::get('/payroll/payroll_itsetup/GetComponentLogicData/{role_code}', 'payroll\payroll_itsetupController@GetComponentLogicData');
	        Route::post('/payroll/payroll_itsetup/ManageComponentLogicData/{role_code}', 'payroll\payroll_itsetupController@ManageComponentLogicData');
	        Route::post('/payroll/payroll_itsetup/UpdateComponentData/{role_code}', 'payroll\payroll_itsetupController@UpdateComponentData');
	        Route::get('/payroll/payroll_itsetup/DeleteComponent/{role_code}', 'payroll\payroll_itsetupController@DeleteComponent');
	        Route::get('/payroll/payroll_itsetup/GetFinancialYr/{role_code}', 'payroll\payroll_itsetupController@GetFinancialYr');
	        Route::get('/payroll/payroll_itsetup/GetPayBandData/{role_code}', 'payroll\payroll_itsetupController@GetPayBandData');
	        Route::get('/payroll/payroll_itsetup/GetEmpType/{role_code}', 'payroll\payroll_itsetupController@GetEmpType');
	        Route::get('/payroll/payroll_itsetup/GetCompData/{role_code}', 'payroll\payroll_itsetupController@GetCompData');
	        Route::post('/payroll/payroll_itsetup/InsertPayBandData/{role_code}', 'payroll\payroll_itsetupController@InsertPayBandData');
	        Route::post('/payroll/payroll_itsetup/UpdateEmpSalaryOnPayscale/{role_code}', 'payroll\payroll_itsetupController@UpdateEmpSalaryOnPayscale');
	        Route::post('/payroll/payroll_itsetup/SavePayBandData/{role_code}', 'payroll\payroll_itsetupController@SavePayBandData');
	        Route::get('/payroll/payroll_itsetup/GET_UPDATED_EMP_LIST/{role_code}', 'payroll\payroll_itsetupController@GET_UPDATED_EMP_LIST');
	        Route::get('/payroll/payroll_itsetup/GetDaArrearData/{role_code}', 'payroll\payroll_itsetupController@GetDaArrearData');
	        Route::get('/payroll/payroll_itsetup/GetPayScale/{role_code}', 'payroll\payroll_itsetupController@GetPayScale');
	        Route::get('/payroll/payroll_itsetup/GetPayScaleData/{role_code}', 'payroll\payroll_itsetupController@GetPayScaleData');
	        Route::post('/payroll/payroll_itsetup/SaveDaArrearData/{role_code}', 'payroll\payroll_itsetupController@SaveDaArrearData');
	        Route::get('/payroll/payroll_itsetup/GetIncrementData/{role_code}', 'payroll\payroll_itsetupController@GetIncrementData');
	        Route::get('/payroll/payroll_itsetup/GetInstituteDetailsData/{role_code}', 'payroll\payroll_itsetupController@GetInstituteDetailsData');
	        Route::post('/payroll/payroll_itsetup/InsertInstituteData/{role_code}', 'payroll\payroll_itsetupController@InsertInstituteData');
	        Route::post('/payroll/payroll_itsetup/UpdateInstituteData/{role_code}', 'payroll\payroll_itsetupController@UpdateInstituteData');
	        Route::get('/payroll/payroll_itsetup/DeleteInstituteDetails/{role_code}', 'payroll\payroll_itsetupController@DeleteInstituteDetails');
	        Route::get('/payroll/payroll_itsetup/GetBankDetailsData/{role_code}', 'payroll\payroll_itsetupController@GetBankDetailsData');
	        Route::get('/payroll/payroll_itsetup/GetBankName/{role_code}', 'payroll\payroll_itsetupController@GetBankName');
	        Route::post('/payroll/payroll_itsetup/InsertBankData/{role_code}', 'payroll\payroll_itsetupController@InsertBankData');
	        Route::post('/payroll/payroll_itsetup/UpdateBankData/{role_code}', 'payroll\payroll_itsetupController@UpdateBankData');
	        Route::get('/payroll/payroll_itsetup/DeleteBankData/{role_code}', 'payroll\payroll_itsetupController@DeleteBankData');
	        Route::get('/payroll/payroll_itsetup/GetTdsScheduleData/{role_code}', 'payroll\payroll_itsetupController@GetTdsScheduleData');
	        Route::post('/payroll/payroll_itsetup/InsertTDSData/{role_code}', 'payroll\payroll_itsetupController@InsertTDSData');
	        Route::post('/payroll/payroll_itsetup/UpdateTDSData/{role_code}', 'payroll\payroll_itsetupController@UpdateTDSData');
	        Route::get('/payroll/payroll_itsetup/DeleteTDSData/{role_code}', 'payroll\payroll_itsetupController@DeleteTDSData');
		/*Payroll itSetup End*/
	        /**/
	        /*Payroll Actual Approval Setup Start*/
	        Route::get('/payroll/actual_approval_ui/GetTdsData/{role_code}', 'payroll\actual_approvalController@GetTdsData');
	        Route::get('/payroll/actual_approval_ui/GetFinancialYr/{role_code}', 'payroll\payroll_itsetupController@GetFinancialYr');
	        Route::get('/payroll/actual_approval_ui/GetPlanSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanSectionData');
	        Route::post('/payroll/actual_approval_ui/UpdateApprovalData/{role_code}', 'payroll\actual_approvalController@UpdateApprovalData');
	        Route::get('/payroll/actual_approval_ui/GetPlanRentData/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanRentData');
	        Route::post('/payroll/actual_approval_ui/UpdateActualRentData/{role_code}', 'payroll\actual_approvalController@UpdateActualRentData');
	        Route::get('/payroll/actual_approval_ui/GetPlanOthIncData/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanOthIncData');
	        Route::post('/payroll/actual_approval_ui/UpdateOthApprovalData/{role_code}', 'payroll\actual_approvalController@UpdateOthApprovalData');
	        Route::post('/payroll/actual_approval_ui/InsertOthActualSectionData/{role_code}', 'payroll\actual_approvalController@InsertOthActualSectionData');
	        Route::post('/payroll/actual_approval_ui/UpdateOthActualSectionData/{role_code}', 'payroll\actual_approvalController@UpdateOthActualSectionData');
	        Route::get('/payroll/actual_approval_ui/GetSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetSectionData');
	        Route::get('/payroll/actual_approval_ui/GetSubSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetSubSectionData');
	        Route::get('/payroll/actual_approval_ui/GetSubSectionDesc/{role_code}', 'payroll\payroll_itdeclarationsController@GetSubSectionDesc');
	        Route::get('/payroll/actual_approval_ui/GetOthSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetOthSectionData');
	        Route::get('/payroll/actual_approval_ui/GetOthSubSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetOthSubSectionData');
	        Route::get('/payroll/actual_approval_ui/GetOthSubSectionDesc/{role_code}', 'payroll\payroll_itdeclarationsController@GetOthSubSectionDesc');
	        Route::post('/payroll/actual_approval_ui/InsertActualSectionData/{role_code}', 'payroll\actual_approvalController@InsertActualSectionData');
	        Route::post('/payroll/actual_approval_ui/UpdateActualSectionData/{role_code}', 'payroll\actual_approvalController@UpdateActualSectionData');
	        Route::get('/payroll/actual_approval_ui/GetActualTotalAmount/{role_code}', 'payroll\actual_approvalController@GetActualTotalAmount');
	        Route::get('/payroll/actual_approval_ui/ApproveActualData/{role_code}', 'payroll\actual_approvalController@ApproveActualData');
			/*Payroll Actual Approval Setup End*/
			
			
			/*Payroll IT Declarations Setup Start*/
	        Route::get('/payroll/payroll_itdeclarations/GetPlanData/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanData');
	        Route::get('/payroll/payroll_itdeclarations/GetFinancialYr/{role_code}', 'payroll\payroll_itsetupController@GetFinancialYr');
	        Route::get('/payroll/payroll_itdeclarations/GetPlanSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanSectionData');
	        Route::get('/payroll/payroll_itdeclarations/GetSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetSectionData');
	        Route::get('/payroll/payroll_itdeclarations/GetSubSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetSubSectionData');
	        Route::get('/payroll/payroll_itdeclarations/GetSubSectionDesc/{role_code}', 'payroll\payroll_itdeclarationsController@GetSubSectionDesc');
	        Route::post('/payroll/payroll_itdeclarations/InsertPlanSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@InsertPlanSectionData');
	        Route::post('/payroll/payroll_itdeclarations/UpdatePlanSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@UpdatePlanSectionData');
	        Route::get('/payroll/payroll_itdeclarations/DeletePlanSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@DeletePlanSectionData');
	        Route::get('/payroll/payroll_itdeclarations/GetPlanRentData/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanRentData');
	        Route::post('/payroll/payroll_itdeclarations/UpdatePlanRentData/{role_code}', 'payroll\payroll_itdeclarationsController@UpdatePlanRentData');
	        Route::get('/payroll/payroll_itdeclarations/GetPlanTotalAmount/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanTotalAmount');
	        Route::get('/payroll/payroll_itdeclarations/GetOthSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetOthSectionData');
	        Route::get('/payroll/payroll_itdeclarations/GetOthSubSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@GetOthSubSectionData');
	        Route::get('/payroll/payroll_itdeclarations/GetOthSubSectionDesc/{role_code}', 'payroll\payroll_itdeclarationsController@GetOthSubSectionDesc');
	        Route::get('/payroll/payroll_itdeclarations/GetPlanOthIncData/{role_code}', 'payroll\payroll_itdeclarationsController@GetPlanOthIncData');
	        Route::post('/payroll/payroll_itdeclarations/InsertPlanOthIncData/{role_code}', 'payroll\payroll_itdeclarationsController@InsertPlanOthIncData');
	        Route::post('/payroll/payroll_itdeclarations/UpdatePlanOthIncData/{role_code}', 'payroll\payroll_itdeclarationsController@UpdatePlanOthIncData');
	        Route::get('/payroll/payroll_itdeclarations/DeletePlanOthIncData/{role_code}', 'payroll\payroll_itdeclarationsController@DeletePlanOthIncData');
	        Route::post('/payroll/payroll_itdeclarations/InsertActualSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@InsertActualSectionData');
	        Route::post('/payroll/payroll_itdeclarations/UpdateActualSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@UpdateActualSectionData');
	        Route::get('/payroll/payroll_itdeclarations/DeleteActualSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@DeleteActualSectionData');
	        Route::post('/payroll/payroll_itdeclarations/UpdateActualRentData/{role_code}', 'payroll\payroll_itdeclarationsController@UpdateActualRentData');
	        Route::post('/payroll/payroll_itdeclarations/InsertOthActualSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@InsertOthActualSectionData');
	        Route::post('/payroll/payroll_itdeclarations/UpdateOthActualSectionData/{role_code}', 'payroll\payroll_itdeclarationsController@UpdateOthActualSectionData');
	        Route::get('/payroll/payroll_itdeclarations/DeleteActualOthIncData/{role_code}', 'payroll\payroll_itdeclarationsController@DeleteActualOthIncData');
	        Route::get('/payroll/payroll_itdeclarations/GetActualTotalAmount/{role_code}', 'payroll\payroll_itdeclarationsController@GetActualTotalAmount');
			/*Payroll IT Declarations Setup End*/ 
			
			/*Payroll Employee View Setup Start*/ 
			Route::get('/payroll/payroll_emp_view/GetLocation/{role_code}', 'payroll\PayrollEmpViewController@GetLocation');
			Route::get('/payroll/payroll_emp_view/GetCategory/{role_code}', 'payroll\PayrollEmpViewController@GetCategory');
			Route::get('/payroll/payroll_emp_view/GetDesignation/{role_code}', 'payroll\PayrollEmpViewController@GetDesignation');
			Route::get('/payroll/payroll_emp_view/GetEmployeeList/{role_code}', 'payroll\PayrollEmpViewController@GetEmployeeList');
			Route::get('/payroll/payroll_emp_view/GetBankList/{role_code}', 'payroll\PayrollEmpViewController@GetBankList');
			Route::get('/payroll/payroll_emp_view/GetEpfoReason/{role_code}', 'payroll\PayrollEmpViewController@GetEpfoReason');
			Route::get('/payroll/payroll_emp_view/GetEsicReason/{role_code}', 'payroll\PayrollEmpViewController@GetEsicReason');
			Route::post('/payroll/payroll_emp_view/GetEmployeeViewData/{role_code}', 'payroll\PayrollEmpViewController@GetEmployeeViewData');
			Route::post('/payroll/payroll_emp_view/UPDATE_CURRENT_EMPLOYEE/{role_code}', 'payroll\PayrollEmpViewController@UPDATE_CURRENT_EMPLOYEE');
			Route::get('/payroll/payroll_emp_view/GetExitEmployeeData/{role_code}', 'payroll\PayrollEmpViewController@GetExitEmployeeData');
			Route::get('/payroll/payroll_emp_view/GetEmployeeFundData/{role_code}', 'payroll\PayrollEmpViewController@GetEmployeeFundData');
			Route::post('/payroll/payroll_emp_view/UPDATE_EMPLOYEE_FUND/{role_code}', 'payroll\PayrollEmpViewController@UPDATE_EMPLOYEE_FUND');
			Route::get('/payroll/payroll_emp_view/GetFundDropdown/{role_code}', 'payroll\PayrollEmpViewController@GetFundDropdown');
			/*Payroll Employee View Setup End*/ 

			/*Payroll Signature Setup Start*/ 
			Route::get('/payroll/signature_setup_ui/GetSignatureSetupData/{role_code}', 'payroll\PayrollSignatureSetupController@GetSignatureSetupData');
			Route::post('/payroll/signature_setup_ui/INSERT_SIGNATURE/{role_code}', 'payroll\PayrollSignatureSetupController@INSERT_SIGNATURE');
			Route::post('/payroll/signature_setup_ui/UPDATE_SIGNATURE/{role_code}', 'payroll\PayrollSignatureSetupController@UPDATE_SIGNATURE');
			Route::get('/payroll/signature_setup_ui/CHECK_DELETE_SIGNATURE/{role_code}', 'payroll\PayrollSignatureSetupController@CHECK_DELETE_SIGNATURE');
			Route::get('/payroll/signature_setup_ui/DELETE_SIGNATURE/{role_code}', 'payroll\PayrollSignatureSetupController@DELETE_SIGNATURE');
			Route::get('/payroll/signature_setup_ui/GetMappingSetupData/{role_code}', 'payroll\PayrollSignatureSetupController@GetMappingSetupData');
			Route::get('/payroll/signature_setup_ui/GetReportNameDropDown/{role_code}', 'payroll\PayrollSignatureSetupController@GetReportNameDropDown');
			Route::get('/payroll/signature_setup_ui/GetManageSignatureData/{role_code}', 'payroll\PayrollSignatureSetupController@GetManageSignatureData');
			Route::post('/payroll/signature_setup_ui/INSERT_MAPPING/{role_code}', 'payroll\PayrollSignatureSetupController@INSERT_MAPPING');
			Route::get('/payroll/signature_setup_ui/SaveSignature/{role_code}', 'payroll\PayrollSignatureSetupController@SaveSignature');
			/*Payroll Signature Setup End*/ 


			/*Payroll Report Setup Start*/ 
			Route::get('/payroll/report_setup/GetMappingSetupData/{role_code}', 'payroll\PayrollReportSetupController@GetMappingSetupData');
			Route::get('/payroll/report_setup/GetReportNameDropDown/{role_code}', 'payroll\PayrollReportSetupController@GetReportNameDropDown');
			Route::post('/payroll/report_setup/INSERT_MAPPING/{role_code}', 'payroll\PayrollReportSetupController@INSERT_MAPPING');
			Route::get('/payroll/report_setup/CHECK_DELETE_MAPPING/{role_code}', 'payroll\PayrollReportSetupController@CHECK_DELETE_MAPPING');
			Route::get('/payroll/report_setup/DELETE_MAPPING/{role_code}', 'payroll\PayrollReportSetupController@DELETE_MAPPING');
			Route::get('/payroll/report_setup/GetInstituteDetails/{role_code}', 'payroll\PayrollReportSetupController@GetInstituteDetails');
			Route::get('/payroll/report_setup/SaveTemplate/{role_code}', 'payroll\PayrollReportSetupController@SaveTemplate');
			/*Payroll Report Setup End*/ 
	    	
	    	
			/*Payroll Report Start*/ 
			###############################################################################################################################################################
			Route::get('/payroll/payroll_salary_slip_report/GetPayrollSalarySlipReport/{role_code}','payroll\PayrollReportController@GetPayrollSalarySlipReport');
			Route::get('/payroll/payroll_salary_slip_report/PayrollSalarySlipReportPdf/{role_code}/{empid}/{month}/{year}/{employeename}','payroll\PayrollReportController@PayrollSalarySlipReportPdf');
			Route::get('/payroll/payroll_salary_slip_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_salary_slip_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_salary_slip_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_salary_sheet_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_salary_sheet_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_salary_sheet_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');
			Route::get('/payroll/payroll_salary_sheet_report/GetBankDropdown/{role_code}','payroll\PayrollReportController@GetBankDropdown');
			Route::get('/payroll/payroll_salary_sheet_report/GetJobTypeDropdown/{role_code}','payroll\PayrollReportController@GetJobTypeDropdown');
			Route::get('/payroll/payroll_salary_sheet_report/GetPayrollSalarySheetReport/{role_code}','payroll\PayrollReportController@GetPayrollSalarySheetReport');
			Route::get('/payroll/payroll_salary_sheet_report/PayrollPaymentAdviceReportPdf/{role_code}/{year}/{month}/{emp_type}/{designation}/{bank}/{jobtype}','payroll\PayrollReportController@PayrollPaymentAdviceReportPdf');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_payment_advice_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_payment_advice_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_payment_advice_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');
			Route::get('/payroll/payroll_payment_advice_report/GetBankDropdown/{role_code}','payroll\PayrollReportController@GetBankDropdown');
			Route::get('/payroll/payroll_payment_advice_report/GetJobTypeDropdown/{role_code}','payroll\PayrollReportController@GetJobTypeDropdown');
			Route::get('/payroll/payroll_payment_advice_report/GetPayrollPaymentAdviceReport/{role_code}','payroll\PayrollReportController@GetPayrollPaymentAdviceReport');
			Route::get('/payroll/payroll_payment_advice_report/PayrollPaymentAdviceReportPdf/{role_code}/{year}/{month}/{emp_type}/{designation}/{bank}/{jobtype}','payroll\PayrollReportController@PayrollPaymentAdviceReportPdf');

			###############################################################################################################################################################

			Route::get('/payroll/payroll_epfo_jk_report/GetPayrollEpfoJKReport/{role_code}','payroll\PayrollReportController@GetPayrollEpfoJKReport');
			Route::get('/payroll/payroll_epfo_jk_report/PayrollEpfoJKReportPdf/{role_code}/{year}/{month}/{emp_type}/{designation}','payroll\PayrollReportController@PayrollEpfoJKReportPdf');
			Route::get('/payroll/payroll_epfo_jk_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_epfo_jk_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_epfo_jk_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_epfo_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_epfo_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_epfo_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');
			Route::get('/payroll/payroll_epfo_report/GetJobTypeDropdown/{role_code}','payroll\PayrollReportController@GetJobTypeDropdown');
			Route::get('/payroll/payroll_epfo_report/GetPayrollEpfoReport/{role_code}','payroll\PayrollReportController@GetPayrollEpfoReport');
			Route::get('/payroll/payroll_epfo_report/PayrollEpfoReportPdf/{role_code}/{year}/{month}/{emp_type}/{designation}/{jobtype}','payroll\PayrollReportController@PayrollEpfoReportPdf');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_esic_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_esic_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_esic_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');
			Route::get('/payroll/payroll_esic_report/GetJobTypeDropdown/{role_code}','payroll\PayrollReportController@GetJobTypeDropdown');
			Route::get('/payroll/payroll_esic_report/GetPayrollEsicReport/{role_code}','payroll\PayrollReportController@GetPayrollEsicReport');
			Route::get('/payroll/payroll_esic_report/PayrollEsicReportPdf/{role_code}/{year}/{month}/{emp_type}/{designation}/{jobtype}','payroll\PayrollReportController@PayrollEsicReportPdf');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_professional_tax_report/GetPayrollProfessionalTaxReport/{role_code}','payroll\PayrollReportController@GetPayrollProfessionalTaxReport');
			Route::get('/payroll/payroll_professional_tax_report/PayrollProfessionalTaxReportPdf/{role_code}/{year}/{month}/{emp_type}/{designation}','payroll\PayrollReportController@PayrollProfessionalTaxReportPdf');
			Route::get('/payroll/payroll_professional_tax_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_professional_tax_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_professional_tax_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');


			###############################################################################################################################################################
			Route::get('/payroll/payroll_tds_report/GetPayrollTdsReport/{role_code}','payroll\PayrollReportController@GetPayrollTdsReport');
			Route::get('/payroll/payroll_tds_report/PayrollTdsReportPdf/{role_code}/{year}','payroll\PayrollReportController@PayrollTdsReportPdf');
			Route::get('/payroll/payroll_tds_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_monthly_tds_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_monthly_tds_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_monthly_tds_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');
			Route::get('/payroll/payroll_monthly_tds_report/GetJobTypeDropdown/{role_code}','payroll\PayrollReportController@GetJobTypeDropdown');
			Route::get('/payroll/payroll_monthly_tds_report/GetPayrollMonthlyTdsReport/{role_code}','payroll\PayrollReportController@GetPayrollMonthlyTdsReport');
			Route::get('/payroll/payroll_monthly_tds_report/PayrollMonthlyTdsReportPdf/{role_code}/{year}/{month}/{emp_type}/{designation}/{jobtype}','payroll\PayrollReportController@PayrollMonthlyTdsReportPdf');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_advance_loan_report/GetPayrollAdvanceLoanReport/{role_code}','payroll\PayrollReportController@GetPayrollAdvanceLoanReport');
			Route::get('/payroll/payroll_advance_loan_report/PayrollAdvanceLoanReportPdf/{role_code}/{year}/{emp_type}/{designation}/{loan_type}','payroll\PayrollReportController@PayrollAdvanceLoanReportPdf');
			Route::get('/payroll/payroll_advance_loan_report/GetPayrollAdvanceLoanReportViewDetails/{role_code}','payroll\PayrollReportController@GetPayrollAdvanceLoanReportViewDetails');
			Route::get('/payroll/payroll_advance_loan_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_advance_loan_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_advance_loan_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');
			Route::get('/payroll/payroll_advance_loan_report/GetLoanTypeDropdown/{role_code}','payroll\PayrollReportController@GetLoanTypeDropdown');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_security_report/GetPayrollSecurityReport/{role_code}','payroll\PayrollReportController@GetPayrollSecurityReport');
			Route::get('/payroll/payroll_security_report/PayrollSecurityReportPdf/{role_code}/{year}/{emp_type}/{designation}','payroll\PayrollReportController@PayrollSecurityReportPdf');
			Route::get('/payroll/payroll_security_report/GetPayrollSecurityReportViewDetails/{role_code}','payroll\PayrollReportController@GetPayrollSecurityReportViewDetails');
			Route::get('/payroll/payroll_security_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			Route::get('/payroll/payroll_security_report/GetEmployeeTypeDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeTypeDropdown');
			Route::get('/payroll/payroll_security_report/GetEmployeeDesignationDropdown/{role_code}','payroll\PayrollReportController@GetEmployeeDesignationDropdown');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_epf_loan_report/GetPayrollEpfLoanReport/{role_code}','payroll\PayrollReportController@GetPayrollEpfLoanReport');
			Route::get('/payroll/payroll_epf_loan_report/PayrollEpfLoanReportPdf/{role_code}/{year}/{month}','payroll\PayrollReportController@PayrollEpfLoanReportPdf');
			Route::get('/payroll/payroll_epf_loan_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_annual_report/GetPayrollAnnualReport/{role_code}','payroll\PayrollReportController@GetPayrollAnnualReport');
			Route::get('/payroll/payroll_annual_report/PayrollAnnualReportPdf/{role_code}/{year}/{empid}','payroll\PayrollReportController@PayrollAnnualReportPdf');
			Route::get('/payroll/payroll_annual_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');

			###############################################################################################################################################################
			Route::get('/payroll/payroll_form16_report/GetPayrollForm16Report/{role_code}','payroll\PayrollReportController@GetPayrollForm16Report');
			Route::get('/payroll/payroll_form16_report/PayrollForm16ReportPdf/{role_code}/{year}/{empid}','payroll\PayrollReportController@PayrollForm16ReportPdf');
			Route::get('/payroll/payroll_form16_report/GetFinancialYearDropdown/{role_code}','payroll\PayrollReportController@GetFinancialYearDropdown');
			/*Payroll Report End*/ 
	       
	       
	       
	       
	        /*Payroll Statutory Setup start*/
	        Route::get('/payroll/statutory_setup_ui/GetProfessionalTaxData/{role_code}', 'payroll\statutory_setupController@GetProfessionalTaxData');
	        Route::get('/payroll/statutory_setup_ui/GetFinancialYr/{role_code}', 'payroll\payroll_itsetupController@GetFinancialYr');
	        Route::get('/payroll/statutory_setup_ui/GetStateData/{role_code}', 'payroll\statutory_setupController@GetStateData');
	        Route::post('/payroll/statutory_setup_ui/InsertProTaxData/{role_code}', 'payroll\statutory_setupController@InsertProTaxData');
	        Route::post('/payroll/statutory_setup_ui/UpdateProTaxData/{role_code}', 'payroll\statutory_setupController@UpdateProTaxData');
	        Route::get('/payroll/statutory_setup_ui/DeleteProTaxData/{role_code}', 'payroll\statutory_setupController@DeleteProTaxData');
	        Route::get('/payroll/statutory_setup_ui/GetEpfoData/{role_code}', 'payroll\statutory_setupController@GetEpfoData');
	        Route::get('/payroll/statutory_setup_ui/GetComponentName/{role_code}', 'payroll\payroll_itsetupController@GetComponentName');
	        Route::get('/payroll/statutory_setup_ui/GetLocationName/{role_code}', 'payroll\statutory_setupController@GetLocationName');
	        Route::post('/payroll/statutory_setup_ui/InsertEpfoData/{role_code}', 'payroll\statutory_setupController@InsertEpfoData');
	        Route::post('/payroll/statutory_setup_ui/UpdateEpfoData/{role_code}', 'payroll\statutory_setupController@UpdateEpfoData');
	        Route::get('/payroll/statutory_setup_ui/DeleteEpfoData/{role_code}', 'payroll\statutory_setupController@DeleteEpfoData');
	        Route::get('/payroll/statutory_setup_ui/GetEsicData/{role_code}', 'payroll\statutory_setupController@GetEsicData');
	        Route::post('/payroll/statutory_setup_ui/UpdateEsicData/{role_code}', 'payroll\statutory_setupController@UpdateEsicData');
	        Route::get('/payroll/statutory_setup_ui/GetItSectionData/{role_code}', 'payroll\statutory_setupController@GetItSectionData');
	        Route::post('/payroll/statutory_setup_ui/InsertItSectionData/{role_code}', 'payroll\statutory_setupController@InsertItSectionData');
	        Route::get('/payroll/statutory_setup_ui/GetSubSectionData/{role_code}', 'payroll\statutory_setupController@GetSubSectionData');
	        Route::post('/payroll/statutory_setup_ui/InsertSubSectionData/{role_code}', 'payroll\statutory_setupController@InsertSubSectionData');
	        Route::post('/payroll/statutory_setup_ui/UpdateSubSectionData/{role_code}', 'payroll\statutory_setupController@UpdateSubSectionData');
	        Route::get('/payroll/statutory_setup_ui/DeleteSubSectionData/{role_code}', 'payroll\statutory_setupController@DeleteSubSectionData');
	        Route::post('/payroll/statutory_setup_ui/UpdateItSectionData/{role_code}', 'payroll\statutory_setupController@UpdateItSectionData');
	        Route::get('/payroll/statutory_setup_ui/DeleteItSectionData/{role_code}', 'payroll\statutory_setupController@DeleteItSectionData');
	        Route::get('/payroll/statutory_setup_ui/GetOthIncomeData/{role_code}', 'payroll\statutory_setupController@GetOthIncomeData');
	        Route::post('/payroll/statutory_setup_ui/InsertOthIncomeData/{role_code}', 'payroll\statutory_setupController@InsertOthIncomeData');
	        Route::get('/payroll/statutory_setup_ui/GetOthSubSectionData/{role_code}', 'payroll\statutory_setupController@GetOthSubSectionData');
	        Route::post('/payroll/statutory_setup_ui/InsertOthSubSectionData/{role_code}', 'payroll\statutory_setupController@InsertOthSubSectionData');
	        Route::post('/payroll/statutory_setup_ui/UpdateOthSubSectionData/{role_code}', 'payroll\statutory_setupController@UpdateOthSubSectionData');
	        Route::get('/payroll/statutory_setup_ui/DeleteOthSubSectionData/{role_code}', 'payroll\statutory_setupController@DeleteOthSubSectionData');
	        Route::post('/payroll/statutory_setup_ui/UpdateOthIncomeData/{role_code}', 'payroll\statutory_setupController@UpdateOthIncomeData');
	        Route::get('/payroll/statutory_setup_ui/DeleteOthIncomeData/{role_code}', 'payroll\statutory_setupController@DeleteOthIncomeData');
	        Route::get('/payroll/statutory_setup_ui/GetTaxSlabData/{role_code}', 'payroll\statutory_setupController@GetTaxSlabData');
	        Route::post('/payroll/statutory_setup_ui/InsertTaxSlabData/{role_code}', 'payroll\statutory_setupController@InsertTaxSlabData');
	        Route::post('/payroll/statutory_setup_ui/UpdateTaxSlabData/{role_code}', 'payroll\statutory_setupController@UpdateTaxSlabData');
	        Route::get('/payroll/statutory_setup_ui/DeleteTaxSlabData/{role_code}', 'payroll\statutory_setupController@DeleteTaxSlabData');
	        Route::get('/payroll/statutory_setup_ui/GetItRebateData/{role_code}', 'payroll\statutory_setupController@GetItRebateData');
	        Route::post('/payroll/statutory_setup_ui/InsertItRebateData/{role_code}', 'payroll\statutory_setupController@InsertItRebateData');
	        Route::post('/payroll/statutory_setup_ui/UpdateItRebateData/{role_code}', 'payroll\statutory_setupController@UpdateItRebateData');
	        Route::get('/payroll/statutory_setup_ui/DeleteItRebateData/{role_code}', 'payroll\statutory_setupController@DeleteItRebateData');
	/*Payroll Statutory Setup End*/
			/*Payroll TDS Calculation End*/
	        Route::get('/payroll/payroll_tds_calculation/GetTdsPlanData/{role_code}', 'payroll\payroll_tds_calculationController@GetTdsPlanData');
	        Route::get('/payroll/payroll_tds_calculation/GetFinancialYr/{role_code}', 'payroll\payroll_itsetupController@GetFinancialYr');
	        Route::get('/payroll/payroll_tds_calculation/GetPlanTdsCalcData/{role_code}', 'payroll\payroll_tds_calculationController@GetPlanTdsCalcData');
	        Route::post('/payroll/payroll_tds_calculation/UpdatePlanTdsData/{role_code}', 'payroll\payroll_tds_calculationController@UpdatePlanTdsData');
	        Route::get('/payroll/payroll_tds_calculation/GetTdsActualData/{role_code}', 'payroll\payroll_tds_calculationController@GetTdsActualData');
	/*Payroll TDS Calculation End*/
	        /**
	    /* ADMIN PAGE PAYROLL ROUTES END
	    */
	   

	    /**
	    * FINANCE ADMIN PAGES START
	    */
			Route::get('/finance/entity_master/{role_code}','finance\FinanceAdminController@entity_master');
			Route::get('/finance/entity_master/GetEntityMasterData/{role_code}','finance\FinanceAdminController@GetEntityMasterData');
			Route::post('/finance/entity_master/INSERT_ENTITY/{role_code}','finance\FinanceAdminController@INSERT_ENTITY');
			Route::post('/finance/entity_master/UPDATE_ENTITY/{role_code}','finance\FinanceAdminController@UPDATE_ENTITY');
			Route::get('/finance/entity_master/CHECK_DELETE_ENTITY/{role_code}','finance\FinanceAdminController@CHECK_DELETE_ENTITY');
			Route::get('/finance/entity_master/DELETE_ENTITY/{role_code}','finance\FinanceAdminController@DELETE_ENTITY');
			
			Route::get('/finance/entity_report/{role_code}','finance\FinanceReportController@entity_report');
			Route::get('/finance/entity_report/GetFinancialYear/{role_code}','finance\FinanceReportController@GetFinancialYear');
			Route::get('/finance/entity_report/GetEntity/{role_code}','finance\FinanceReportController@GetEntity');
			Route::get('/finance/entity_report/GetEntityReportData/{role_code}','finance\FinanceReportController@GetEntityReportData');
			
			Route::get('/finance/ledger_report/{role_code}','finance\FinanceReportController@ledger_report');
			Route::get('/finance/ledger_report/GetFinancialYear/{role_code}','finance\FinanceReportController@GetFinancialYear');
			Route::get('/finance/ledger_report/GetLedger/{role_code}','finance\FinanceReportController@GetLedger');
			Route::get('/finance/ledger_report/GetLedgerReportData/{role_code}','finance\FinanceReportController@GetLedgerReportData');
			
			Route::get('/finance/account_report/{role_code}','finance\FinanceReportController@account_report');
			Route::get('/finance/account_report/GetFinancialYear/{role_code}','finance\FinanceReportController@GetFinancialYear');
			Route::get('/finance/account_report/GetAccount/{role_code}','finance\FinanceReportController@GetAccount');
			Route::get('/finance/account_report/GetAccountReportData/{role_code}','finance\FinanceReportController@GetAccountReportData');
			
			Route::get('/finance/receipt_report/{role_code}','finance\FinanceReportController@receipt_report');
			Route::get('/finance/receipt_report/GetFinancialYear/{role_code}','finance\FinanceReportController@GetFinancialYear');
			Route::get('/finance/receipt_report/GetReceiptReportData/{role_code}','finance\FinanceReportController@GetReceiptReportData');
			
			Route::get('/finance/payment_report/{role_code}','finance\FinanceReportController@payment_report');
			Route::get('/finance/payment_report/GetFinancialYear/{role_code}','finance\FinanceReportController@GetFinancialYear');
			Route::get('/finance/payment_report/GetPaymentReportData/{role_code}','finance\FinanceReportController@GetPaymentReportData');
			
			Route::get('/finance/balance_sheet/{role_code}','finance\FinanceReportController@balance_sheet');
			Route::get('/finance/balance_sheet/GetFinancialYear/{role_code}','finance\FinanceReportController@GetFinancialYear');
			Route::get('/finance/balance_sheet/GetBalanceSheetReportData/{role_code}','finance\FinanceReportController@GetBalanceSheetReportData');
			
			Route::get('/finance/budget_vs_actual_report/{role_code}','finance\FinanceReportController@budget_vs_actual_report');
			Route::get('/finance/budget_vs_actual_report/GetFinancialYear/{role_code}','finance\FinanceReportController@GetFinancialYear');
			Route::get('/finance/budget_vs_actual_report/GetAccount/{role_code}','finance\FinanceReportController@GetAccount');
			Route::get('/finance/budget_vs_actual_report/GetBudgetVsActualData/{role_code}','finance\FinanceReportController@GetBudgetVsActualData');
			
			
			Route::get('/finance/ob_master/{role_code}','finance\FinanceTransactionController@ob_master');
			Route::get('/finance/ob_master/GetFinancialYear/{role_code}','finance\FinanceTransactionController@GetFinancialYear');
			Route::get('/finance/ob_master/GetAccount/{role_code}','finance\FinanceTransactionController@GetAccount');
			Route::get('/finance/ob_master/GetOpeningbalanceData/{role_code}','finance\FinanceTransactionController@GetOpeningbalanceData');
			Route::post('/finance/ob_master/INSERT_OB/{role_code}','finance\FinanceTransactionController@INSERT_OB');
			Route::post('/finance/ob_master/UPDATE_OB/{role_code}','finance\FinanceTransactionController@UPDATE_OB');
			Route::get('/finance/ob_master/DELETE_OB/{role_code}','finance\FinanceTransactionController@DELETE_OB');
			
			Route::get('/finance/transaction_delete_index/{role_code}','finance\FinanceTransactionController@transaction_delete_index');
			Route::get('/finance/transaction_delete_index/GetFinancialYear/{role_code}','finance\FinanceTransactionController@GetFinancialYear');
			Route::get('/finance/transaction_delete_index/GetVoucherNumberData/{role_code}','finance\FinanceTransactionController@GetVoucherNumberData');
			Route::get('/finance/transaction_delete_index/GetData/{role_code}','finance\FinanceTransactionController@GetData');
			Route::get('/finance/transaction_delete_index/DELETE_TRANSACTION/{role_code}','finance\FinanceTransactionController@DELETE_TRANSACTION');
			
			Route::get('/finance/transaction_index/{role_code}','finance\FinanceTransactionController@transaction_index');
			Route::get('/finance/transaction_index/GetFinancialYear/{role_code}','finance\FinanceTransactionController@GetFinancialYear');
			Route::get('/finance/transaction_index/GetNewEntity/{role_code}','finance\FinanceTransactionController@GetNewEntity');
			Route::get('/finance/transaction_index/GetCollection/{role_code}','finance\FinanceTransactionController@GetCollection');
			Route::get('/finance/transaction_index/GetCashAccount/{role_code}','finance\FinanceTransactionController@GetCashAccount');
			Route::get('/finance/transaction_index/GetSundryDebtorAccount/{role_code}','finance\FinanceTransactionController@GetSundryDebtorAccount');
			Route::get('/finance/transaction_index/GetBankAccount/{role_code}','finance\FinanceTransactionController@GetBankAccount');
			Route::get('/finance/transaction_index/GetFundAccount/{role_code}','finance\FinanceTransactionController@GetFundAccount');
			Route::get('/finance/transaction_index/GetLedgerNames/{role_code}','finance\FinanceTransactionController@GetLedgerNames');
			Route::get('/finance/transaction_index/GetNewEntity2/{role_code}','finance\FinanceTransactionController@GetNewEntity2');
			Route::get('/finance/transaction_index/TRANSACTION_DEPRECIATION_EDIT/{role_code}','finance\FinanceTransactionController@TRANSACTION_DEPRECIATION_EDIT');
			Route::get('/finance/transaction_index/INSERT_LEDGER/{role_code}','finance\FinanceTransactionController@INSERT_LEDGER');
			Route::get('/finance/transaction_index/INSERT_ENTITY/{role_code}','finance\FinanceTransactionController@INSERT_ENTITY');
			
			Route::get('/finance/fixed_deposit/{role_code}','finance\FinanceTransactionController@fixed_deposit');
			Route::get('/finance/fixed_deposit/GetFixedDepositData/{role_code}','finance\FinanceTransactionController@GetFixedDepositData');
			Route::get('/finance/fixed_deposit/GetAccountData/{role_code}','finance\FinanceTransactionController@GetAccountData');
			Route::get('/finance/fixed_deposit/GetLedger/{role_code}','finance\FinanceTransactionController@GetLedger');
			Route::post('/finance/fixed_deposit/INSERT_FIXED_DEPOSIT/{role_code}','finance\FinanceTransactionController@INSERT_FIXED_DEPOSIT');
			
		/**
	    * FINANCE ADMIN PAGES END
	    */

		/**
	    * BUDGET ADMIN PAGES START
	    */
			Route::get('/budget/account_setup/{role_code}','budget\BudgetAdminController@account_setup');
			Route::get('/budget/account_setup/GetAccountMasterData/{role_code}','budget\BudgetAdminController@GetAccountMasterData');
			Route::post('/budget/account_setup/INSERT_ACCOUNT/{role_code}','budget\BudgetAdminController@INSERT_ACCOUNT');
			Route::post('/budget/account_setup/UPDATE_ACCOUNT/{role_code}','budget\BudgetAdminController@UPDATE_ACCOUNT');
			Route::get('/budget/account_setup/CHECK_DELETE_ACCOUNT/{role_code}','budget\BudgetAdminController@CHECK_DELETE_ACCOUNT');
			Route::get('/budget/account_setup/DELETE_ACCOUNT/{role_code}','budget\BudgetAdminController@DELETE_ACCOUNT');
			
			Route::get('/budget/account_setup/GetLedgerMasterData/{role_code}','budget\BudgetAdminController@GetLedgerMasterData');
			Route::get('/budget/account_setup/GetAcountDropdown/{role_code}','budget\BudgetAdminController@GetAcountDropdown');
			Route::post('/budget/account_setup/INSERT_LEDGER/{role_code}','budget\BudgetAdminController@INSERT_LEDGER');
			Route::post('/budget/account_setup/UPDATE_LEDGER/{role_code}','budget\BudgetAdminController@UPDATE_LEDGER');
			Route::get('/budget/account_setup/CHECK_DELETE_LEDGER/{role_code}','budget\BudgetAdminController@CHECK_DELETE_LEDGER');
			Route::get('/budget/account_setup/DELETE_LEDGER/{role_code}','budget\BudgetAdminController@DELETE_LEDGER');
		/**
	    * BUDGET ADMIN PAGES END
	    */
	    /**
	    * ADMIN PAGE BUDGET ROUTES START
	    */
	    Route::get('/budget/budget_setup_assign/GetFinance_yearData/{role_code}','budget\Budget_setup_assignController@GetFinance_yearData');
	    Route::post('/budget/budget_setup_assign/InsertBudget_Fyear/{role_code}','budget\Budget_setup_assignController@InsertBudget_Fyear');
	    Route::post('/budget/budget_setup_assign/UpdateBudget_Fyear/{role_code}','budget\Budget_setup_assignController@UpdateBudget_Fyear');
	    Route::get('/budget/budget_setup_assign/deleteBudget_Fyear/{role_code}','budget\Budget_setup_assignController@deleteBudget_Fyear');
	    Route::get('/budget/budget_setup_assign/GetFinancialYearData/{role_code}','budget\Budget_setup_assignController@GetFinancialYearData');
	    Route::get('/budget/budget_setup_assign/GetHeadMapData/{role_code}','budget\Budget_setup_assignController@GetHeadMapData');
	    ####################################################################################################################################
	    Route::get('/budget/budget_vs_actual_amout/GetBudget_vs_ActualData/{role_code}','budget\budget_vs_actual_amoutController@GetBudget_vs_ActualData');
	    Route::get('/budget/budget_vs_actual_amout/GetFinancialYearData/{role_code}','budget\budget_vs_actual_amoutController@GetFinancialYearData');
	    Route::get('/budget/budget_vs_actual_amout/ShowData/{role_code}','budget\budget_vs_actual_amoutController@ShowData');
	    Route::get('/budget/budget_vs_actual_amout/BudgetExcelDownload/{role_code}','budget\budget_vs_actual_amoutController@BudgetExcelDownload');
	    #####################################################################################################################################################
	    Route::get('/budget/budget_vs_actual_graph/GetFinancialYearData/{role_code}','budget\budget_vs_actual_graphController@GetFinancialYearData');
	    #######################################################################################################################################################
	    Route::get('/budget/budget_planning/GetBudget_PlanningData/{role_code}','budget\budget_planningController@GetBudget_PlanningData');
	    Route::get('/budget/budget_planning/GetBudget_Planning1Data/{role_code}','budget\budget_planningController@GetBudget_Planning1Data');
	    Route::post('/budget/budget_planning/UpdateStudentRecordconfirm/{role_code}','budget\budget_planningController@UpdateStudentRecordconfirm');
	    Route::post('/budget/budget_planning/CloseLedgerTypeAmount/{role_code}','budget\budget_planningController@CloseLedgerTypeAmount');
	    Route::post('/budget/budget_planning/InsertBudgetLedgerTypeAmount/{role_code}','budget\budget_planningController@InsertBudgetLedgerTypeAmount');

	       /**
	    * ADMIN PAGE BUDGET ROUTES END
	    */
	    
	    /**
	    * ADMIN STORE CONTROLLER ROUTES Starts
	    */
	    Route::get('/store/store_item_setup/{role_code}','store\StoreAdminController@store_item_setup');
	    //Unit Tab-1
	    Route::get('/store/store_item_setup/GetUnitDataTable/{role_code}','store\ItemSetupController@GetUnitDataTable');
	    Route::post('/store/store_item_setup/InsertUnit/{role_code}','store\ItemSetupController@InsertUnit');
	    Route::post('/store/store_item_setup/UpdateUnit/{role_code}','store\ItemSetupController@UpdateUnit');
	    Route::get('/store/store_item_setup/DeleteUnit/{role_code}','store\ItemSetupController@DeleteUnit');
	    //Category Tab-2
	    Route::get('/store/store_item_setup/GetCategoryDataTable/{role_code}','store\ItemSetupController@GetCategoryDataTable');
	    Route::post('/store/store_item_setup/InsertCategory/{role_code}','store\ItemSetupController@InsertCategory');
	    Route::post('/store/store_item_setup/UpdateCategory/{role_code}','store\ItemSetupController@UpdateCategory');
	    Route::get('/store/store_item_setup/DeleteCategory/{role_code}','store\ItemSetupController@DeleteCategory');
	    //Item Master Tab-3
	    Route::get('/store/store_item_setup/GetItemMasterDataTable/{role_code}','store\ItemSetupController@GetItemMasterDataTable');
	    Route::post('/store/store_item_setup/InsertItemMaster/{role_code}','store\ItemSetupController@InsertItemMaster');
	    Route::post('/store/store_item_setup/UpdateItemMaster/{role_code}','store\ItemSetupController@UpdateItemMaster');
	    Route::get('/store/store_item_setup/DeleteItemMaster/{role_code}','store\ItemSetupController@DeleteItemMaster');
	    //Make Master Tab-4
	    Route::get('/store/store_item_setup/GetMakeMasterDataTable/{role_code}','store\ItemSetupController@GetMakeMasterDataTable');
	    Route::post('/store/store_item_setup/InsertMakeMaster/{role_code}','store\ItemSetupController@InsertMakeMaster');
	    Route::post('/store/store_item_setup/UpdateMakeMaster/{role_code}','store\ItemSetupController@UpdateMakeMaster');
	    Route::get('/store/store_item_setup/DeleteMakeMaster/{role_code}','store\ItemSetupController@DeleteMakeMaster');
	    //Mapping Tab-5
	    Route::get('/store/store_item_setup/GetMappingDataTable/{role_code}','store\ItemSetupController@GetMappingDataTable');
	    Route::post('/store/store_item_setup/InsertMapping/{role_code}','store\ItemSetupController@InsertMapping');
	    Route::post('/store/store_item_setup/UpdateMapping/{role_code}','store\ItemSetupController@UpdateMapping');
	    Route::get('/store/store_item_setup/DeleteMapping/{role_code}','store\ItemSetupController@DeleteMapping');
	    Route::get('/store/store_item_setup/GetStatusChange/{role_code}','store\ItemSetupController@GetStatusChange');
	    //Store Master Tab-6
	    Route::get('/store/store_item_setup/GetStoreMasterDataTable/{role_code}','store\ItemSetupController@GetStoreMasterDataTable');
	    Route::post('/store/store_item_setup/InsertStoreMaster/{role_code}','store\ItemSetupController@InsertStoreMaster');
	    Route::post('/store/store_item_setup/UpdateStorMaster/{role_code}','store\ItemSetupController@UpdateStorMaster');
	    Route::get('/store/store_item_setup/DeleteStoreMaster/{role_code}','store\ItemSetupController@DeleteStoreMaster');
	    //Store To Department Tab-7
	    Route::get('/store/store_item_setup/GetDepartmentSelectize/{role_code}','store\ItemSetupController@GetDepartmentSelectize');
	    Route::get('/store/store_item_setup/GetStoreSelectize/{role_code}','store\ItemSetupController@GetStoreSelectize');
	    Route::get('/store/store_item_setup/GetSDMapDataTable/{role_code}','store\ItemSetupController@GetSDMapDataTable');
	    Route::post('/store/store_item_setup/InsertSDMap/{role_code}','store\ItemSetupController@InsertSDMap');
	    Route::post('/store/store_item_setup/UpdateSDMap/{role_code}','store\ItemSetupController@UpdateSDMap');
	    Route::get('/store/store_item_setup/DeleteSDMap/{role_code}','store\ItemSetupController@DeleteSDMap');
	    
	      
	    Route::get('/store/store_vendor_setup/{role_code}','store\StoreAdminController@store_vendor_setup');//view

	    Route::get('/store/store_vendor_setup/GetVendor_data/{role_code}','store\VendorSetupController@GetVendor_data');
	    Route::get('/store/store_vendor_setup/getStateComboData/{role_code}','store\VendorSetupController@getStateComboData');
	    Route::get('/store/store_vendor_setup/getBankNameComboData/{role_code}','store\VendorSetupController@getBankNameComboData');
	    Route::post('/store/store_vendor_setup/InsertVendorMaster/{role_code}','store\VendorSetupController@InsertVendorMaster');
	    Route::get('/store/store_vendor_setup/DeleteVendorData/{role_code}','store\VendorSetupController@DeleteVendorData');
	    Route::post('/store/store_vendor_setup/UpdateVendorMaster/{role_code}','store\VendorSetupController@UpdateVendorMaster');
	     //Store Activity Aseet Receive Tab Start
	    Route::get('/store/asset_receive/{role_code}','store\StoreAdminController@asset_receive');
	    Route::get('/store/asset_receive/GetVendorNameSelectize/{role_code}','store\AssetReceiveController@GetVendorNameSelectize');
	    Route::get('/store/asset_receive/GetAssetReceiveDataTable/{role_code}','store\AssetReceiveController@GetAssetReceiveDataTable');
	    Route::post('/store/asset_receive/InsertAssetReceive/{role_code}','store\AssetReceiveController@InsertAssetReceive');
	    Route::post('/store/asset_receive/UpdateAssetReceive/{role_code}','store\AssetReceiveController@UpdateAssetReceive');
	    Route::get('/store/asset_receive/DeleteAssetReceive/{role_code}','store\AssetReceiveController@DeleteAssetReceive');
	    //Store Activity Aseet Receive  Manage Asset Start
	    Route::get('/store/asset_receive/GetManageAssetDataTable/{role_code}','store\AssetReceiveController@GetManageAssetDataTable');
	    Route::get('/store/asset_receive/GetItemNameSelectize/{role_code}','store\AssetReceiveController@GetItemNameSelectize');
	    Route::post('/store/asset_receive/InsertManageAsset/{role_code}','store\AssetReceiveController@InsertManageAsset');
	    Route::post('/store/asset_receive/UpdateManageAsset/{role_code}','store\AssetReceiveController@UpdateManageAsset');
	    Route::get('/store/asset_receive/DeleteManageAsset/{role_code}','store\AssetReceiveController@DeleteManageAsset');
	    //Store Activity Aseet Receive End
	     //Store Activity Asset Status Update Tab Start
	    Route::get('/store/asset_dispose/{role_code}','store\StoreAdminController@asset_dispose');
	    Route::get('/store/asset_dispose/GetStatusDataTable/{role_code}','store\AssetDisposeController@GetStatusDataTable');
	    Route::post('/store/asset_dispose/UpdateStatus/{role_code}','store\AssetDisposeController@UpdateStatus');
	    //Store Activity Asset Status Update Tab End
	     //Store /Reports/Asset Received Tab Start
	    Route::get('/store/asset_receipt_report/{role_code}','store\StoreAdminController@asset_receipt_report');
	    Route::get('/store/asset_receipt_report/GetARRDataTable/{role_code}','store\AssetReceivedReportController@GetARRDataTable');
	    //Store /Reports/Asset Received Tab End

	    //Store /Reports/Asset Issue Tab Start
	    Route::get('/store/asset_issue_report/{role_code}','store\StoreAdminController@asset_issue_report');
	    Route::get('/store/asset_issue_report/GetAIRDataTable/{role_code}','store\AssetIssuedReportController@GetAIRDataTable');
	    //Store /Reports/Asset Issue Tab End

	    //Store /Reports/Asset Stock Tab Start
	    Route::get('/store/asset_stock_report/{role_code}','store\StoreAdminController@asset_stock_report');
	    Route::get('/store/asset_stock_report/GetASRDataTable/{role_code}','store\AssetStockReportController@GetASRDataTable');
	    //Store /Reports/Asset Stock Tab End

	    //Store /Reports/ASTB Tab Start
	    Route::get('/store/astb_report/{role_code}','store\StoreAdminController@astb_report');
	    Route::get('/store/astb_report/GetCategorySelectize/{role_code}','store\ASTBController@GetCategorySelectize');
	    Route::get('/store/astb_report/GetASTBRDataTable/{role_code}','store\ASTBController@GetASTBRDataTable');
	    //Store /Reports/ASTB Tab End
	    /**
	    *ADMIN STORE CONTROLLER ROUTES END
	    */
	    /**
	    * TRANSPORT ADMIN PAGES START
	    */
	    //###########################################################---VENDER--########################################################################//
	    Route::get('/transport/transport_general_setup/GetVendorData/{role_code}','transport\transport_general_setupController@GetVendorData');
	    Route::post('/transport/transport_general_setup/InsertVendor/{role_code}','transport\transport_general_setupController@InsertVendor');
	    Route::post('/transport/transport_general_setup/UpdateVendor/{role_code}','transport\transport_general_setupController@UpdateVendor');
	    Route::get('/transport/transport_general_setup/deleteVendor/{role_code}','transport\transport_general_setupController@deleteVendor');
	    //############################################################--MAKE--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetMakeData/{role_code}','transport\transport_general_setupController@GetMakeData');
	    Route::post('/transport/transport_general_setup/InsertMake/{role_code}','transport\transport_general_setupController@InsertMake');
	    Route::post('/transport/transport_general_setup/UpdateMake/{role_code}','transport\transport_general_setupController@UpdateMake');
	    Route::get('/transport/transport_general_setup/deleteMake/{role_code}','transport\transport_general_setupController@deleteMake');
	    //############################################################--VEHICLE--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetVehicleData/{role_code}','transport\transport_general_setupController@GetVehicleData');
	    Route::post('/transport/transport_general_setup/InsertVehicle/{role_code}','transport\transport_general_setupController@InsertVehicle');
	    Route::post('/transport/transport_general_setup/UpdateVehicle/{role_code}','transport\transport_general_setupController@UpdateVehicle');
	    Route::get('/transport/transport_general_setup/deleteVehicle/{role_code}','transport\transport_general_setupController@deleteVehicle');
	    //############################################################--MODEL--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetModelData/{role_code}','transport\transport_general_setupController@GetModelData');
	    Route::post('/transport/transport_general_setup/InsertModel/{role_code}','transport\transport_general_setupController@InsertModel');
	    Route::post('/transport/transport_general_setup/UpdateModel/{role_code}','transport\transport_general_setupController@UpdateModel');
	    Route::get('/transport/transport_general_setup/deleteModel/{role_code}','transport\transport_general_setupController@deleteModel');
	    //############################################################--ROUTE--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetRouteData/{role_code}','transport\transport_general_setupController@GetRouteData');
	    Route::post('/transport/transport_general_setup/InsertRoute/{role_code}','transport\transport_general_setupController@InsertRoute');
	    Route::post('/transport/transport_general_setup/UpdateRoute/{role_code}','transport\transport_general_setupController@UpdateRoute');
	    Route::get('/transport/transport_general_setup/deleteRoute/{role_code}','transport\transport_general_setupController@deleteRoute');
	    //############################################################--SERVICE CATEGORY--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetServiceCategoryData/{role_code}','transport\transport_general_setupController@GetServiceCategoryData');
	    Route::post('/transport/transport_general_setup/InsertServiceCategory/{role_code}','transport\transport_general_setupController@InsertServiceCategory');
	    Route::post('/transport/transport_general_setup/UpdateServiceCategory/{role_code}','transport\transport_general_setupController@UpdateServiceCategory');
	    Route::get('/transport/transport_general_setup/deleteServiceCategory/{role_code}','transport\transport_general_setupController@deleteServiceCategory');
	    //############################################################--SERVICE TYPE--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetServiceTypeData/{role_code}','transport\transport_general_setupController@GetServiceTypeData');
	    Route::post('/transport/transport_general_setup/InsertServiceType/{role_code}','transport\transport_general_setupController@InsertServiceType');
	    Route::post('/transport/transport_general_setup/UpdateServiceType/{role_code}','transport\transport_general_setupController@UpdateServiceType');
	    Route::get('/transport/transport_general_setup/deleteServiceType/{role_code}','transport\transport_general_setupController@deleteServiceType');
	    //############################################################--SERVICE DESCRIPTION--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetServiceDescriptionData/{role_code}','transport\transport_general_setupController@GetServiceDescriptionData');
	    Route::post('/transport/transport_general_setup/InsertServiceDescription/{role_code}','transport\transport_general_setupController@InsertServiceDescription');
	    Route::post('/transport/transport_general_setup/UpdateServiceDescription/{role_code}','transport\transport_general_setupController@UpdateServiceDescription');
	    Route::get('/transport/transport_general_setup/deleteServiceDescrption/{role_code}','transport\transport_general_setupController@deleteServiceDescrption');
	    //############################################################--SERVICE DESCRIPTION--#######################################################################//
	    Route::get('/transport/transport_general_setup/GetFuleTypeData/{role_code}','transport\transport_general_setupController@GetFuleTypeData');
	    Route::post('/transport/transport_general_setup/InsertFuelType/{role_code}','transport\transport_general_setupController@InsertFuelType');
	    Route::post('/transport/transport_general_setup/UpdateFuelType/{role_code}','transport\transport_general_setupController@UpdateFuelType');
	    Route::get('/transport/transport_general_setup/deleteFuleType/{role_code}','transport\transport_general_setupController@deleteFuleType');
	     //Setup/Master-2/Vehicle Master Tab-1
	    Route::get('/transport/transport_vehicle_setup/GetVehicleTypeSelectize/{role_code}','transport\TransportVehicleSetupController@GetVehicleTypeSelectize');
	    Route::get('/transport/transport_vehicle_setup/GetVehicleModelSelectize/{role_code}','transport\TransportVehicleSetupController@GetVehicleModelSelectize');
	    Route::get('/transport/transport_vehicle_setup/GetVenderSelectize/{role_code}','transport\TransportVehicleSetupController@GetVenderSelectize');
	    Route::get('/transport/transport_vehicle_setup/GetManufactureSelectize/{role_code}','transport\TransportVehicleSetupController@GetManufactureSelectize');
	    Route::get('/transport/transport_vehicle_setup/GetFuelTypeSelectize/{role_code}','transport\TransportVehicleSetupController@GetFuelTypeSelectize');
	    Route::get('/transport/transport_vehicle_setup/GetVehicleMasterDataTable/{role_code}','transport\TransportVehicleSetupController@GetVehicleMasterDataTable');
	    Route::post('/transport/transport_vehicle_setup/InsertVehicleMaster/{role_code}','transport\TransportVehicleSetupController@InsertVehicleMaster');
	    Route::post('/transport/transport_vehicle_setup/UpdateVehicleMaster/{role_code}','transport\TransportVehicleSetupController@UpdateVehicleMaster');
	    Route::get('/transport/transport_vehicle_setup/DeleteVehicleMaster/{role_code}','transport\TransportVehicleSetupController@DeleteVehicleMaster');
	    Route::get('/transport/transport_vehicle_setup/GetExitTypeSelectize/{role_code}','transport\TransportVehicleSetupController@GetExitTypeSelectize');
	    Route::get('/transport/transport_vehicle_setup/GetExitReasonSelectize/{role_code}','transport\TransportVehicleSetupController@GetExitReasonSelectize');
	    Route::post('/transport/transport_vehicle_setup/InsertExitVehicleMaster/{role_code}','transport\TransportVehicleSetupController@InsertExitVehicleMaster');
	    //Setup/Master-2/Exit Type Tab-2
	    Route::post('/transport/transport_vehicle_setup/InsertExitType/{role_code}','transport\TransportVehicleSetupController@InsertExitType');
	    Route::post('/transport/transport_vehicle_setup/UpdateExitType/{role_code}','transport\TransportVehicleSetupController@UpdateExitType');
	    Route::get('/transport/transport_vehicle_setup/DeleteExitType/{role_code}','transport\TransportVehicleSetupController@DeleteExitType');
	    //Setup/Master-2/Exit Reason Tab-3
	    Route::post('/transport/transport_vehicle_setup/InsertExitReason/{role_code}','transport\TransportVehicleSetupController@InsertExitReason');
	    Route::post('/transport/transport_vehicle_setup/UpdateExitReason/{role_code}','transport\TransportVehicleSetupController@UpdateExitReason');
	    Route::get('/transport/transport_vehicle_setup/DeleteExitReason/{role_code}','transport\TransportVehicleSetupController@DeleteExitReason');
	    //Setup/Master-2/Statutory Expense Tab-4
	    Route::get('/transport/transport_vehicle_setup/GetStatutoryExpenseDataTable/{role_code}','transport\TransportVehicleSetupController@GetStatutoryExpenseDataTable');
	    Route::get('/transport/transport_vehicle_setup/GetStatutoryExpenseTypeSelectize/{role_code}','transport\TransportVehicleSetupController@GetStatutoryExpenseTypeSelectize');
	    Route::post('/transport/transport_vehicle_setup/InsertStatutoryExpense/{role_code}','transport\TransportVehicleSetupController@InsertStatutoryExpense');
	    Route::post('/transport/transport_vehicle_setup/UpdateStatutoryExpense/{role_code}','transport\TransportVehicleSetupController@UpdateStatutoryExpense');
	    Route::get('/transport/transport_vehicle_setup/DeleteStatutoryExpense/{role_code}','transport\TransportVehicleSetupController@DeleteStatutoryExpense');
	    //Setup/Master-2/Fuel Station Tab-5
	    Route::get('/transport/transport_vehicle_setup/GetFuelStationDataTable/{role_code}','transport\TransportVehicleSetupController@GetFuelStationDataTable');
	    Route::post('/transport/transport_vehicle_setup/InsertFuelStation/{role_code}','transport\TransportVehicleSetupController@InsertFuelStation');
	    Route::post('/transport/transport_vehicle_setup/UpdateFuelStation/{role_code}','transport\TransportVehicleSetupController@UpdateFuelStation');
	    Route::get('/transport/transport_vehicle_setup/DeleteFuelStation/{role_code}','transport\TransportVehicleSetupController@DeleteFuelStation');
	    //Setup/Master-2/Driver Tab-6
	    Route::get('/transport/transport_vehicle_setup/GetDriverDataTable/{role_code}','transport\TransportVehicleSetupController@GetDriverDataTable');
	    Route::get('/transport/transport_vehicle_setup/GetDesignationSelectize/{role_code}','transport\TransportVehicleSetupController@GetDesignationSelectize');
	    Route::post('/transport/transport_vehicle_setup/InsertDriver/{role_code}','transport\TransportVehicleSetupController@InsertDriver');
	    Route::post('/transport/transport_vehicle_setup/UpdateDriver/{role_code}','transport\TransportVehicleSetupController@UpdateDriver');
	    Route::get('/transport/transport_vehicle_setup/DeleteDriver/{role_code}','transport\TransportVehicleSetupController@DeleteDriver');
	    //Setup/Master-2/SMS & Email Tab-7
	    Route::get('/transport/transport_vehicle_setup/GetSmsEmailDataTable/{role_code}','transport\TransportVehicleSetupController@GetSmsEmailDataTable');
	    Route::post('/transport/transport_vehicle_setup/InsertSmsEmail/{role_code}','transport\TransportVehicleSetupController@InsertSmsEmail');
	    Route::post('/transport/transport_vehicle_setup/UpdateSmsEmail/{role_code}','transport\TransportVehicleSetupController@UpdateSmsEmail');
	    Route::get('/transport/transport_vehicle_setup/DeleteSmsEmail/{role_code}','transport\TransportVehicleSetupController@DeleteSmsEmail');
				}
				
	});
	
	
	
});



