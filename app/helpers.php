<?php 

if (! function_exists('validate_page_number')) {
    function validatePageNumber($courses) {
        if( $courses->currentPage() > $courses->lastPage()) {
            return redirect()->route('courses.index', ['page' => 1]);
        }
    }
}