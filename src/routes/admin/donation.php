<?php

use XelentAbrar\HospitalDonation\Http\Controllers\Donation\DonorController;
use XelentAbrar\HospitalDonation\Http\Controllers\Donation\DonorFundController;
use Illuminate\Support\Facades\Route;
use XelentAbrar\HospitalDonation\Http\Controllers\Donation\ReportController;

Route::resource('donors', DonorController::class)->names('donors');
Route::resource('donor-funds', DonorFundController::class)->names('donor-funds');
Route::get('donor-funds/print/{donorFund}', [DonorFundController::class, 'print'])->name('donor-funds.print');

if(file_exists(base_path('config/hrms.php'))) {
    Route::get('/donation/reports/zf-detail', [ReportController::class,'zfDetailReport'])->name('donation.reports-zf-detail');
}
if (file_exists(base_path('config/hrms.php')) || file_exists(base_path('config/lab.php'))) {
    Route::get('/donation/reports/careoff-summary', [ReportController::class,'CareOFFReport'])->name('donation.reports-careoff-summary');
}