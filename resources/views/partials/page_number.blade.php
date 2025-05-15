<script type="text/php">
    if ( isset($pdf) ) {
        //$font = F/ont_Metrics::get_font("helvetica", "bold");
        $pdf->page_text(config('cms.page_number_x',460), config('cms.page_number_y',810), "Page: {PAGE_NUM} of {PAGE_COUNT}",null, 12, array(0,0,0));
    }
</script> 