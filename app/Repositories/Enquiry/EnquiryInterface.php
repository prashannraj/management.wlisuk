<?php

namespace App\Repositories\Enquiry;

interface EnquiryInterface {
    
    public function getAll();

    public function find($id);
    
    public function save($data);

    public function update($data, $id);

    public function delete($id);
}