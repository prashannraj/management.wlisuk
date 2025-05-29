<?php

namespace App\Repositories\Enquiry;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use App\Models\EnquiryActivity;
use App\Repositories\Enquiry\EnquiryInterface as EnquiryInterface;
use App\Repositories\Student\StudentRepository;
use SebastianBergmann\Environment\Console;

class EnquiryRepository implements EnquiryInterface
{
    public $enquiry;
    protected $studentRepository;

    function __construct(
        Enquiry $enquiry,
        StudentRepository $studentRepository
    ) {
        $this->enquiry = $enquiry;
        $this->studentRepository = $studentRepository;
    }

    public function getAll()
    {
        return $this->enquiry->getAll();
    }

    public function find($id)
    {
        return $this->enquiry->findEnquiry($id);
    }

    public function save($data){
        DB::beginTransaction();
        $enquiry = $this->enquiry->make();
        $enquiry->title = $data['title']; 
        $enquiry->surname = $data['surname']; 
        $enquiry->first_name = $data['firstName']; 
        $enquiry->middle_name = $data['middleName']; 
        $enquiry->country_mobile = $data['mobile_code']; 
        $enquiry->mobile = $data['mobile']; 
        $enquiry->country_tel = $data['tel_code']; 
        $enquiry->tel = $data['tel']; 
        $enquiry->email = $data['email']; 
        $enquiry->enquiry_type_id = $data['enquiry_type']; 
        $enquiry->referral = $data['referral']; 
        $enquiry->note = $data['note']; 
        $enquiry->enquiry_assigned_to = $data['assignedto']; 
        $enquiry->latest_status = 1; 
        $enquiry->created_by = Auth::user()->id; 
        $enquiry->modified_by = Auth::user()->id; 
        $enquiry->department_id = 1;
        $status = $enquiry->save();
        $data['enquiry_id'] = $enquiry->id;
        if($status){
            $activity = new EnquiryActivity();
            $activity->enquiry_list_id = $enquiry->id;
            $activity->status = 1;
            $activity->note = '';
            $activity->created_by = Auth::user()->id;
            $activity->processing = 0;
            $activity->save();
            $this->studentRepository->saveStudentContactDetail($data);
            // dd($activity);
            DB::commit();
        }else{
            DB::rollBack();
        }
        
        return $enquiry->id;
    }

    public function update($data, $id){
        DB::beginTransaction();
        $enquiry = $this->enquiry->find($id);
        if(!$enquiry){
            return null;
        }
        $enquiry->title = $data['title']; 
        $enquiry->surname = $data['surname']; 
        $enquiry->first_name = $data['firstName']; 
        $enquiry->middle_name = $data['middleName']; 
        $enquiry->country_mobile = $data['mobile_code']; 
        $enquiry->mobile = $data['mobile']; 
        $enquiry->country_tel = $data['tel_code']; 
        $enquiry->tel = $data['tel']; 
        $enquiry->email = $data['email']; 
        $enquiry->enquiry_type_id = $data['enquiry_type']; 
        $enquiry->referral = $data['referral']; 
        $enquiry->note = $data['note']; 
        $enquiry->enquiry_assigned_to = $data['assignedto']; 
        $enquiry->latest_status = 2; 
        $enquiry->created_by = ($enquiry->created_by)? $enquiry->created_by : Auth::user()->id; 
        $enquiry->modified_by = Auth::user()->id; 
        $enquiry->department_id = 1;
        $enquiry->status = $data['status'];
        $status = $enquiry->save();
        if($status){
            $activity = EnquiryActivity::where('enquiry_list_id',$enquiry->id)->first();
            if(!$activity){
                $activity = new EnquiryActivity();
                $activity->enquiry_list_id =$enquiry->id;
                $activity->status = 1;
                $activity->note = '';
                $activity->created_by = Auth::user()->id;
                $activity->processing = 0;
                $activity->save();
            }
            DB::commit();
        }else{
            DB::rollBack();
        }
        return $status;
    }
    
    public function delete($id)
    {
        return $this->enquiry->deleteEnquiry($id);
    }
}