<?php


/*
 * 前端
 */
Route::group([], function () {


    $controller = "IndexController";

    Route::match(['get','post'], 'download/qr-code', $controller.'@operate_download_qr_code');


});
