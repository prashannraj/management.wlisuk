<?php

namespace App\Repositories\Student;

interface StudentInterface {
    
    public function getAll();

    // public function find($id);
    
    // public function save($data);

    public function saveStudentContactDetail($data);

    // public function update($data, $id);

    // public function delete($id);
}