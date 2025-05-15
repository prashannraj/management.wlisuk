<?php 
 
Route::get("/",function(){
	echo "working...";
});
 Route::get("/{uuid}","EnquiryFormController@display")->name("enquiryform.display");
 Route::post("/{uuid}","EnquiryFormController@fillup")->name("enquiryform.fillup");
 Route::get("/verify/{uuid}","RawInquiryController@verify")->name("rawenquiry.verify");
