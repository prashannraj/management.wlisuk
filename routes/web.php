<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\ServiceProviderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyInfoController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\AdditionalDocumentController;
use App\Http\Controllers\Admin\AdmissionApplicationController;
use App\Http\Controllers\Admin\AdvisorController;
use App\Http\Controllers\Admin\ApplicantEmploymentInfoController;
use App\Http\Controllers\Admin\ApplicantPayslipController;
use App\Http\Controllers\Admin\AttendanceNoteController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CompanyBranchController;
use App\Http\Controllers\Admin\CompanyDocumentController;
use App\Http\Controllers\Admin\CommunicationLogController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EmployeeAddressController;
use App\Http\Controllers\Admin\EmployeeContactDetailController;
use App\Http\Controllers\Admin\EmployeeDocumentController;
use App\Http\Controllers\Admin\EmployeeEmergencyContactController;
use App\Http\Controllers\Admin\EnquiryFormController;
use App\Http\Controllers\Admin\PassportDetailController;
use App\Http\Controllers\Admin\EmploymentInfoController;
use App\Http\Controllers\Admin\ImmigrationAppealController;
use App\Http\Controllers\Admin\ImmigrationAppealApplicationController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OldController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PaySlipController;
use App\Http\Controllers\Admin\P5060Controller;
use App\Http\Controllers\Admin\PreviewController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServicefeeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisaController;
use App\Http\Controllers\Admin\VisaApplicationController;
use App\Http\Controllers\Admin\VisaApplicationProcessController;
use App\Http\Controllers\Admin\VisaApplicationProcessLogController;
use App\Http\Controllers\Admin\VisaApplicationProcessStatusController;
use App\Http\Controllers\Admin\VisaApplicationProcessStatusLogController;
use App\Http\Controllers\Admin\RawInquiryController;
use App\Http\Controllers\Admin\InvoiceItemController;
use App\Http\Controllers\Admin\ClientController;


use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\EnquiryCareController;
use App\Http\Controllers\FinancialAssessmentDocumentController;
use App\Models\Employee;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

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
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'prelogin']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});
Route::post('verify_otp', [LoginController::class, 'verifyOtp'])->name('verify.otp');
Route::middleware('admin')->group(function () {
	Route::get('/home', [DashboardController::class, 'main'])->name('home');
	Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
	Route::post('/settings', [DashboardController::class, 'saveSettings'])->name('settings');

	Route::get('/', [DashboardController::class, 'main'])->name('home');
	Route::get('/blank', [DashboardController::class, 'blank'])->name('blank');

	Route::prefix('companyinfo')->group(function () {
		Route::get("/edit", [CompanyInfoController::class, 'edit'])->name('companyinfo.edit');
		Route::put("/update/{id}", [CompanyInfoController::class, 'update'])->name('companyinfo.update');
		Route::put("/update-footnote/{id}", [CompanyInfoController::class, 'updateFootnote'])->name('companyinfo.update.footnote');
	});

	Route::resource('partner', PartnerController::class);
	Route::get("/partner/{id}/toggle", [PartnerController::class, 'toggle'])->name('partner.toggle');

    Route::resource("serviceprovider", ServiceProviderController::class);
    Route::get("/serviceprovider/{id}/toggle", [ServiceProviderController::class, 'toggle'])->name('serviceprovider.toggle');
    Route::get('serviceproviders/data', [ServiceProviderController::class, 'getServiceProvidersData'])->name('serviceproviders.data');




	Route::name('old.')->prefix('old')->group(function () {
		// Immigration Invoice Routes
		Route::get("immigrationinvoice", [OldController::class, 'indexImmigrationInvoice'])->name('immigrationinvoice.index');
		Route::get("immigrationinvoice/{id}", [OldController::class, 'showImmigrationInvoice'])->name('immigrationinvoice.show');
		Route::post("immigrationinvoice/sendmail/{id}", [OldController::class, 'sendEmailImmigrationInvoice'])->name('immigrationinvoice.sendemail');

		// General Invoice Routes
		Route::get("generalinvoice", [OldController::class, 'indexGeneralInvoice'])->name('generalinvoice.index');
		Route::get("generalinvoice/{id}", [OldController::class, 'showGeneralInvoice'])->name('generalinvoice.show');
		Route::post("generalinvoice/sendmail/{id}", [OldController::class, 'sendEmailGeneralInvoice'])->name('generalinvoice.sendemail');
	});





	Route::name('delete.')->prefix('delete')->group(function () {
		Route::get('/', [DeleteController::class, 'index'])->name('index');
		Route::get('clients', [DeleteController::class, 'clients'])->name('clients');
		Route::get('employees', [DeleteController::class, 'employees'])->name('employees');
		Route::get('visas', [DeleteController::class, 'visas'])->name('visas');
		Route::get('passports', [DeleteController::class, 'passports'])->name('passports');
	});



	Route::resource("companybranch", CompanyBranchController::class);
	Route::resource("companydocument", CompanyDocumentController::class);
	Route::resource("communicationlog", CommunicationLogController::class)->only(['show', 'destroy', 'index']);
	Route::resource("advisor", AdvisorController::class);
	Route::resource("servicefee", ServicefeeController::class);
	Route::resource("user", UserController::class);


	Route::resource('employee', EmployeeController::class);
	Route::get('employee/{id}/restore', [EmployeeController::class, 'restore'])->name('employee.restore');

	Route::resource('employeecontact', EmployeeContactDetailController::class)->only(['store', 'edit', 'update']);
	Route::resource('employeeaddress', EmployeeAddressController::class)->only(['store', 'edit', 'update']);
	Route::resource('employeeemergency', EmployeeEmergencyContactController::class)->only(['store', 'edit', 'update']);
	Route::resource('enquiryform', EnquiryFormController::class);
	Route::get('/enquiryform/display/{uuid}', [EnquiryFormController::class, 'display'])->name('enquiryform.display');


	Route::resource('employmentinfo', EmploymentInfoController::class)->only(['show', 'store', 'edit', 'update']);
	Route::get('employmentinfo/create/{id}', [EmploymentInfoController::class, 'create'])->name('employmentinfo.create');

	Route::resource('passportdetail', PassportDetailController::class)->except(['index']);
	Route::get('passportdetail/{id}/restore', [PassportDetailController::class, 'restore'])->name('passportdetail.restore');

	Route::resource('visa', VisaController::class)->except(['index']);
	Route::get('visa/{id}/toggle', [VisaController::class, 'toggle'])->name('visa.toggle');
	Route::get('visa/{id}/restore', [VisaController::class, 'restore'])->name('visa.restore');
	Route::delete('delete-ukvisa', [VisaController::class, 'destroyUkvisa'])->name('ukvisa.destroy');

	Route::resource('payslip', PaySlipController::class)->except(['index', 'create']);
	Route::get('payslip/create/{id}', [PaySlipController::class, 'create'])->name('payslip.create');
	Route::get('payslip/email/{id}', [PaySlipController::class, 'email'])->name('payslip.email');

	Route::resource('p4560', P5060Controller::class)->except(['index', 'create']);
	Route::get('p4560/create/{id}', [P5060Controller::class, 'create'])->name('p4560.create');
	Route::get('p4560/email/{id}', [P5060Controller::class, 'email'])->name('p4560.email');

	Route::resource('employeedocument', EmployeeDocumentController::class)->except(['index']);


		// 🔹 Raw Inquiry
	Route::resource('rawenquiry', RawInquiryController::class);
	Route::get('rawenquiry/toggle/{id}', [RawInquiryController::class, 'toggle'])->name('rawenquiry.toggle');
	Route::post('rawenquiry/{id}/add-note', [RawInquiryController::class, 'addNote'])->name('rawenquiry.add-note');
	Route::get('rawenquiry/process/{id}', [RawInquiryController::class, 'process'])->name('rawenquiry.process');
	Route::post('rawenquiry/process/{id}', [RawInquiryController::class, 'storeToEnquiry'])->name('rawenquiry.process');

	// 🔹 Notifications
	Route::resource('notification', NotificationController::class)->only(['show', 'index']);
	Route::get('prepareNotifications', [NotificationController::class, 'prepareNotifications']);
	Route::get('notif/delete/{id}', [NotificationController::class, 'deleteNotification'])->name('delete.notification');

	// 🔹 Attendance Notes
	Route::get('attendancenote/{id}/create', [AttendanceNoteController::class, 'create'])->name('attendancenote.create');
	Route::post('attendancenote/{id}/create', [AttendanceNoteController::class, 'store'])->name('attendancenote.store');

	Route::get('attendancenote/{id}/edit', [AttendanceNoteController::class, 'edit'])->name('attendancenote.edit');
	Route::put('attendancenote/{id}/edit', [AttendanceNoteController::class, 'update'])->name('attendancenote.update');

	Route::get('attendancenote/{id}', [AttendanceNoteController::class, 'show'])->name('attendancenote.show');
	Route::delete('attendancenote/{id}', [AttendanceNoteController::class, 'destroy'])->name('attendancenote.destroy');

	// 🔹 Reports
	Route::name('report.')->prefix('report')->group(function () {
		Route::get('/invoice', [ReportController::class, 'index'])->name('invoice');
		Route::get('/receipt', [ReportController::class, 'indexReceipt'])->name('receipt');
		Route::get('/receipt-data', [ReportController::class, 'getReceiptReportData'])->name('receipt.data');
		Route::get('/imm_applications', [ReportController::class, 'indexImmigration'])->name('immigration');
		Route::get('/clients', [ReportController::class, 'indexClient'])->name('client');
		Route::get('/visas', [ReportController::class, 'indexVisa'])->name('visa');
	});

	// 🔹 Finance
	Route::name('finance.')->group(function () {
		// Invoice
		Route::resource('invoice', InvoiceController::class);
		Route::get('/pdf/{id}/invoice', [InvoiceController::class, 'downloadPdf']);
		Route::get('/invoice/generate/{id}', [InvoiceController::class, 'generateDocument'])->name('invoice.generate');
		Route::post('/invoice/sendmail/{id}', [InvoiceController::class, 'sendEmail'])->name('invoice.sendemail');
		Route::resource('invoiceitem', InvoiceItemController::class)->only(['store', 'update', 'destroy']);

		// Bank
		Route::resource('bank', BankController::class)->except(['destroy']);

		// Receipt
		Route::resource('receipt', ReceiptController::class);
		Route::get('/pdf/{id}/receipt', [ReceiptController::class, 'downloadPdf']);
		Route::put('/receipt/{id}/inv', [ReceiptController::class, 'updateFromInvoice'])->name('receipt.updateFromInvoice');
		Route::get('/receipt/generate/{id}', [ReceiptController::class, 'generateDocument'])->name('receipt.generate');
		Route::post('/receipt/sendmail/{id}', [ReceiptController::class, 'sendEmail'])->name('receipt.sendemail');
	});

		Route::prefix("ajax")->group(function () {
		Route::get('/clients', [ClientController::class, 'ajaxindex']);
		Route::get('/visa/{id}', [VisaController::class, 'ajaxShow']);

		Route::get('/enquiries', [EnquiryController::class, 'ajaxindex'])->name("ajax.enquiry.index");
		Route::get('/invoices', [InvoiceController::class, 'ajaxindex']);
		Route::get('/servicefees', [ServicefeeController::class, 'ajaxindex'])->name('ajax.servicefee.index');
		Route::get('/partners', [PartnerController::class, 'ajaxindex'])->name('ajax.partner.index');
		Route::get('/serviceprovider', [ServiceProviderController::class, 'ajaxIndex'])->name('ajax.serviceprovider.index');

		Route::post('/ec/{id}/content', [PreviewController::class, 'contentEc'])->name('ajax.content.ec');
		Route::post('/loa/{id}/content', [PreviewController::class, 'contentLoa'])->name('ajax.content.loa');
	});

		// File Downloads
		Route::get('/get-company-document/{file}', [CompanyDocumentController::class, 'getDownload'])->name('companydocumenturl');
		Route::get('/get-file-document/{file}', [EnquiryFormController::class, 'getDownload'])->name('enquirydocumenturl');

		// Enquiry
		Route::prefix('enquiry')->group(function () {
		Route::get('/', [EnquiryController::class, 'index'])->name('enquiry.list');
		Route::get('/datatable', [EnquiryController::class, 'datatable'])->name('enquiry.data');
		Route::get('/status', [EnquiryController::class, 'status'])->name('enquiry.status');
		Route::get('/add', [EnquiryController::class, 'create'])->name('enquiry.create');
		Route::post('/save', [EnquiryController::class, 'store'])->name('enquiry.save');
		Route::post('/update-enquiry-status', [EnquiryController::class, 'statusUpdate'])->name('enquiry.postStatusUpdate');
		Route::get('/{id}/show', [EnquiryController::class, 'show'])->name('enquiry.show');
		Route::post('/{id}/show', [EnquiryController::class, 'unlink'])->name('enquiry.unlink');

		// Logs
		Route::get('/{id}/log', [EnquiryController::class, 'indexLog'])->name('enquiry.log');
		Route::get('/log/{lid}', [EnquiryController::class, 'showLog'])->name('enquiry.show.log');
		Route::post('/{id}/log', [EnquiryController::class, 'storeLog'])->name('enquiry.store.log');
		Route::delete('/{id}/log', [EnquiryController::class, 'destroyLog'])->name('enquiry.destroy.log');
		Route::put('/{id}/log', [EnquiryController::class, 'updateLog'])->name('enquiry.update.log');

		// Status & Edit
		Route::post('/status/{id}/update', [EnquiryController::class, 'statusUpdate'])->name('enquiry.statusUpdate');
		Route::get('/{id}/edit', [EnquiryController::class, 'edit'])->name('enquiry.edit');
		Route::put('/{id}/update', [EnquiryController::class, 'update'])->name('enquiry.update');
		Route::delete('/{id}/delete', [EnquiryController::class, 'destroy'])->name('enquiry.delete');

		// Client Care
		Route::post('/{id}/clientcare', [EnquiryController::class, 'clientCare'])->name('enquiry.clientcare');
		Route::get('/{id}/clientcare', [EnquiryController::class, 'showClientCare'])->name('enquiry.clientcare');
		Route::post('/enquiry/clientcare/{id}/save', [EnquiryController::class, 'saveClientCare'])->name('enquiry.clientcare.save');
		Route::get('/load-client-care/{id}', [EnquiryController::class, 'loadClientCare'])->name('load.clientcare');

		// CCL Application
		Route::post('/{id}/cclapplication', [EnquiryController::class, 'cclApplication'])->name('enquiry.cclapplication');
		Route::get('/{id}/cclapplication', [EnquiryController::class, 'showCclApplication'])->name('enquiry.cclapplication');
		Route::post('/enquiry/cclapplication/{id}/save', [EnquiryController::class, 'saveCclApplication'])->name('enquiry.clientcare.save');
		Route::get('/load-ccl-application/{id}', [EnquiryController::class, 'loadCclApplication'])->name('load.cclapplication');

		Route::get('/enquiry/{id}/load-data', [EnquiryController::class, 'loadClientCareData']);

		// Enquiry Care
		Route::get('/{id}/enquirycare', [EnquiryController::class, 'showEnquiryCare'])->name('enquiry.enquirycare');
		Route::post('/{id}/enquirycare', [EnquiryController::class, 'enquiryCare'])->name('enquiry.enquirycare');

		// Letter of Authority
		Route::get('/{id}/letterofauthority', [EnquiryController::class, 'showLetterOfAuthority'])->name('enquiry.letterofauthority');
		Route::post('/{id}/letterofauthority', [EnquiryController::class, 'letterOfAuthority'])->name('enquiry.letterofauthority');
		Route::post('/loa/load-content/{id}', [EnquiryController::class, 'loadContent'])->name('ajax.load.loa');

		// Letter to Firm
		Route::get('/{id}/lettertofirm', [EnquiryController::class, 'showLetterToFirm'])->name('enquiry.lettertofirm');
		Route::post('/{id}/lettertofirm', [EnquiryController::class, 'letterToFirm'])->name('enquiry.lettertofirm');

		// Request to Medical
		Route::get('/{id}/requesttomedical', [EnquiryController::class, 'showRequestToMedical'])->name('enquiry.requesttomedical');
		Route::post('/{id}/requesttomedical', [EnquiryController::class, 'requestToMedical'])->name('enquiry.requesttomedical');

		// Request to Finance
		Route::get('/{id}/requesttofinance', [EnquiryController::class, 'showRequestToFinance'])->name('enquiry.requesttofinance');
		Route::post('/{id}/requesttofinance', [EnquiryController::class, 'requestToFinance'])->name('enquiry.requesttofinance');

		// Request to Tribunal
		Route::get('/{id}/requesttotrbunal', [EnquiryController::class, 'showRequestToTrbunal'])->name('enquiry.requesttotrbunal');
		Route::post('/{id}/requesttotrbunal', [EnquiryController::class, 'requestToTrbunal'])->name('enquiry.requesttotrbunal');

		// Subject Access
		Route::get('/{id}/subjectaccess', [EnquiryController::class, 'showSubjectAccess'])->name('enquiry.subjectaccess');
		Route::post('/{id}/subjectaccess', [EnquiryController::class, 'subjectAccess'])->name('enquiry.subjectaccess');

		// File Opening Form
		Route::get('/{id}/fileopeningform', [EnquiryController::class, 'showFileOpeningForm'])->name('enquiry.fileopeningform');
		Route::post('/{id}/fileopeningform', [EnquiryController::class, 'fileOpeningForm'])->name('enquiry.fileopeningform');

		// Client of Authority
		Route::get('/{id}/clientofauthority', [EnquiryController::class, 'showClientOfAuthority'])->name('enquiry.clientofauthority');
		Route::post('/{id}/clientofauthority', [EnquiryController::class, 'clientOfAuthority'])->name('enquiry.clientofauthority');

		// LTE CCL
		Route::get('/{id}/lteccl', [EnquiryController::class, 'showLteCcl'])->name('enquiry.lteccl');
		Route::post('/{id}/lteccl', [EnquiryController::class, 'lteCcl'])->name('enquiry.lteccl');

		// New CCL
		Route::get('/{id}/newccl', [EnquiryController::class, 'showNewCcl'])->name('enquiry.newccl');
		Route::post('/{id}/newccl', [EnquiryController::class, 'newCcl'])->name('enquiry.newccl');
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
Route::get("/storage/{file}", [HomeController::class, 'getDownload'])->name('storageurl');
Route::get("housekeeping", [HomeController::class, 'work']);


