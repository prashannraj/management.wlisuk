<?php

namespace App\Custom;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;

class NewPDF extends PDF
{

    public function download($filename = 'document.pdf')
    {
        if (ob_get_contents()) ob_end_clean();
        $output = $this->output();
        return new Response($output, 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="' . $filename . '"',
            'Content-Length' => strlen($output),
        ));
    }

    /**
     * Return a response with the PDF to show in the browser
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function stream($filename = 'document.pdf')
    {
        if (ob_get_contents()) ob_end_clean();
        $output = $this->output();
        return new Response($output, 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="' . $filename . '"',
        ));
    }
}
