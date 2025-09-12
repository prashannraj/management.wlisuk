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
use App\Http\Controllers\Admin\ApplicantSavingInfoController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\EmailSenderController;
use App\Http\Controllers\Admin\CpdController;
use App\Http\Controllers\Admin\CpdDetailController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\GeneratorBuilderController;
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
use App\Http\Controllers\Admin\ClientDocumentController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CoverLetterController;
use App\Http\Controllers\Admin\ApplicationAssessmentController;
use App\Http\Controllers\Admin\ApplicationAssessmentFileController;
use App\Http\Controllers\Admin\AssessmentSectionController;





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
    Route::post('/login', [LoginController::class, 'prelogin'])->name('login.attempt');
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
	Route::match(['GET', 'POST'], '/enquiryform/display/{uuid}', [EnquiryFormController::class, 'display'])->name('enquiryform.display');
	Route::post('/enquiryform/fillup/{uuid}', [EnquiryFormController::class, 'fillup'])->name('enquiryform.fillup');
	Route::get('/rawenquiry/verify/{code}', [EnquiryFormController::class, 'verify'])->name('rawenquiry.verify');



	


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

		// Extra routes outside resource
		Route::get('rawenquiry/toggle/{id}', [RawInquiryController::class, 'toggle'])->name('rawenquiry.toggle');
		Route::post('rawenquiry/{id}/add-note', [RawInquiryController::class, 'addNote'])->name('rawenquiry.add-note');

		// Process routes with distinct names for GET and POST
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
		Route::get('/data', [EnquiryController::class, 'datatable'])->name('enquiry.data');
		//Route::get('/datatable', [EnquiryController::class, 'datatable'])->name('enquiry.data');
		Route::get('/status', [EnquiryController::class, 'status'])->name('enquiry.status');
		Route::get('/add', [EnquiryController::class, 'create'])->name('enquiry.create');
		Route::post('/save', [EnquiryController::class, 'store'])->name('enquiry.save');
		Route::post('/update-enquiry-status', [EnquiryController::class, 'statusUpdate'])->name('enquiry.postStatusUpdate');
		Route::get('/{id}/show', [EnquiryController::class, 'show'])->name('enquiry.show');
		Route::post('/{id}/show', [EnquiryController::class, 'unlink'])->name('enquiry.unlink');
		Route::delete('/{id}/delete', [EnquiryController::class, 'destroy'])->name('enquiry.destroy');


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





	Route::group(['prefix' => 'client'], function () {

		Route::get('/', [ClientController::class, 'index'])->name('client.list');
		Route::get('/{id}/edit', [ClientController::class, 'editBasicInfo'])->name('edit.basic_info');
		Route::put('update/{id}/client', [ClientController::class, 'updateBasicInfo'])->name('client.updateBasicInfo');
		Route::get('/{id}/dashboard', [ClientController::class, 'show'])->name('client.show');
		Route::get('/{id}/show', [ClientController::class, 'view'])->name('client.view');
		Route::post('/{id}/dashboard', [ClientController::class, 'addEnquiry'])->name('client.show');
		Route::delete('/{id}/show', [ClientController::class, 'destroy'])->name('client.destroy');
		Route::delete('/{id}/delete-permanently', [ClientController::class, 'deletePermanently'])->name('client.delete-permanently');
		Route::get('/{id}/restore', [ClientController::class, 'restore'])->name('client.restore');

		Route::get('/enquiry/{id}/dashboard', [ClientController::class, 'enquiryToClient'])->name('enquiry.dashboard');

		Route::post('/addbasicinfo', [ClientController::class, 'addBasicInfo'])->name('client.addbasicinfo');

		Route::post('/store-passport', [ClientController::class, 'storePassport'])->name('client.store.passport');
		Route::post('/save-student-contact', [ClientController::class, 'addStudentContactDetail'])->name('client.studentContactDetailsAdd');
		Route::get('/edit-address/{id}', [ClientController::class, 'editClientAddress'])->name('edit.address');
		Route::put('/update-address/{id}', [ClientController::class, 'updateClientAddress'])->name('update.client.address');
		Route::get('/edit-emergency/{id}', [ClientController::class, 'editClientEmergency'])->name('edit.emergency');
		Route::put('/update-emergency/{id}', [ClientController::class, 'updateClientEmergency'])->name('update.client.emergency');
		Route::get('/edit-contact/{id}', [ClientController::class, 'editClientCurrentContact'])->name('edit.contact');
		Route::put('/update-contact/{id}', [ClientController::class, 'updateClientCurrentContact'])->name('update.client.contact');
		Route::delete('/delete-contact/{id}', [ClientController::class, 'deleteCurrentContact'])->name('delete.contact');
		Route::delete('/delete-emergency/{id}', [ClientController::class, 'deleteEmergency'])->name('delete.emergency');
		Route::delete('/delete-address/{id}', [ClientController::class, 'deleteAddress'])->name('delete.address');

		Route::post('/save-client-address', [ClientController::class, 'addStudentAddressDetail'])->name('client.studentAddressAdd');
		Route::post('/save-client-emergency', [ClientController::class, 'addStudentEmergencyDetail'])->name('client.studentEmergencyAdd');

		Route::get('/add-passport/{id}', [ClientController::class, 'addPassportDetail'])->name('client.add.passport');
		Route::get('/edit-passport/{id}', [ClientController::class, 'editPassportDetail'])->name('client.edit.passport');
		Route::get('/show-passport/{id}', [ClientController::class, 'showPassportDetail'])->name('client.show.passport');
		Route::put('/update-passport/{id}', [ClientController::class, 'updatePassport'])->name('client.update.passport');

		Route::get('/add-cvisa/{id}', [ClientController::class, 'addVisaDetail'])->name('client.add.visa');
		Route::get('/show-visa/{id}', [ClientController::class, 'showVisaDetail'])->name('client.show.visa');
		Route::post('/store-visa', [ClientController::class, 'storeVisa'])->name('client.store.visa');
		Route::get('/edit-cvisa/{id}', [ClientController::class, 'editVisaDetail'])->name('client.edit.visa');
		Route::put('/update-cvisa/{id}', [ClientController::class, 'updateVisa'])->name('client.update.visa');

		Route::get('/add-ukvisa/{id}', [ClientController::class, 'addUkVisaDetail'])->name('client.add.ukvisa');
		Route::post('/store-ukvisa', [ClientController::class, 'storeUkVisa'])->name('client.store.ukvisa');
		Route::get('/edit-ukvisa/{id}', [ClientController::class, 'editUkVisaDetail'])->name('client.edit.ukvisa');
		Route::put('/update-ukvisa/{id}', [ClientController::class, 'updateUkVisa'])->name('client.update.ukvisa');

		Route::get('/document', [ClientDocumentController::class, 'listDocument'])->name('client.document');
		Route::get('/document/{id}', [ClientDocumentController::class, 'addDocument'])->name('client.add.document');
		Route::post('/store-document', [ClientDocumentController::class, 'storeDocument'])->name('client.store.document');
		Route::post('/store-documents', [ClientDocumentController::class, 'storeDocuments'])->name('client.store.documents');

		Route::get('/edit-document/{id}', [ClientDocumentController::class, 'editDocument'])->name('client.edit.document');
		Route::put('/update-document/{id}', [ClientDocumentController::class, 'updateDocument'])->name('client.update.document');
		Route::delete('/delete-document/{id}', [ClientDocumentController::class, 'deleteDocument'])->name('client.delete.document');
		Route::delete('/document/{id}', [ClientDocumentController::class, 'destroy'])->name('document.destroy');

		Route::get('/application/immigration/{basic_info_id}', [ApplicationController::class, 'addImmigration'])->name('client.add.application.immigration');
		Route::post('/store-immigration-application', [ApplicationController::class, 'storeImmigration'])->name('client.store.application.immigration');
		Route::get('/application/edit-immigration/{id}', [ApplicationController::class, 'editImmigration'])->name('client.edit.application.immigration');
		Route::delete('/application/delete-immigration', [ApplicationController::class, 'destroy'])->name('client.delete.application.immigration');

		Route::get('/application/immigration/{id}/logs', [ApplicationController::class, 'applicationImmigrationLogs'])->name('client.list.application.immigration.logs');
		Route::post('/application/immigration/{id}/storelogs', [ApplicationController::class, 'storeApplicationImmigrationLogs'])->name('client.list.application.immigration.storelogs');
		Route::get('/application/immigration/process/view/{id}', [ApplicationController::class, 'viewApplicationImmigrationProcess'])->name('client.application.view.immigration.process');
		Route::put('/application/immigration/process/update/{id}', [ApplicationController::class, 'updateApplicationImmigrationProcess'])->name('client.application.update.immigration.process');
		Route::put('/application/immigration/process/delete/{id}', [ApplicationController::class, 'deleteApplicationImmigrationProcess'])->name('client.application.delete.immigration.process');
		Route::put('/immigration/update-application/{id}', [ApplicationController::class, 'updateImmigration'])->name('client.update.immigration');
		Route::post('application/immigration/process/email', [ApplicationController::class, 'emailApplicationImmigrationProcess'])->name('client.application.email.immigration.process');

		Route::get('/application/admission/{basic_info_id}', [AdmissionApplicationController::class, 'create'])->name('client.add.application.admission');
		Route::post('/store-admission-application', [AdmissionApplicationController::class, 'store'])->name('client.store.application.admission');
		Route::get('/application/edit-admission/{id}', [AdmissionApplicationController::class, 'edit'])->name('client.edit.application.admission');
		Route::put('/admission/update-application/{id}', [AdmissionApplicationController::class, 'update'])->name('client.update.admission');
		Route::delete('/application/delete-admission', [AdmissionApplicationController::class, 'destroy'])->name('client.delete.application.admission');
		Route::get('admissionapplication', [AdmissionApplicationController::class, 'index'])->name('admissionapplication.index');


		Route::get('/application/immigration-appeal/{basic_info_id}', [ImmigrationAppealController::class, 'addImmigrationAppeal'])->name('client.add.application.immigrationappeal');
		Route::get('/application/edit-immigration-appeal/{id}', [ImmigrationAppealController::class, 'editImmigrationAppeal'])->name('client.edit.application.immigrationappeal');
		Route::put('/application/immigration-appeal/update-application/{id}', [ImmigrationAppealController::class, 'updateImmigrationAppeal'])->name('client.update.immigration-appeal');
		Route::get('/application/immigration-appeal/{id}/logs', [ImmigrationAppealController::class, 'immigrationAppealLogs'])->name('client.list.immigration-appeal.logs');
		Route::post('/application/immigration-appeal/{id}/storelogs', [ImmigrationAppealController::class, 'storeImmigrationAppealLogs'])->name('client.list.application.immigration-appeal.storelogs');
		Route::get('/application/immigration-appeal/process/view/{id}', [ImmigrationAppealController::class, 'viewApplicationImmigrationProcess'])->name('client.application.view.immigration-appeal.process');
		Route::put('/application/immigration-appeal/process/update/{id}', [ImmigrationAppealController::class, 'updateApplicationImmigrationProcess'])->name('client.application.update.immigration-appeal.process');
		Route::put('/application/immigration-appeal/process/delete/{id}', [ImmigrationAppealController::class, 'deleteApplicationImmigrationProcess'])->name('client.application.delete.immigration-appeal.process');
		Route::post('/store-immigration-appeal-application', [ImmigrationAppealController::class, 'storeImmigrationAppeal'])->name('client.store.application.immigration-appeal');

		Route::get('/application/admission/{id}/logs', [AdmissionApplicationController::class, 'applicationLogs'])->name('client.list.application.admission.logs');
		Route::get('/application/admission/process/view/{id}', [AdmissionApplicationController::class, 'showApplicationProcess'])->name('client.application.view.admission.process');
		Route::post('/application/admission/{id}/storelogs', [AdmissionApplicationController::class, 'storeApplicationLogs'])->name('client.list.application.admission.storelogs');
		Route::put('/application/admission/process/update/{id}', [AdmissionApplicationController::class, 'updateApplicationProcess'])->name('client.application.update.admission.process');
		Route::put('/application/admission/process/delete/{id}', [AdmissionApplicationController::class, 'deleteApplicationProcess'])->name('client.application.delete.admission.process');
		Route::post('application/admission/process/email', [AdmissionApplicationController::class, 'email'])->name('client.application.email.admission.process');

		Route::get('/get-document/{file}', [ApplicationController::class, 'getDownload'])->name('documenturl');
		Route::get('/get-file/{file}', [ApplicationController::class, 'getFile'])->name('fileurl');

	});


	Route::name('application.')->prefix('applications')->group(function () {
    Route::get('admission', [AdmissionApplicationController::class, 'index'])->name('admission.index');
    Route::get('immigration', [ApplicationController::class, 'index'])->name('immigration.index');
		});

	Route::name('additionaldocument.')->prefix('additionaldocument')->group(function () {
			Route::get('create/loa/{id}', [AdditionalDocumentController::class, 'createLoa'])->name('loa.create');
			Route::post('create/loa/{id}', [AdditionalDocumentController::class, 'storeLoa'])->name('loa.store');

			Route::get('create/loc/{id}', [AdditionalDocumentController::class, 'createloc'])->name('loc.create');
			Route::post('create/loc/{id}', [AdditionalDocumentController::class, 'storeloc'])->name('loc.store');

			Route::get('create/fof/{id}', [AdditionalDocumentController::class, 'createfof'])->name('fof.create');
			Route::post('create/fof/{id}', [AdditionalDocumentController::class, 'storefof'])->name('fof.store');

			Route::get('create/rel/{id}', [AdditionalDocumentController::class, 'createrel'])->name('rel.create');
			Route::post('create/rel/{id}', [AdditionalDocumentController::class, 'storerel'])->name('rel.store');

			Route::get('create/spd/{id}', [AdditionalDocumentController::class, 'createspd'])->name('spd.create');
			Route::post('create/spd/{id}', [AdditionalDocumentController::class, 'storespd'])->name('spd.store');

			Route::get('create/apd/{id}', [AdditionalDocumentController::class, 'createapd'])->name('apd.create');
			Route::post('create/apd/{id}', [AdditionalDocumentController::class, 'storeapd'])->name('apd.store');

			Route::get('create/coe/{id}', [AdditionalDocumentController::class, 'createcoe'])->name('coe.create');
			Route::post('create/coe/{id}', [AdditionalDocumentController::class, 'storecoe'])->name('coe.store');

			Route::get('create/ec/{id}', [AdditionalDocumentController::class, 'createec'])->name('ec.create');
			Route::post('create/ec/{id}', [AdditionalDocumentController::class, 'storeec'])->name('ec.store');

			Route::get('create/nok/{id}', [AdditionalDocumentController::class, 'createnok'])->name('nok.create');
			Route::post('create/nok/{id}', [AdditionalDocumentController::class, 'storenok'])->name('nok.store');

			Route::get('create/eci/{id}', [AdditionalDocumentController::class, 'createeci'])->name('eci.create');
			Route::post('create/eci/{id}', [AdditionalDocumentController::class, 'storeeci'])->name('eci.store');

			Route::get('create/eicl/{id}', [AdditionalDocumentController::class, 'createeicl'])->name('eicl.create');
			Route::post('create/eicl/{id}', [AdditionalDocumentController::class, 'storeeicl'])->name('eicl.store');
		});


	Route::get('aacl/{id}', [CoverLetterController::class, 'create'])->name('aacl.create');
	Route::post('aacl/{id}', [CoverLetterController::class, 'store'])->name('aacl.store');


	Route::name('application_assessment.')->prefix('application_assessment')->group(function () {
		Route::get('create/{id}', [ApplicationAssessmentController::class, 'create'])->name('create');
		Route::post('create/{id}', [ApplicationAssessmentController::class, 'store'])->name('store');
		Route::get('edit/{id}', [ApplicationAssessmentController::class, 'edit'])->name('edit');
		Route::put('edit/{id}', [ApplicationAssessmentController::class, 'update'])->name('update');
		Route::get('{id}', [ApplicationAssessmentController::class, 'show'])->name('show');
		Route::delete('{id}', [ApplicationAssessmentController::class, 'destroy'])->name('destroy');
		Route::post('{id}', [ApplicationAssessmentController::class, 'uploadFiles'])->name('uploadfiles');
		Route::post('{id}/updateStatus', [ApplicationAssessmentController::class, 'updateStatus'])->name('updateStatus');
		Route::post('{id}/toggle', [ApplicationAssessmentController::class, 'toggle'])->name('toggle');
	});

	Route::get('financial_assessment/{id}', [ApplicationAssessmentController::class, 'showFinancial'])->name('financial_assessment.show');
	Route::post('financial_assessment/{id}', [ApplicationAssessmentController::class, 'generateFinancial'])->name('financial_assessment.generate');

	Route::name('application_assessment_file.')->prefix('application_assessment_file')->group(function () {
		Route::get('preview/{id}', [ApplicationAssessmentFileController::class, 'preview'])->name('preview');
		Route::put('update/{id}', [ApplicationAssessmentFileController::class, 'update'])->name('update');
		Route::delete('{id}', [ApplicationAssessmentFileController::class, 'destroy'])->name('destroy');
	});

		
	Route::name('assessment_section.')->prefix('assessment_section')->group(function () {
		Route::post('create/{id}', [AssessmentSectionController::class, 'store'])->name('store');
		Route::post('{id}', [AssessmentSectionController::class, 'update'])->name('update');
		Route::delete('{id}', [AssessmentSectionController::class, 'destroy'])->name('destroy');
		Route::post('{id}/toggle', [AssessmentSectionController::class, 'toggle'])->name('toggle');
	});

	Route::name('employment_detail.')->prefix('employment_detail')->group(function () {
		Route::get('{id}', [ApplicantEmploymentInfoController::class, 'show'])->name('show');
		Route::post('{id}', [ApplicantEmploymentInfoController::class, 'update'])->name('update');
		Route::post('create/{id}', [ApplicantEmploymentInfoController::class, 'store'])->name('store');
		Route::delete('{id}', [ApplicantEmploymentInfoController::class, 'destroy'])->name('destroy');
		Route::post('{id}/toggle', [ApplicantEmploymentInfoController::class, 'toggle'])->name('toggle');
	});

	Route::name('applicantpayslip.')->prefix('applicantpayslip')->group(function () {
		Route::get('{id}', [ApplicantPayslipController::class, 'show'])->name('show');
		Route::post('create/{id}', [ApplicantPayslipController::class, 'store'])->name('store');
		Route::post('import/{id}', [ApplicantPayslipController::class, 'import'])->name('import');

		Route::get('edit/{id}', [ApplicantPayslipController::class, 'edit'])->name('edit');
		Route::post('edit/{id}', [ApplicantPayslipController::class, 'update'])->name('update');

		Route::delete('{id}', [ApplicantPayslipController::class, 'destroy'])->name('destroy');
		Route::get('{id}/toggle', [ApplicantPayslipController::class, 'toggle'])->name('toggle');
	});

	Route::name('applicantsavinginfo.')->prefix('applicantsavinginfo')->group(function () {
		Route::get('edit/{id}', [ApplicantSavingInfoController::class, 'edit'])->name('edit');
		Route::post('edit/{id}', [ApplicantSavingInfoController::class, 'update'])->name('update');

		Route::post('create/{id}', [ApplicantSavingInfoController::class, 'store'])->name('store');
		Route::delete('{id}', [ApplicantSavingInfoController::class, 'destroy'])->name('destroy');
		// Route::post('{id}/toggle', [ApplicantSavingInfoController::class, 'toggle'])->name('toggle'); // commented out as per original
	});

	// Resource routes
	Route::resource('template', TemplateController::class);
	Route::resource('emailSenders', EmailSenderController::class);
	Route::resource('cpds', CpdController::class);
	Route::resource('cpdDetails', CpdDetailController::class)->only(['store', 'update', 'destroy', 'show']);

	Route::post('cpdDetails/import', [CpdDetailController::class, 'import'])->name('cpdDetails.import');

	// Generator routes
	// Route::get('generator_builder', [GeneratorBuilderController::class, 'builder'])->name('io_generator_builder');
	// Route::get('field_template', [GeneratorBuilderController::class, 'fieldTemplate'])->name('io_field_template');
	// Route::get('relation_field_template', [GeneratorBuilderController::class, 'relationFieldTemplate'])->name('io_relation_field_template');
	// Route::post('generator_builder/generate', [GeneratorBuilderController::class, 'generate'])->name('io_generator_builder_generate');
	// Route::post('generator_builder/rollback', [GeneratorBuilderController::class, 'rollback'])->name('io_generator_builder_rollback');
	// Route::post('generator_builder/generate-from-file', [GeneratorBuilderController::class, 'generateFromFile'])->name('io_generator_builder_generate_from_file');

	Route::post('visaexpiry-email', [VisaController::class, 'sendEmail'])->name('send.visaexpiry.email');

	Route::name('massemail.')->group(function () {
		Route::get('send-emails', [CompanyInfoController::class, 'sendEmails']);
		Route::post('send-emails', [CompanyInfoController::class, 'postSendEmails'])->name('send');
	});

	Route::get('/test', [DashboardController::class, 'test']);

// routes/web.php
Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload.image');
Route::get("/storage/{file}", [HomeController::class, 'getDownload'])->name('storageurl');
Route::get("housekeeping", [HomeController::class, 'work']);

});


