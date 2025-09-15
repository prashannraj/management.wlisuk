<?php

return [

    // default constant for enquiry follow up
    'ENQUIRY_STATUS' =>[
        '1' => 'New',
        '2' => 'Follow Up',
        '3' => 'Processed',
        '4' => 'Closed'
    ],
    'date_format' => 'd/m/Y',
    'another_date_format'=>'d M Y',
    'another_date_format_javascript'=>'d M yyyy',
    'date_format_javascript' => 'dd/mm/yyyy',
    'reasons'=>[
        'Successful',
        'Unsuccessful',
        'Refunded',
        'Withdrawn',
        'Client Terminated'
    ],
    'file_closed_id'=>5,
    'enquiry_closed_id'=>4, 
    'followup_notification_days'=>1, //deadline for notifying about followups
    'employee_visa_expiry_days'=>60, //deadline for notifying employee's visa expiry
    'client_visa_expiry_days'=>60, //deadline for notifying client's visa expiry
    'enquiry_form_types'=>[
        'general'=>"General Form",
        'immigration'=>"Immigration Form",
        // "partner"=>"Partner/Spouse of a British Citizen/ILR Holder",
        // 'child'=>"Child of the parent with limited leave in the uk",
        // 'ukvisa'=>"UK Visit Visa Enquiry"
    ],
    'cpd_date_format'=>"M/Y",
    'cpd_date_format_javascript'=>"M/yyyy"
];