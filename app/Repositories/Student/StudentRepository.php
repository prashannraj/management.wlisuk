<?php

namespace App\Repositories\Student;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use App\Models\StudentContactDetail;
use App\Repositories\Student\StudentInterface as StudentInterface;
use SebastianBergmann\Environment\Console;

class StudentRepository implements StudentInterface
{
    // protected $enquiry;
    protected $studentContactDetail;

    function __construct(
        StudentContactDetail $studentContactDetail
    ) {
        $this->studentContactDetail = $studentContactDetail;
    }

    public function getAll()
    {
        return $this->studentContactDetail->getAll();
    }

    // public function find($id)
    // {
    //     return $this->enquiry->findEnquiry($id);
    // }

    public function saveStudentContactDetail($data){
        $studentContactDetail = $this->studentContactDetail->make();
        $studentContactDetail->basic_info_id = null; 
        $studentContactDetail->enquiry_list_id = $data['enquiry_id']; 
        $studentContactDetail->primary_email = $data['email']; 
        $studentContactDetail->primary_mobile = $data['mobile']; 
        $studentContactDetail->country_mobile = $data['mobile_code']; 
        $studentContactDetail->contact_number_two = $data['tel']; 
        $studentContactDetail->country_contacttwo = $data['tel_code']; 
        $studentContactDetail->created_by = Auth::user()->id; 
        $studentContactDetail->modified_by = Auth::user()->id; 
        $status = $studentContactDetail->save();
    }

    // public function update($data, $id){
    //     DB::beginTransaction();
    //     $enquiry = $this->enquiry->find($id);
    //     if(!$enquiry){
    //         return null;
    //     }
    //     $enquiry->title = $data['title']; 
    //     $enquiry->surname = $data['surname']; 
    //     $enquiry->first_name = $data['firstName']; 
    //     $enquiry->middle_name = $data['middleName']; 
    //     $enquiry->country_mobile = $data['mobile_code']; 
    //     $enquiry->mobile = $data['mobile']; 
    //     $enquiry->country_tel = $data['tel_code']; 
    //     $enquiry->tel = $data['tel']; 
    //     $enquiry->email = $data['email']; 
    //     $enquiry->enquiry_type_id = $data['enquiry_type']; 
    //     $enquiry->referral = $data['referral']; 
    //     $enquiry->note = $data['note']; 
    //     $enquiry->enquiry_assigned_to = $data['assignedto']; 
    //     $enquiry->latest_status = 2; 
    //     $enquiry->created_by = ($enquiry->created_by)? $enquiry->created_by : Auth::user()->id; 
    //     $enquiry->modified_by = Auth::user()->id; 
    //     $enquiry->department_id = 1;
    //     $status = $enquiry->save();
    //     if($status){
    //         $activity = EnquiryActivity::where('enquiry_list_id',$enquiry->id)->first();
    //         if(!$activity){
    //             $activity = new EnquiryActivity();
    //             $activity->enquiry_list_id =$enquiry->id;
    //             $activity->status = 1;
    //             $activity->note = '';
    //             $activity->created_by = Auth::user()->id;
    //             $activity->processing = 0;
    //             $activity->save();
    //         }
    //         DB::commit();
    //     }else{
    //         DB::rollBack();
    //     }
    //     return $status;
    // }
    
    // public function delete($id)
    // {
    //     return $this->enquiry->deleteEnquiry($id);
    // }
}