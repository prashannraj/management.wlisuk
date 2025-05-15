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
// Auth::routes('register'=>false,);



Route::name('')->group(function () {
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@prelogin');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});
Route::post('verify_otp', 'Auth\LoginController@verifyOtp')->name('verify.otp');

Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function () {
	Route::get('/home', 'DashboardController@main')->name('home');
	Route::get('/settings', 'DashboardController@settings')->name('settings');
	Route::post('/settings', 'DashboardController@saveSettings')->name('settings');

	Route::get('/', 'DashboardController@main')->name('home');
	Route::get('/blank', 'DashboardController@blank')->name('blank');

	Route::group(['prefix' => 'companyinfo'], function () {
		Route::get("/edit", "CompanyInfoController@edit")->name('companyinfo.edit');
		Route::put("/update/{id}", "CompanyInfoController@update")->name('companyinfo.update');
		Route::put("/update-footnote/{id}", "CompanyInfoController@updateFootnote")->name('companyinfo.update.footnote');
	});

	Route::resource("partner", "PartnerController");
	Route::get("/partner/{id}/toggle", "PartnerController@toggle")->name('partner.toggle');

    Route::resource("serviceprovider", "ServiceProviderController");
    Route::get("/serviceprovider/{id}/toggle", "ServiceProviderController@toggle")->name('serviceprovider.toggle');
    Route::get('serviceproviders/data', [ServiceProviderController::class, 'getServiceProvidersData'])->name('serviceproviders.data');


	Route::name('old.')->prefix('old')->group(function () {
		Route::get("immigrationinvoice", "OldController@indexImmigrationInvoice")->name('immigrationinvoice.index');
		Route::get("immigrationinvoice/{id}", "OldController@showImmigrationInvoice")->name('immigrationinvoice.show');
		Route::post("immigrationinvoice/sendmail/{id}", "OldController@sendEmailImmigrationInvoice")->name('immigrationinvoice.sendemail');

		Route::get("generalinvoice", "OldController@indexGeneralInvoice")->name('generalinvoice.index');
		Route::get("generalinvoice/{id}", "OldController@showGeneralInvoice")->name('generalinvoice.show');
		Route::post("generalinvoice/sendmail/{id}", "OldController@sendEmailGeneralInvoice")->name('generalinvoice.sendemail');
	});


	Route::name('delete.')->prefix('delete')->group(function () {
		Route::get("/", "DeleteController@index")->name('index');
		Route::get("clients", "DeleteController@clients")->name('clients');
		Route::get("employees", "DeleteController@employees")->name('employees');
		Route::get("visas", "DeleteController@visas")->name('visas');
		Route::get("passports", "DeleteController@passports")->name('passports');
	});


	Route::resource("companybranch", 'CompanyBranchController');
	Route::resource("companydocument", "CompanyDocumentController");
	Route::resource("communicationlog", "CommunicationLogController")->only('show', 'destroy', 'index');
	Route::resource("advisor", "AdvisorController");
	Route::resource("servicefee", "ServicefeeController");
	Route::resource('user', "UserController");



	Route::resource('employee', "EmployeeController");
	Route::get("employee/{id}/restore", "EmployeeController@restore")->name('employee.restore');

	Route::resource('employeecontact', "EmployeeContactDetailController")->only(['store', 'edit', 'update']);
	Route::resource('employeeaddress', "EmployeeAddressController")->only(['store', 'edit', 'update']);
	Route::resource('employeeemergency', "EmployeeEmergencyContactController")->only(['store', 'edit', 'update']);
	Route::resource('enquiryform', "EnquiryFormController");

	Route::resource('employmentinfo', "EmploymentInfoController")->only(['show', 'store', 'edit', 'update']);
	Route::get("employmentinfo/create/{id}", "EmploymentInfoController@create")->name("employmentinfo.create");

	Route::resource("passportdetail", "PassportDetailController")->except(['index']);
	Route::get("passportdetail/{id}/restore", "PassportDetailController@restore")->name('passportdetail.restore');

	Route::resource("visa", "VisaController")->except(['index']);
	Route::get("visa/{id}/toggle", "VisaController@toggle")->name('visa.toggle');

	Route::get("visa/{id}/restore", "VisaController@restore")->name('visa.restore');
	Route::delete('delete-ukvisa', 'VisaController@destroyUkvisa')->name('ukvisa.destroy');

	Route::resource("payslip", "PaySlipController")->except(['index', 'create']);
	Route::get('payslip/create/{id}', "PaySlipController@create")->name('payslip.create');
	Route::get('payslip/email/{id}', "PaySlipController@email")->name('payslip.email');

	Route::resource("p4560", "P5060Controller")->except(['index', 'create']);
	Route::get('p4560/create/{id}', "P5060Controller@create")->name('p4560.create');
	Route::get('p4560/email/{id}', "P5060Controller@email")->name('p4560.email');

	Route::resource("employeedocument", "EmployeeDocumentController")->except(['index']);

	//Raw Inquiry
	Route::resource("rawenquiry", "RawInquiryController");
	Route::get("rawenquiry/toggle/{id}", "RawInquiryController@toggle")->name('rawenquiry.toggle');
	Route::post('rawenquiry/{id}/add-note', 'RawInquiryController@addNote')->name('rawenquiry.add-note');
	Route::get("rawenquiry/process/{id}", "RawInquiryController@process")->name('rawenquiry.process');
	Route::post("rawenquiry/process/{id}", "RawInquiryController@storeToEnquiry")->name('rawenquiry.process');

	//notifications
	Route::resource("notification", "NotificationController")->only("show", "index");
	Route::get("prepareNotifications", "NotificationController@prepareNotifications");
	Route::get("/notif/delete/{id}", "NotificationController@deleteNotification")->name('delete.notification');


	//attendance notes
	Route::get("attendancenote/{id}/create", "AttendanceNoteController@create")->name("attendancenote.create");
	Route::get("attendancenote/{id}/edit", "AttendanceNoteController@edit")->name("attendancenote.edit");

	Route::post("attendancenote/{id}/create", "AttendanceNoteController@store")->name("attendancenote.store");
	Route::put("attendancenote/{id}/edit", "AttendanceNoteController@update")->name("attendancenote.update");

	Route::get("attendancenote/{id}", "AttendanceNoteController@show")->name("attendancenote.show");
	Route::delete("attendancenote/{id}", "AttendanceNoteController@destroy")->name("attendancenote.destroy");

	Route::name('report.')->prefix('report')->group(function () {
		Route::get('/invoice', "ReportController@index")->name('invoice');
		Route::get('/receipt', "ReportController@indexReceipt")->name('receipt');
		Route::get('/imm_applications', "ReportController@indexImmigration")->name('immigration');
		Route::get('/clients', "ReportController@indexClient")->name('client');
		Route::get('/visas', "ReportController@indexVisa")->name('visa');
	});

	Route::name('finance.')->group(function () {
		Route::resource("invoice", "InvoiceController");
		Route::resource("bank", "BankController")->except(['destroy']);
		Route::resource('receipt', "ReceiptController");
		//invoice
		Route::get("/pdf/{id}/invoice", "InvoiceController@downloadPdf");
		Route::get("/invoice/generate/{id}", "InvoiceController@generateDocument")->name('invoice.generate');
		Route::post("/invoice/sendmail/{id}", "InvoiceController@sendEmail")->name('invoice.sendemail');
		Route::resource('invoiceitem', "InvoiceItemController")->only(['store', 'update', 'destroy']);

		//receipt
		Route::get("/pdf/{id}/receipt", "ReceiptController@downloadPdf");
		Route::put("/receipt/{id}/inv", "ReceiptController@updateFromInvoice")->name('receipt.updateFromInvoice');
		Route::get("/receipt/generate/{id}", "ReceiptController@generateDocument")->name('receipt.generate');
		Route::post("/receipt/sendmail/{id}", "ReceiptController@sendEmail")->name('receipt.sendemail');
	});

	Route::prefix("ajax")->group(function () {
		Route::get('/clients', "ClientController@ajaxindex");
		Route::get('/visa/{id}', "VisaController@ajaxShow");

		Route::get('/enquiries', "EnquiryController@ajaxindex")->name("ajax.enquiry.index");
		Route::get('/invoices', "InvoiceController@ajaxindex");
		Route::get('/servicefees', "ServicefeeController@ajaxindex")->name('ajax.servicefee.index');
		Route::get('/partners', "PartnerController@ajaxindex")->name('ajax.partner.index');
        Route::get('/serviceprovider', [ServiceProviderController::class, 'ajaxIndex'])->name('ajax.serviceprovider.index');



		Route::post("/ec/{id}/content", "PreviewController@contentEc")->name('ajax.content.ec');
		Route::post("/loa/{id}/content", "PreviewController@contentLoa")->name('ajax.content.loa');
	});

	Route::get("/get-company-document/{file}", "CompanyDocumentController@getDownload")->name('companydocumenturl');

	Route::get("/get-file-document/{file}", "EnquiryFormController@getDownload")->name('enquirydocumenturl');

	// Enquiry
	Route::group(['prefix' => 'enquiry',], function () {
		Route::get('/', ['as' => 'enquiry.list', 'uses' => 'EnquiryController@index']);
		Route::get('/datatable', ['as' => 'enquiry.data', 'uses' => 'EnquiryController@datatable']);
		Route::get('/status', ['as' => 'enquiry.status', 'uses' => 'EnquiryController@status']);
		Route::get('/add', ['as' => 'enquiry.create', 'uses' => 'EnquiryController@create']);
		Route::post('/save', ['as' => 'enquiry.save', 'uses' => 'EnquiryController@store']);
		Route::post('/update-enquiry-status', ['as' => 'enquiry.postStatusUpdate', 'uses' => 'EnquiryController@statusUpdate']);
		Route::get('/{id}/show', ['as' => 'enquiry.show', 'uses' => 'EnquiryController@show']);
		Route::post('/{id}/show', ['as' => 'enquiry.unlink', 'uses' => 'EnquiryController@unlink']);

		Route::get('/{id}/log', ['as' => 'enquiry.log', 'uses' => 'EnquiryController@indexLog']);
		Route::get('/log/{lid}', ['as' => 'enquiry.show.log', 'uses' => 'EnquiryController@showLog']);
		Route::post('/{id}/log', ['as' => 'enquiry.store.log', 'uses' => 'EnquiryController@storeLog']);
		Route::delete('/{id}/log', ['as' => 'enquiry.destroy.log', 'uses' => 'EnquiryController@destroyLog']);
		Route::put('/{id}/log', ['as' => 'enquiry.update.log', 'uses' => 'EnquiryController@updateLog']);


		Route::post('/status/{id}/update', ['as' => 'enquiry.statusUpdate', 'uses' => 'EnquiryController@statusUpdate']);
		Route::get('/{id}/edit', ['as' => 'enquiry.edit', 'uses' => 'EnquiryController@edit']);
		Route::put('/{id}/update', ['as' => 'enquiry.update', 'uses' => 'EnquiryController@update']);
		Route::delete('/{id}/delete', ['as' => 'enquiry.delete', 'uses' => 'EnquiryController@destroy']);

		Route::post("/{id}/clientcare", "EnquiryController@clientCare")->name('enquiry.clientcare');
		Route::get("/{id}/clientcare", "EnquiryController@showClientCare")->name('enquiry.clientcare');
        Route::post('/enquiry/clientcare/{id}/save', [EnquiryController::class, 'saveClientCare'])->name('enquiry.clientcare.save');
        Route::get('/load-client-care/{id}', [EnquiryController::class, 'loadClientCare'])->name('load.clientcare');

        Route::post("/{id}/cclapplication", "EnquiryController@cclApplication")->name('enquiry.cclapplication');
		Route::get("/{id}/cclapplication", "EnquiryController@showCclApplication")->name('enquiry.cclapplication');
        Route::post('/enquiry/cclapplication/{id}/save', [EnquiryController::class, 'saveCclApplication'])->name('enquiry.clientcare.save');
        Route::get('/load-ccl-application/{id}', [EnquiryController::class, 'loadCclApplication'])->name('load.cclapplication');

        Route::get('/enquiry/{id}/load-data', [EnquiryController::class, 'loadClientCareData']);

		Route::get("/{id}/enquirycare", "EnquiryController@showEnquiryCare")->name('enquiry.enquirycare');
		Route::post("/{id}/enquirycare", "EnquiryController@enquiryCare")->name('enquiry.enquirycare');

        Route::get("/{id}/letterofauthority", "EnquiryController@showLetterOfAuthority")->name('enquiry.letterofauthority');
		Route::post("/{id}/letterofauthority", "EnquiryController@letterOfAuthority")->name('enquiry.letterofauthority');
        Route::post('/loa/load-content/{id}', [EnquiryController::class, 'loadContent'])->name('ajax.load.loa');


        Route::get("/{id}/lettertofirm", "EnquiryController@showLetterToFirm")->name('enquiry.lettertofirm');
		Route::post("/{id}/lettertofirm", "EnquiryController@letterToFirm")->name('enquiry.lettertofirm');

        Route::get("/{id}/requesttomedical", "EnquiryController@showRequestToMedical")->name('enquiry.requesttomedical');
		Route::post("/{id}/requesttomedical", "EnquiryController@requestToMedical")->name('enquiry.requesttomedical');

        Route::get("/{id}/requesttofinance", "EnquiryController@showRequestToFinance")->name('enquiry.requesttofinance');
		Route::post("/{id}/requesttofinance", "EnquiryController@requestToFinance")->name('enquiry.requesttofinance');

        Route::get("/{id}/requesttotrbunal", "EnquiryController@showRequestToTrbunal")->name('enquiry.requesttotrbunal');
		Route::post("/{id}/requesttotrbunal", "EnquiryController@requestToTrbunal")->name('enquiry.requesttotrbunal');

        Route::get("/{id}/subjectaccess", "EnquiryController@showSubjectAccess")->name('enquiry.subjectaccess');
		Route::post("/{id}/subjectaccess", "EnquiryController@subjectAccess")->name('enquiry.subjectaccess');

        Route::get("/{id}/fileopeningform", "EnquiryController@showFileOpeningForm")->name('enquiry.fileopeningform');
		Route::post("/{id}/fileopeningform", "EnquiryController@fileOpeningForm")->name('enquiry.fileopeningform');

        Route::get("/{id}/clientofauthority", "EnquiryController@showClientOfAuthority")->name('enquiry.clientofauthority');
		Route::post("/{id}/clientofauthority", "EnquiryController@clientOfAuthority")->name('enquiry.clientofauthority');

        Route::get("/{id}/lteccl", "EnquiryController@showLteCcl")->name('enquiry.lteccl');
		Route::post("/{id}/lteccl", "EnquiryController@lteCcl")->name('enquiry.lteccl');

        Route::get("/{id}/newccl", "EnquiryController@showNewCcl")->name('enquiry.newccl');
		Route::post("/{id}/newccl", "EnquiryController@newCcl")->name('enquiry.newccl');

	});




	Route::group(['prefix' => 'client',], function () {
		Route::get('/', ['as' => 'client.list', 'uses' => 'ClientController@index']);
		Route::get('/{id}/edit', ['as' => 'edit.basic_info', 'uses' => 'ClientController@editBasicInfo']);
		Route::put('update/{id}/client', ['as' => 'client.updateBasicInfo', 'uses' => 'ClientController@updateBasicInfo']);
		Route::get('/{id}/dashboard', ['as' => 'client.show', 'uses' => 'ClientController@show']);
		Route::get('/{id}/show', ['as' => 'client.view', 'uses' => 'ClientController@view']);
		Route::post('/{id}/dashboard', ['as' => 'client.show', 'uses' => 'ClientController@addEnquiry']);
		Route::delete('/{id}/show', ['as' => 'client.destroy', 'uses' => 'ClientController@destroy']);
		Route::delete('/{id}/delete-permanently', ['as' => 'client.delete-permanently', 'uses' => 'ClientController@deletePermanently']);
		Route::get('/{id}/restore', ['as' => 'client.restore', 'uses' => 'ClientController@restore']);


		Route::get('/enquiry/{id}/dashboard', ['as' => 'enquiry.dashboard', 'uses' => 'ClientController@enquiryToClient']);

		Route::post('/addbasicinfo', ['as' => 'client.addbasicinfo', 'uses' => 'ClientController@addBasicInfo']);

		Route::post('/store-passport', ['as' => 'client.store.passport', 'uses' => 'ClientController@storePassport']);
		Route::post('/save-student-contact', ['as' => 'client.studentContactDetailsAdd', 'uses' => 'ClientController@addStudentContactDetail']);
		Route::get('/edit-address/{id}', ['as' => 'edit.address', 'uses' => 'ClientController@editClientAddress']);
		Route::put('/update-address/{id}', ['as' => 'update.client.address', 'uses' => 'ClientController@updateClientAddress']);
		Route::get('/edit-emergency/{id}', ['as' => 'edit.emergency', 'uses' => 'ClientController@editClientEmergency']);
		Route::put('/update-emergency/{id}', ['as' => 'update.client.emergency', 'uses' => 'ClientController@updateClientEmergency']);
		Route::get('/edit-contact/{id}', ['as' => 'edit.contact', 'uses' => 'ClientController@editClientCurrentContact']);
		Route::put('/update-contact/{id}', ['as' => 'update.client.contact', 'uses' => 'ClientController@updateClientCurrentContact']);
		Route::delete('/delete-contact/{id}', ['as' => 'delete.contact', 'uses' => 'ClientController@deleteCurrentContact']);
		Route::delete('/delete-emergency/{id}', ['as' => 'delete.emergency', 'uses' => 'ClientController@deleteEmergency']);
		Route::delete('/delete-address/{id}', ['as' => 'delete.address', 'uses' => 'ClientController@deleteAddress']);

		Route::post('/save-client-address', ['as' => 'client.studentAddressAdd', 'uses' => 'ClientController@addStudentAddressDetail']);
		Route::post('/save-client-emergency', ['as' => 'client.studentEmergencyAdd', 'uses' => 'ClientController@addStudentEmergencyDetail']);

		Route::get('/add-passport/{id}', ['as' => 'client.add.passport', 'uses' => 'ClientController@addPassportDetail']);
		Route::get('/edit-passport/{id}', ['as' => 'client.edit.passport', 'uses' => 'ClientController@editPassportDetail']);
		Route::get('/show-passport/{id}', ['as' => 'client.show.passport', 'uses' => 'ClientController@showPassportDetail']);
		Route::put('/update-passport/{id}', ['as' => 'client.update.passport', 'uses' => 'ClientController@updatePassport']);

		Route::get('/add-cvisa/{id}', ['as' => 'client.add.visa', 'uses' => 'ClientController@addVisaDetail']);
		Route::get('/show-visa/{id}', ['as' => 'client.show.visa', 'uses' => 'ClientController@showVisaDetail']);
		Route::post('/store-visa', ['as' => 'client.store.visa', 'uses' => 'ClientController@storeVisa']);
		Route::get('/edit-cvisa/{id}', ['as' => 'client.edit.visa', 'uses' => 'ClientController@editVisaDetail']);
		Route::put('/update-cvisa/{id}', ['as' => 'client.update.visa', 'uses' => 'ClientController@updateVisa']);

		Route::get('/add-ukvisa/{id}', ['as' => 'client.add.ukvisa', 'uses' => 'ClientController@addUkVisaDetail']);
		Route::post('/store-ukvisa', ['as' => 'client.store.ukvisa', 'uses' => 'ClientController@storeUkVisa']);
		Route::get('/edit-ukvisa/{id}', ['as' => 'client.edit.ukvisa', 'uses' => 'ClientController@editUkVisaDetail']);
		Route::put('/update-ukvisa/{id}', ['as' => 'client.update.ukvisa', 'uses' => 'ClientController@updateUkVisa']);

		Route::get('/document', ['as' => 'client.document', 'uses' => 'ClientDocumentController@listDocument']);
		Route::get('/document/{id}', ['as' => 'client.add.document', 'uses' => 'ClientDocumentController@addDocument']);
		Route::post('/store-document', ['as' => 'client.store.document', 'uses' => 'ClientDocumentController@storeDocument']);
		Route::post('/store-documents', ['as' => 'client.store.documents', 'uses' => 'ClientDocumentController@storeDocuments']);

		Route::get('/edit-document/{id}', ['as' => 'client.edit.document', 'uses' => 'ClientDocumentController@editDocument']);
		Route::put('/update-document/{id}', ['as' => 'client.update.document', 'uses' => 'ClientDocumentController@updateDocument']);
		Route::delete('/delete-document/{id}', ['as' => 'client.delete.document', 'uses' => 'ClientDocumentController@deleteDocument']);
		Route::delete('/document/{id}', 'ClientDocumentController@destroy')->name('document.destroy');

		Route::get('/application/immigration/{basic_info_id}', ['as' => 'client.add.application.immigration', 'uses' => 'ApplicationController@addImmigration']);
		// Route::get('/application/immigration/{id}/edit', ['as' => 'client.add.document', 'uses' => 'ClientDocumentController@addDocument']);
		Route::post('/store-immigration-application', ['as' => 'client.store.application.immigration', 'uses' => 'ApplicationController@storeImmigration']);
		Route::get('/application/edit-immigration/{id}', ['as' => 'client.edit.application.immigration', 'uses' => 'ApplicationController@editImmigration']);
		Route::delete('/application/delete-immigration', ['as' => 'client.delete.application.immigration', 'uses' => 'ApplicationController@destroy']);

		//get all application logs
		Route::get('/application/immigration/{id}/logs', ['as' => 'client.list.application.immigration.logs', 'uses' => 'ApplicationController@applicationImmigrationLogs']);
		//add new application log
		Route::post('/application/immigration/{id}/storelogs', ['as' => 'client.list.application.immigration.store,logs', 'uses' => 'ApplicationController@storeApplicationImmigrationLogs']);
		Route::get('/application/immigration/process/view/{id}', ['as' => 'client.application.view.immigration.process', 'uses' => 'ApplicationController@viewApplicationImmigrationProcess']);

		Route::put('/application/immigration/process/update/{id}', ['as' => 'client.application.update.immigration.process', 'uses' => 'ApplicationController@updateApplicationImmigrationProcess']);
		Route::put('/application/immigration/process/delete/{id}', ['as' => 'client.application.delete.immigration.process', 'uses' => 'ApplicationController@deleteApplicationImmigrationProcess']);

		Route::put('/immigration/update-application/{id}', ['as' => 'client.update.immigration', 'uses' => 'ApplicationController@updateImmigration']);

		Route::post("application/immigration/process/email", "ApplicationController@emailApplicationImmigrationProcess")->name('client.application.email.immigration.process');

		//Admission

		Route::get('/application/admission/{basic_info_id}', ['as' => 'client.add.application.admission', 'uses' => 'AdmissionApplicationController@create']);
		// Route::get('/application/immigration/{id}/edit', ['as' => 'client.add.document', 'uses' => 'ClientDocumentController@addDocument']);
		Route::post('/store-admission-application', ['as' => 'client.store.application.admission', 'uses' => 'AdmissionApplicationController@store']);
		Route::get('/application/edit-admission/{id}', ['as' => 'client.edit.application.admission', 'uses' => 'AdmissionApplicationController@edit']);
		Route::put('/admission/update-application/{id}', ['as' => 'client.update.admission', 'uses' => 'AdmissionApplicationController@update']);
		Route::delete('/application/delete-admission', ['as' => 'client.delete.application.admission', 'uses' => 'AdmissionApplicationController@destroy']);

		Route::get('/application/immigration-appeal/{basic_info_id}', ['as' => 'client.add.application.immigrationappeal', 'uses' => 'ImmigrationAppealController@addImmigrationAppeal']);
		Route::get('/application/edit-immigration-appeal/{id}', ['as' => 'client.edit.application.immigrationappeal', 'uses' => 'ImmigrationAppealController@editImmigrationAppeal']);
		Route::put('/application/immigration-appeal/update-application/{id}', ['as' => 'client.update.immigration-appeal', 'uses' => 'ImmigrationAppealController@updateImmigrationAppeal']);

		//add new application log
		Route::get('/application/immigration-appeal/{id}/logs', ['as' => 'client.list.immigration-appeal.logs', 'uses' => 'ImmigrationAppealController@immigrationAppealLogs']);
		Route::post('/application/immigration-appeal/{id}/storelogs', ['as' => 'client.list.application.immigration-appeal.storelogs', 'uses' => 'ImmigrationAppealController@storeImmigrationAppealLogs']);
		Route::get('/application/immigration-appeal/process/view/{id}', ['as' => 'client.application.view.immigration-appeal.process', 'uses' => 'ImmigrationAppealController@viewApplicationImmigrationProcess']);
		Route::put('/application/immigration-appeal/process/update/{id}', ['as' => 'client.application.update.immigration-appeal.process', 'uses' => 'ImmigrationAppealController@updateApplicationImmigrationProcess']);
		Route::put('/application/immigration-appeal/process/delete/{id}', ['as' => 'client.application.delete.immigration-appeal.process', 'uses' => 'ImmigrationAppealController@deleteApplicationImmigrationProcess']);

		// Route::get('/application/immigration-appeal/process/view/{id}', ['as' => 'client.application.view.immigration.process', 'uses' => 'ApplicationController@viewApplicationImmigrationProcess']);

		// Route::put('/application/immigration-appeal/process/update/{id}', ['as' => 'client.application.update.immigration.process', 'uses' => 'ApplicationController@updateApplicationImmigrationProcess']);
		// Route::put('/application/immigration-appeal/process/delete/{id}', ['as' => 'client.application.delete.immigration.process', 'uses' => 'ApplicationController@deleteApplicationImmigrationProcess']);


		Route::post('/store-immigration-appeal-application', ['as' => 'client.store.application.immigration-appeal', 'uses' => 'ImmigrationAppealController@storeImmigrationAppeal']);

		//Admission
		// Route::get('/application/immigration-appeal/{basic_info_id}', ['as' => 'client.add.application.immigrationappeal', 'uses' => 'ImmigrationAppealApplicationController@create']);
		// Route::get('/application/immigration/{id}/edit', ['as' => 'client.add.document', 'uses' => 'ClientDocumentController@addDocument']);
		// Route::post('/store-admission-application', ['as' => 'client.store.application.admission', 'uses' => 'AdmissionApplicationController@store']);
		// Route::get('/application/edit-admission/{id}', ['as' => 'client.edit.application.admission', 'uses' => 'AdmissionApplicationController@edit']);
		// Route::put('/admission/update-application/{id}', ['as' => 'client.update.admission', 'uses' => 'AdmissionApplicationController@update']);
		// Route::delete('/application/delete-admission', ['as' => 'client.delete.application.admission', 'uses' => 'AdmissionApplicationController@destroy']);

		//get all application logs
		Route::get('/application/admission/{id}/logs', ['as' => 'client.list.application.admission.logs', 'uses' => 'AdmissionApplicationController@applicationLogs']);
		//add new application log
		Route::get('/application/admission/process/view/{id}', ['as' => 'client.application.view.admission.process', 'uses' => 'AdmissionApplicationController@showApplicationProcess']);

		Route::post('/application/admission/{id}/storelogs', ['as' => 'client.list.application.admission.store,logs', 'uses' => 'AdmissionApplicationController@storeApplicationLogs']);
		Route::put('/application/admission/process/update/{id}', ['as' => 'client.application.update.admission.process', 'uses' => 'AdmissionApplicationController@updateApplicationProcess']);
		Route::put('/application/admission/process/delete/{id}', ['as' => 'client.application.delete.admission.process', 'uses' => 'AdmissionApplicationController@deleteApplicationProcess']);

		Route::post("application/admission/process/email", "AdmissionApplicationController@email")->name('client.application.email.admission.process');


		// Admission end
		//document Url
		Route::get("/get-document/{file}", "ApplicationController@getDownload")->name('documenturl');
		Route::get("/get-file/{file}", "ApplicationController@getFile")->name('fileurl');
	});


	Route::name("application.")->prefix('applications')->group(function () {
		Route::get("admission", "AdmissionApplicationController@index")->name('admission.index');

		Route::get("immigration", "ApplicationController@index")->name('immigration.index');
	});

	Route::name("additionaldocument.")->prefix("additionaldocument")->group(function () {
		Route::get("create/loa/{id}", "AdditionalDocumentController@createLoa")->name('loa.create');
		Route::post("create/loa/{id}", "AdditionalDocumentController@storeLoa")->name('loa.store');
		Route::get("create/loc/{id}", "AdditionalDocumentController@createloc")->name('loc.create');
		Route::post("create/loc/{id}", "AdditionalDocumentController@storeloc")->name('loc.store');
		Route::get("create/fof/{id}", "AdditionalDocumentController@createfof")->name('fof.create');
		Route::post("create/fof/{id}", "AdditionalDocumentController@storefof")->name('fof.store');
		Route::get("create/rel/{id}", "AdditionalDocumentController@createrel")->name('rel.create');
		Route::post("create/rel/{id}", "AdditionalDocumentController@storerel")->name('rel.store');

		Route::get("create/spd/{id}", "AdditionalDocumentController@createspd")->name('spd.create');
		Route::post("create/spd/{id}", "AdditionalDocumentController@storespd")->name('spd.store');

		Route::get("create/apd/{id}", "AdditionalDocumentController@createapd")->name('apd.create');
		Route::post("create/apd/{id}", "AdditionalDocumentController@storeapd")->name('apd.store');


		Route::get("create/coe/{id}", "AdditionalDocumentController@createcoe")->name('coe.create');
		Route::post("create/coe/{id}", "AdditionalDocumentController@storecoe")->name('coe.store');

		Route::get("create/ec/{id}", "AdditionalDocumentController@createec")->name('ec.create');
		Route::post("create/ec/{id}", "AdditionalDocumentController@storeec")->name('ec.store');


		Route::get("create/nok/{id}", "AdditionalDocumentController@createnok")->name('nok.create');
		Route::post("create/nok/{id}", "AdditionalDocumentController@storenok")->name('nok.store');


		Route::get("create/eci/{id}", "AdditionalDocumentController@createeci")->name('eci.create');
		Route::post("create/eci/{id}", "AdditionalDocumentController@storeeci")->name('eci.store');


		Route::get("create/eicl/{id}", "AdditionalDocumentController@createeicl")->name('eicl.create');
		Route::post("create/eicl/{id}", "AdditionalDocumentController@storeeicl")->name('eicl.store');
	});


	Route::get("aacl/{id}", "CoverLetterController@create")->name('aacl.create');
	Route::post("aacl/{id}", "CoverLetterController@store")->name('aacl.store');


	Route::name("application_assessment.")->prefix("application_assessment")->group(function () {
		Route::get("create/{id}", "ApplicationAssessmentController@create")->name('create');
		Route::post("create/{id}", "ApplicationAssessmentController@store")->name('store');
		Route::get("edit/{id}", "ApplicationAssessmentController@edit")->name('edit');
		Route::put("edit/{id}", "ApplicationAssessmentController@update")->name('update');
		Route::get("/{id}", "ApplicationAssessmentController@show")->name('show');
		Route::delete("/{id}", "ApplicationAssessmentController@destroy")->name('destroy');
		Route::post("/{id}", "ApplicationAssessmentController@uploadFiles")->name('uploadfiles');
		Route::post("/{id}/updateStatus", "ApplicationAssessmentController@updateStatus")->name("updateStatus");
		Route::post("/{id}/toggle", "ApplicationAssessmentController@toggle")->name("toggle");
	});

	Route::get("financial_assessment/{id}", "ApplicationAssessmentController@showFinancial")->name('financial_assessment.show');
	Route::post("financial_assessment/{id}", "ApplicationAssessmentController@generateFinancial")->name('financial_assessment.generate');


	Route::name("application_assessment_file.")->prefix("application_assessment_file")->group(function () {
		Route::get('preview/{id}', "ApplicationAssessmentFileController@preview")->name('preview');
		Route::put("update/{id}", "ApplicationAssessmentFileController@update")->name('update');
		Route::delete("/{id}", "ApplicationAssessmentFileController@destroy")->name('destroy');
	});

	Route::name("assessment_section.")->prefix("assessment_section")->group(function () {
		Route::post('create/{id}', "AssessmentSectionController@store")->name('store');
		Route::post('{id}', "AssessmentSectionController@update")->name('update');

		Route::delete("/{id}", "AssessmentSectionController@destroy")->name('destroy');
		Route::post("/{id}/toggle", "AssessmentSectionController@toggle")->name("toggle");
	});

	Route::name("employment_detail.")->prefix("employment_detail")->group(function () {
		Route::get("/{id}", "ApplicantEmploymentInfoController@show")->name('show');
		Route::post('/{id}', "ApplicantEmploymentInfoController@update")->name('update');
		Route::post('create/{id}', "ApplicantEmploymentInfoController@store")->name('store');
		Route::delete("/{id}", "ApplicantEmploymentInfoController@destroy")->name('destroy');
		Route::post("/{id}/toggle", "ApplicantEmploymentInfoController@toggle")->name("toggle");
	});

	Route::name("applicantpayslip.")->prefix("applicantpayslip")->group(function () {
		Route::get("/{id}", "ApplicantPayslipController@show")->name('show');
		Route::post('create/{id}', "ApplicantPayslipController@store")->name('store');
		Route::post('import/{id}', "ApplicantPayslipController@import")->name('import');

		Route::get('edit/{id}', "ApplicantPayslipController@edit")->name('edit');
		Route::post('edit/{id}', "ApplicantPayslipController@update")->name('update');

		Route::delete("/{id}", "ApplicantPayslipController@destroy")->name('destroy');
		Route::get("/{id}/toggle", "ApplicantPayslipController@toggle")->name("toggle");
	});


	Route::name("applicantsavinginfo.")->prefix("applicantsavinginfo")->group(function () {
		Route::get("edit/{id}", "ApplicantSavingInfoController@edit")->name('edit');
		Route::post('edit/{id}', "ApplicantSavingInfoController@update")->name('update');

		Route::post('create/{id}', "ApplicantSavingInfoController@store")->name('store');
		Route::delete("/{id}", "ApplicantSavingInfoController@destroy")->name('destroy');
		// Route::post("/{id}/toggle","ApplicantSavingInfo@toggle")->name("toggle");

	});


	Route::resource("template", "TemplateController");


	Route::get("/test", "DashboardController@test");
	Route::resource('emailSenders', 'EmailSenderController');

	Route::resource('cpds', 'CpdController');

	Route::resource('cpdDetails', 'CpdDetailController')->only(["store","update",'destroy','show']);
	Route::post("cpdDetails/import","CpdDetailController@import")->name('cpdDetails.import');

	// Generator

	Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
	Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');
	Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');
	Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');
	Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');
	Route::post('generator_builder/generate-from-file', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile')->name('io_generator_builder_generate_from_file');


	Route::post('visaexpiry-email',"VisaController@sendEmail")->name('send.visaexpiry.email');

	Route::name("massemail.")->group(function(){
		Route::get("send-emails","CompanyInfoController@sendEmails");
		Route::post("send-emails","CompanyInfoController@postSendEmails")->name("send");
	});
});

// routes/web.php
Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload.image');
Route::get("/storage/{file}", "HomeController@getDownload")->name('storageurl');
Route::get("housekeeping", "HomeController@work");


