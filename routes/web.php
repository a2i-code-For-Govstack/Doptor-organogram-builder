<?php

use App\Http\Controllers\OfficeAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
\Illuminate\Support\Facades\Auth::routes();

Route::get('password/reset', [\App\Http\Controllers\PasswordResetController::class, 'index'])->name('password.request');
Route::post('password/reset/verificationcode', [\App\Http\Controllers\PasswordResetController::class, 'verificationCode'])->name('password.verificationcode');
Route::post('password/reset/sendmail', [\App\Http\Controllers\PasswordResetController::class, 'sendPassResetEmail'])->name('password.sendmail');
Route::post('password/reset/send_otp', [\App\Http\Controllers\PasswordResetController::class, 'sendPassResetOTP'])->name('password.send_otp');
Route::get('password/reset/{token}', [\App\Http\Controllers\PasswordResetController::class, 'verifyPassReset'])->name('password.resettoken');
Route::post('password/reset/verifypassresetphone', [\App\Http\Controllers\PasswordResetController::class, 'verifyPassResetPhone'])->name('password.verifypassresetphone');
Route::post('password/reset/verifypassresetemail', [\App\Http\Controllers\PasswordResetController::class, 'verifyPassResetEmail'])->name('password.verifypassresetemail');
Route::post('password/reset/phonecodeare', [\App\Http\Controllers\PasswordResetController::class, 'phoneCodeAre'])->name('password.phonecodeare');
Route::post('password/reset/emailcodeare', [\App\Http\Controllers\PasswordResetController::class, 'emailCodeAre'])->name('password.emailcodeare');
Route::post('password/reset/save', [\App\Http\Controllers\PasswordResetController::class, 'saveNewPassword'])->name('password.savenew');

Route::get('self-registration', [\App\Http\Controllers\SelfRegistrationController::class, 'index'])->name('signup');
Route::post('signup_store', [\App\Http\Controllers\SelfRegistrationController::class, 'store'])->name('signup.store');

//office-select componenet
Route::get('/load_office_layer_wise', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'loadOfficeLayerWise']);
Route::get('/load_layer_ministry_wise', [App\Http\Controllers\OfficeLayerController::class, 'loadLayerMinistryWise']);
Route::get('/load_custom_layer_level_wise', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'loadCustomLevelWise']);
Route::get('/load_office_custom_layer_wise', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'loadOfficeCustomLayerWise']);
Route::get('/load_office_origin_layer_level_wise', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'loadOfficeOriginLayerLevelWise']);
Route::get('/load_office_origin_wise', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'loadOfficeOriginWise']);
Route::get('/load_unit_office_wise', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'loadUnitOfficeWise']);
Route::get('/load_designation_for_assignemployee', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'loadDesignationForAssignEmployee']);

Route::get('/load_office_origin_office_layer_wise', [App\Http\Controllers\OfficeOriginController::class, 'loadOfficeOriginOfficeLayerWise']);
Route::get('/org_builder_load_office_origin_unit_organogram_tree', [App\Http\Controllers\OrganogramBuilderController::class, 'loadOfficeOriginUnitOrganogramTreeForOrganogramBuilder']);

//organogram builder
Route::get('/build-organogram', [App\Http\Controllers\OrganogramBuilderController::class, 'index']);

//geo
Route::get('/load_zila_division_wise', [App\Http\Controllers\UpoZilaController::class, 'loadZilaDivisionWise']);
Route::get('/load_upozila_district_wise', [App\Http\Controllers\PostOfficeController::class, 'loadUpozilaDistrictWise']);
Route::get('/load_office_layer_ministry_wise', [App\Http\Controllers\OfficeOriginController::class, 'loadOfficeLayerMinistryWise']);

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect(route('dashboard'));
    })->name('index');
    Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/union_kathamo', [App\Http\Controllers\UnionKathamoController::class, 'index']);
    Route::get('/thana_kathamo', [App\Http\Controllers\ThanaKathamoController::class, 'index']);
    Route::get('/post_office_kathamo', [App\Http\Controllers\PostOfficeKathamoController::class, 'index']);
    Route::get('/pourosoba_kathamo', [App\Http\Controllers\PouroshovaWordKathamoController::class, 'index']); //pourosoba_kathamo word
    Route::get('/city_corporation_kathamo', [App\Http\Controllers\CityCorporationKathamoController::class, 'index']);

    Route::get('/bivag', [App\Http\Controllers\BivagController::class, 'index']);
    Route::get('/getBivag', [App\Http\Controllers\BivagController::class, 'getBivagData']);
    Route::get('/bivag_store', [App\Http\Controllers\BivagController::class, 'store'])->name('bivag.store');
    Route::get('/generate_bivag_excel_file', [App\Http\Controllers\BivagController::class, 'generateBivagExcelFile']);
    Route::post('/generate_bivag_pdf_file', [App\Http\Controllers\BivagController::class, 'generateBivagPdfFile']);
    Route::get('/search_division', [App\Http\Controllers\BivagController::class, 'searchDivision']);
    Route::post('/delete_division', [App\Http\Controllers\BivagController::class, 'destroy']);

    Route::get('/zila', [App\Http\Controllers\ZilaController::class, 'index']);
    Route::get('/getZila', [App\Http\Controllers\ZilaController::class, 'getZilaData']);
    Route::get('/zila_store', [App\Http\Controllers\ZilaController::class, 'store'])->name('zila.store');
    Route::get('/generate_zila_excel_file', [App\Http\Controllers\ZilaController::class, 'generateZilaExcelFile']);
    Route::get('/search_zila', [App\Http\Controllers\ZilaController::class, 'searchZila']);
    Route::post('/delete_zila', [App\Http\Controllers\ZilaController::class, 'destroy']);

    Route::get('/upozila', [App\Http\Controllers\UpoZilaController::class, 'index']);
    Route::get('/getUpoZila', [App\Http\Controllers\UpoZilaController::class, 'getUpoZilaData']);
    Route::get('/upozila_store', [App\Http\Controllers\UpoZilaController::class, 'store'])->name('upozila.store');
    Route::get('/generate_upozila_excel_file', [App\Http\Controllers\UpoZilaController::class, 'generateUpozilaExcelFile']);
    Route::get('/search_upozila', [App\Http\Controllers\UpoZilaController::class, 'searchUpoZila']);
    Route::post('/delete_upozila', [App\Http\Controllers\UpoZilaController::class, 'destroy']);

    Route::get('/thana', [App\Http\Controllers\ThanaController::class, 'index']);
    Route::get('/getThana', [App\Http\Controllers\ThanaController::class, 'getThanaData']);
    Route::get('/thana_store', [App\Http\Controllers\ThanaController::class, 'store'])->name('thana.store');
    Route::get('/generate_thana_excel_file', [App\Http\Controllers\ThanaController::class, 'generateThanaExcelFile']);
    Route::get('/search_thana', [App\Http\Controllers\ThanaController::class, 'searchThana']);
    Route::post('/delete_thana', [App\Http\Controllers\ThanaController::class, 'destroy']);

    Route::get('/union', [App\Http\Controllers\UnionController::class, 'index']);
    Route::get('/getUnion', [App\Http\Controllers\UnionController::class, 'getUnionData']);
    Route::post('/delete_union', [App\Http\Controllers\UnionController::class, 'destroy']);
    Route::get('/load_upazila_wise', [App\Http\Controllers\UnionController::class, 'getUpazilaWise']);
    Route::get('/union_store', [App\Http\Controllers\UnionController::class, 'store'])->name('union.store');
    Route::get('/search_union', [App\Http\Controllers\UnionController::class, 'searchUnion']);
    Route::get('/generate_union_excel_file', [App\Http\Controllers\UnionController::class, 'generateUnionExcelFile']);

    Route::get('/post_office', [App\Http\Controllers\PostOfficeController::class, 'index']);
    Route::get('/getPostOffice', [App\Http\Controllers\PostOfficeController::class, 'getPostOfficeData']);
    Route::get('/post_office_store', [App\Http\Controllers\PostOfficeController::class, 'store'])->name('post_office.store');
    Route::get('/load_union_upozila_wise', [App\Http\Controllers\PostOfficeController::class, 'loadUnionUpozilaWise']);
    Route::get('/generate_post_office_excel_file', [App\Http\Controllers\PostOfficeController::class, 'generatePostOfficeExcelFile']);
    Route::get('/search_post_office', [App\Http\Controllers\PostOfficeController::class, 'searchPostOffice']);
    Route::post('/delete_post_office', [App\Http\Controllers\PostOfficeController::class, 'destroy']);

    Route::get('/city_corporation', [App\Http\Controllers\CityCorporationController::class, 'index']);
    Route::get('/getCityCorporation', [App\Http\Controllers\CityCorporationController::class, 'getCityCorporationData']);
    Route::get('/city_corporation_store', [App\Http\Controllers\CityCorporationController::class, 'store'])->name('city_corporation.store');
    Route::get('/generate_city_corporation_excel_file', [App\Http\Controllers\CityCorporationController::class, 'generateCityCorporationExcelFile']);
    Route::get('/search_city_corporation', [App\Http\Controllers\CityCorporationController::class, 'searchCityCorporation']);
    Route::post('/delete_city_corporation', [App\Http\Controllers\CityCorporationController::class, 'destroy']);

    Route::get('/city_corporation_word', [App\Http\Controllers\CityCorporationWordController::class, 'index']);
    Route::get('/getCityCorporationWord', [App\Http\Controllers\CityCorporationWordController::class, 'getCityCorporationWordData']);
    Route::get('/city_corporation_word_store', [App\Http\Controllers\CityCorporationWordController::class, 'store'])->name('city_corporation_word.store');
    Route::get('/load_city_corporation_district_wise', [App\Http\Controllers\CityCorporationWordController::class, 'loadCityCorporationDistrictWise']);
    Route::get('/generate_city_corporation_word_excel_file', [App\Http\Controllers\CityCorporationWordController::class, 'generateCityCorporationWordExcelFile']);
    Route::get('/search_city_corporation_word', [App\Http\Controllers\CityCorporationWordController::class, 'searchCityCorporationWord']);
    Route::post('/delete_city_corporation_word', [App\Http\Controllers\CityCorporationWordController::class, 'destroy']);

    Route::get('/pouroshova', [App\Http\Controllers\PouroshovaController::class, 'index']);
    Route::get('/getPouroshova', [App\Http\Controllers\PouroshovaController::class, 'getPouroshovaData']);
    Route::get('/pouroshova_store', [App\Http\Controllers\PouroshovaController::class, 'store'])->name('pouroshova.store');
    Route::get('/generate_pouroshova_excel_file', [App\Http\Controllers\PouroshovaController::class, 'generatePouroshovaExcelFile']);
    Route::get('/search_pouroshova', [App\Http\Controllers\PouroshovaController::class, 'searchPouroshova']);
    Route::post('/delete_pouroshova', [App\Http\Controllers\PouroshovaController::class, 'destroy']);

    Route::get('/pouroshova_word', [App\Http\Controllers\PouroshovaWordController::class, 'index']);
    Route::get('/getPouroshovaWord', [App\Http\Controllers\PouroshovaWordController::class, 'getPouroshovaWordData']);
    Route::get('/pouroshova_word_store', [App\Http\Controllers\PouroshovaWordController::class, 'store'])->name('pouroshova_word.store');
    Route::get('/load_pouroshova_upozila_wise', [App\Http\Controllers\PouroshovaWordController::class, 'loadPouroshovaUpozilaWise']);
    Route::get('/generate_pouroshova_word_excel_file', [App\Http\Controllers\PouroshovaWordController::class, 'generatePouroshovaWordExcelFile']);
    Route::get('/search_pouroshova_word', [App\Http\Controllers\PouroshovaWordController::class, 'searchPouroshovaWord']);
    Route::post('/delete_pouroshova_word', [App\Http\Controllers\PouroshovaWordController::class, 'destroy']);

    Route::post('/get-geo-location-logs', [App\Http\Controllers\GeoLocationLogController::class, 'index']);

    Route::get('/office_ministry', [App\Http\Controllers\OfficeMinistryController::class, 'index']);
    Route::get('/getOfficeMinistry', [App\Http\Controllers\OfficeMinistryController::class, 'getOfficeMinistryData']);
    Route::get('/office_ministry_store', [App\Http\Controllers\OfficeMinistryController::class, 'store'])->name('office_ministry.store');
    Route::get('/generate_office_ministry_excel_file', [App\Http\Controllers\OfficeMinistryController::class, 'generateOfficeMinistryExcelFile']);
    Route::get('/search_office_ministry', [App\Http\Controllers\OfficeMinistryController::class, 'searchOfficeMinistry']);
    Route::post('/delete_office_ministry', [App\Http\Controllers\OfficeMinistryController::class, 'destroy']);

    Route::get('/office_custom_layer', [App\Http\Controllers\OfficeCustomLayerController::class, 'index']);
    Route::get('/getOfficeCustomLayer', [App\Http\Controllers\OfficeCustomLayerController::class, 'getOfficeCustomLayer']);
    Route::get('/office_custom_layer_store', [App\Http\Controllers\OfficeCustomLayerController::class, 'store'])->name('custom_office_layer.store');
    Route::get('/custom_layer_office_mapping', [App\Http\Controllers\OfficeCustomLayerController::class, 'customLayerOfficeMapping']);
    Route::get('/load_custom_layer_wise_office', [App\Http\Controllers\OfficeCustomLayerController::class, 'loadCustomLayerWiseOffice']);
    Route::get('/search_custom_layer', [App\Http\Controllers\OfficeCustomLayerController::class, 'searchCustomLayer']);
    Route::post('/delete_custom_layer', [App\Http\Controllers\OfficeCustomLayerController::class, 'destroy']);
    Route::get('/generate_office_custom_layer_excel_file', [App\Http\Controllers\OfficeCustomLayerController::class, 'generateOfficeCustomLayerExcelFile']);

    Route::get('/office_layer', [App\Http\Controllers\OfficeLayerController::class, 'index']);
    Route::get('/load_layer_ministry_wise', [App\Http\Controllers\OfficeLayerController::class, 'loadLayerMinistryWise']);
    Route::get('/load_layer_tree', [App\Http\Controllers\OfficeLayerController::class, 'loadLayerTree']);
    Route::get('/load_layer_store', [App\Http\Controllers\OfficeLayerController::class, 'store'])->name('office_layer.store');
    Route::get('/edit_layer', [App\Http\Controllers\OfficeLayerController::class, 'edit']);

    Route::get('/office_layer_search', [App\Http\Controllers\OfficeLayerController::class, 'officeLayerSearch']);
    Route::get('/get_office_layer_list', [App\Http\Controllers\OfficeLayerController::class, 'getOfficeLayerData']);
    Route::get('/office_layer_search_by_name', [App\Http\Controllers\OfficeLayerController::class, 'searchOfficeLayerByName']);
    Route::post('/delete_office_layer', [App\Http\Controllers\OfficeLayerController::class, 'destroy']);
    Route::get('/generate_layer_search_excel_file', [App\Http\Controllers\OfficeLayerController::class, 'generateOfficeLayerSearchExcelFile']);

    Route::get('/layer_wise_office_list', [App\Http\Controllers\OfficeLayerController::class, 'layerWiseOfficeList']);
    Route::get('/load_ministry_wise_layer_list', [App\Http\Controllers\OfficeLayerController::class, 'loadMinistryWiseLayerList']);
    Route::get('/ministry_wise_layer_mapping', [App\Http\Controllers\OfficeLayerController::class, 'ministryWiseLayerMapping']);
    Route::get('/load_layer_and_custom_layer_ministry_wise', [App\Http\Controllers\OfficeLayerController::class, 'loadLayerAndCustomLayerMinistryWise']);

    Route::get('/layer_store', [App\Http\Controllers\OfficeLayerController::class, 'layerStore'])->name('layer.store');

    Route::get('/office_origins', [App\Http\Controllers\OfficeOriginController::class, 'index']);
    Route::get('/getOfficeOrigin', [App\Http\Controllers\OfficeOriginController::class, 'getOfficeOriginData']);
    Route::get('/office_origin_store', [App\Http\Controllers\OfficeOriginController::class, 'store'])->name('office_origin.store');
    Route::get('/load_ministry_parent_origin', [App\Http\Controllers\OfficeOriginController::class, 'loadMinistryParentOrigin']);
    Route::get('/office_origin_server_side', [App\Http\Controllers\OfficeOriginController::class, 'officeOriginServerSide']);

    // Route::get('/office_origin_delete/', [App\Http\Controllers\OfficeOriginController::class, 'destroy']);
    Route::get('/generate_office_origin_excel_file', [App\Http\Controllers\OfficeOriginController::class, 'generateOfficeOriginExcelFile']);
    Route::get('/search_office_origins', [App\Http\Controllers\OfficeOriginController::class, 'searchOfficeOrigins']);
    Route::post('/delete_office_origin', [App\Http\Controllers\OfficeOriginController::class, 'destroy']);
    Route::get('/get_origin_office_info', [App\Http\Controllers\OfficeOriginController::class, 'get_origin_office_info']);

    Route::get('/office_origin_unit', [App\Http\Controllers\OfficeOriginUnitController::class, 'index']);
    Route::get('/getOfficeOriginUnit', [App\Http\Controllers\OfficeOriginUnitController::class, 'getOfficeOriginUnitData']);
    Route::post('/office_origin_unit_store', [App\Http\Controllers\OfficeOriginUnitController::class, 'store'])->name('office_origin_unit.store');
    Route::get('/load_office_unit_origin_unit_tree', [App\Http\Controllers\OfficeOriginUnitController::class, 'loadOfficeOriginUnitTree']);
    Route::get('/edit_office_origin_unit', [App\Http\Controllers\OfficeOriginUnitController::class, 'editOfficeOriginUnit']);
    Route::get('/load_parent_office_origin_unit', [App\Http\Controllers\OfficeOriginUnitController::class, 'loadParentOfficeOriginUnit']);

    Route::get('/ministry_and_layer_wise_office_select', [App\Http\Controllers\OfficeController::class, 'getMinistryAndLayerWiseOfficeSelect']);

    //	Route::get('/office_origin_unit_organogram', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'index']);
    ////Route::get('/getOfficeOriginUnit', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'getOfficeOriginUnitData']);
    //	Route::get('/load_office_origin_unit_organogram_tree', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'loadOfficeOriginUnitOrganogramTree']);
    //	Route::get('/office_origin_unit_organogram_store', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'store'])->name('office_origin_unit_organogram.store');
    //	Route::get('/edit_office_origin_unit_organogram', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'editOfficeOriginUnitOrganogram']);

    Route::get('/office_unit_category', [App\Http\Controllers\OfficeUnitCategoryController::class, 'index']); //moulik_office_sakhar_prokar
    Route::get('/getOfficeUnitCategory', [App\Http\Controllers\OfficeUnitCategoryController::class, 'getOfficeUnitCategoryData']);
    Route::post('/office_unit_category_store', [App\Http\Controllers\OfficeUnitCategoryController::class, 'store'])->name('office_unit_category.store');
    Route::post('/category_delete/', [App\Http\Controllers\OfficeUnitCategoryController::class, 'destroy']);
    Route::get('/search_unit_category', [App\Http\Controllers\OfficeUnitCategoryController::class, 'searchUnitCategory']);
    Route::get('/generate_unit_category_excel_file', [App\Http\Controllers\OfficeUnitCategoryController::class, 'generateOfficeUnitCategoryExcelFile']);


    Route::get('/office', [App\Http\Controllers\OfficeController::class, 'index']);
    Route::post('/office_store', [App\Http\Controllers\OfficeController::class, 'store'])->name('office.store');
    Route::get('/load_office_origin_tree', [App\Http\Controllers\OfficeController::class, 'loadOfficeOriginTree']);
    Route::get('/load_office_tree_origin_wise', [App\Http\Controllers\OfficeController::class, 'loadOfficeTreeOriginWise']);
    Route::get('/get_office_layer_id', [App\Http\Controllers\OfficeController::class, 'getOfficeLayerId']);
    Route::post('/get_custom_layer_id', [App\Http\Controllers\OfficeController::class, 'getCustomLayerId']);
    Route::get('/get_office_info', [App\Http\Controllers\OfficeController::class, 'getOfficeInfo']);
    Route::get('/office_edit', [App\Http\Controllers\OfficeController::class, 'officeEdit']);
    Route::put('/office_update', [App\Http\Controllers\OfficeController::class, 'officeUpdate']);
    Route::post('/office_delete', [App\Http\Controllers\OfficeController::class, 'destroy']);
    Route::get('/get_office_wise_edit_list', [App\Http\Controllers\OfficeController::class, 'getOfficeWiseEditList']);

    Route::post('/get_office_origin_data', [App\Http\Controllers\OfficeController::class, 'OfficeOriginData'])->name('get_office_origin_data');
    Route::post('/office_origin_remove', [App\Http\Controllers\OfficeController::class, 'OfficeOriginRemove'])->name('office_origin_remove');
    Route::get('/load_parent_office', [App\Http\Controllers\OfficeController::class, 'loadParentOffice']);
    // list all offices
    Route::get('/officeList/', [App\Http\Controllers\OfficeController::class, 'officeList']);
    Route::get('/get_office_mapping_info', [App\Http\Controllers\OfficeController::class, 'getOfficeMappingInfo']);

    //load_statistics
    Route::get('/load_active_offices', [App\Http\Controllers\OfficeController::class, 'loadOfficeStatistics']);
    Route::get('/load_active_units', [App\Http\Controllers\OfficeController::class, 'loadUnitStatistics']);
    Route::get('/load_active_organograms', [App\Http\Controllers\OfficeController::class, 'loadOrganogramStatistics']);
    Route::get('/load_all_users', [App\Http\Controllers\OfficeController::class, 'loadAllUsers']);

    Route::get('/office_unit', [App\Http\Controllers\OfficeUnitController::class, 'index']);
    Route::post('/load_office_origin_by_current_office_id', [App\Http\Controllers\OfficeUnitController::class, 'loadOfficeOriginByCurrentOffice']);
    Route::get('/load_office_origin_unit_tree', [App\Http\Controllers\OfficeUnitController::class, 'loadOfficeOriginUnitTree']);
    Route::get('/load_office_unit_tree', [App\Http\Controllers\OfficeUnitController::class, 'loadOfficeUnitTree']);
    Route::post('/generate_origin_tree_data', [App\Http\Controllers\OfficeUnitController::class, 'generateOriginTreeData']);
    Route::post('/generate_office_tree_data', [App\Http\Controllers\OfficeUnitController::class, 'generateOfficeTreeData']);
    Route::get('/rename_office_unit', [App\Http\Controllers\OfficeUnitController::class, 'renameUnit']);
    Route::get('/office_unit_rename_tracking', [App\Http\Controllers\OfficeUnitController::class, 'renameUnitTracking']);
    Route::get('/generate_rename_unit_excel_file', [App\Http\Controllers\OfficeUnitController::class, 'generateRenameUnitEexcelFile']);
    Route::post('/getUnitNameList', [App\Http\Controllers\OfficeUnitController::class, 'getUnitNameList']);
    Route::post('/getUnitNameTrackingList', [App\Http\Controllers\OfficeUnitController::class, 'getUnitNameTrackingList']);
    Route::get('/get_office_unit/{any}', [App\Http\Controllers\OfficeUnitController::class, 'getOfficeUnit']);
    Route::post('/office_unit_update', [App\Http\Controllers\OfficeUnitController::class, 'officeUnitUpdate']);
    Route::get('/search_unit_by_name', [App\Http\Controllers\OfficeUnitController::class, 'searchUnitByName']);
    Route::get('/office_unit_transfer', [App\Http\Controllers\OfficeUnitController::class, 'officeUnitTransfer']);
    Route::get('/load_office_unit_office_wise', [App\Http\Controllers\OfficeUnitController::class, 'loadOfficeUnitOfficeWise']);
    Route::get('/get_office_unit_history/{any}', [App\Http\Controllers\OfficeUnitController::class, 'getOfficeUnitHistory']);

    Route::get('/login_tracking', [App\Http\Controllers\TrackingController::class, 'loginTracking']);
    Route::post('/login_tracking/history', [App\Http\Controllers\TrackingController::class, 'loadLoginHistory'])->name('login_history');

    Route::get('/rename_office_designation', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'renameOfficeDesignation']);
    Route::get('/rename_office_designation_tracking', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'renameOfficeDesignationTracking']);
    Route::post('/get_office_designation_list', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'getOfficeDesignationList']);
    Route::post('/get_office_designation_track_list', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'getOfficeDesignationTrackList']);
    Route::get('/get_office_designation/{any}', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'getOfficeDesignation']);
    Route::post('/office_designation_update', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'officeDesignationUpdate']);
    Route::get('/search_designation_by_name', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'searchofficeDesignation']);
    Route::get('/load_designation_office_unit_wise', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'loadDesignationOfficeUnitWise']);

    Route::get('/generate_rename_office_designation_excel_file', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'generateRenameOfficeDesignationExcelFile']);
    Route::get('/get_office_designation_history/{any}', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'getOfficeDesignationHistory']);

    Route::get('/designation_transfer', [\App\Http\Controllers\OfficeUnitOrganogramController::class, 'transferDesignation']);
    Route::post('/load_office_wise_unit_with_organogram_tree', [\App\Http\Controllers\OfficeUnitOrganogramController::class, 'loadOfficeWiseUnitWithOrganogramTree']);
    Route::post('/fire_designation_transfer_action', [\App\Http\Controllers\OfficeUnitOrganogramController::class, 'fireTransferDesignationAction']);

    Route::get('/office_unit_organogram', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'index']);
    Route::get('/load_origin_unit_organogram_tree', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'loadOriginUnitOrganogramTree']);
    Route::get('/load_unit_organogram_tree', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'loadUnitOrganogramTree']);
    Route::get('/load_unit_organogram_tree_view', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'load_unit_organogram_tree_view']);
    Route::post('/generate_origin_organogram_tree_data', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'generateOriginOrganogramTreeData']);
    Route::post('/generate_office_organogram_tree_data', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'generateOfficeOrganogramTreeData']);
    Route::get('/designation_tree_view', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'designationTreeView']);
    Route::get('/load_org_wise_data', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'loadOrgWiseData']);

    Route::get('/employee_management_batch', [App\Http\Controllers\EmployeeBatchController::class, 'index']);
    Route::get('/getEmployeeBatch', [App\Http\Controllers\EmployeeBatchController::class, 'getEmployeeBatchData']);
    Route::post('/employee_batch_store', [App\Http\Controllers\EmployeeBatchController::class, 'store'])->name('employee_batch.store');
    Route::get('/generate_employee_management_batch_excel_file', [App\Http\Controllers\EmployeeBatchController::class, 'generateEmployeeManagementBatchExcelFile']);
    Route::get('/search_batch', [App\Http\Controllers\EmployeeBatchController::class, 'searchBatch']);
    Route::post('/delete_batch', [App\Http\Controllers\EmployeeBatchController::class, 'destroy']);

    Route::get('/employee_management_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'index']);
    Route::get('/getEmployeeCadre', [App\Http\Controllers\EmployeeCadreController::class, 'getEmployeeCadreData']);
    Route::post('/employee_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'store'])->name('employee_cadre.store');
    Route::get('/generate_employee_management_cadre_excel_file', [App\Http\Controllers\EmployeeCadreController::class, 'generateEmployeeManagementCadreExcelFile']);
    Route::get('/change_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'changeCadre']);
    Route::get('/get_cadre_info', [App\Http\Controllers\EmployeeCadreController::class, 'getCadreInfo']);
    Route::post('/change_to_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'changeToCadre']);
    Route::post('/change_to_non_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'changeToNonCadre']);
    Route::get('/change_one_to_other_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'changeOneToOtherCadre']);
    Route::get('/get_only_cadre_info', [App\Http\Controllers\EmployeeCadreController::class, 'getOnlyCadreInfo']);
    Route::get('/search_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'searchCadre']);
    Route::post('/delete_cadre', [App\Http\Controllers\EmployeeCadreController::class, 'destroy']);

    Route::get('/employee_office_management', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'index']);
    Route::get('/employee_office_management_nid_tracking', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'nidTracking']);
    Route::get('/get_employee_info', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'getEmployeeInfo'])->name('get_employee_info');
    Route::get('/disable_designation', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'disableDesignation']);
    Route::get('/load_office_wise_units', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'loadOfficeWiseUnits']);
    Route::post('/assing_office_employee', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'store']);

    Route::get('/load_unassign_office_admin/{any}', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'loadUnassignOfficeAdmin']);

    Route::get('/check_office_admin/{any}', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'officeAdminChecking']);

    Route::get('/unassign_office_admin/{any}', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'unassignOfficeAdmin']);
    Route::get('/release_assign_user/{any}', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'releaseAssignUser']);
    // designation label 18 Aug 22
    Route::get('/designation_lebel', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'designationLebel']);
    Route::get('/designation_label_list', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'designationLabelList']);
    Route::get('save/designation_label', [App\Http\Controllers\OfficeUnitOrganogramController::class, 'saveDesignationLabel'])->name('save.designation_lebel');

    // office unit wise employee
    Route::get('/office_unit_wise_employee', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'officeUnitWiseEmployee']);
    Route::post('/employee_management', [App\Http\Controllers\EmployeeOfficeManagementController::class, 'employeeManagement']);

    Route::get('/office_origin_unit_organogram', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'index']);
    Route::get('/load_office_origin_unit_organogram_tree', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'loadOfficeOriginUnitOrganogramTree']);
    Route::post(
        '/office_origin_unit_organogram_store',
        [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'store']
    )->name('office_origin_unit_organogram.store');
    Route::get('/edit_office_origin_unit_organogram', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'editOfficeOriginUnitOrganogram']);
    Route::post(
        '/delete_office_origin_unit_organogram',
        [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'deleteOfficeOriginUnitOrganogram']
    );
    Route::get('/load_unit_wise_organogram', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'loadUnitWiseOrganogram']);
    Route::get('/load_origin_wise_units', [App\Http\Controllers\OfficeOriginUnitOrganogramController::class, 'loadOriginWiseUnits']);

    Route::get('/employee_record', [App\Http\Controllers\EmployeeRecordController::class, 'index']);
    Route::get('/create_employee', [App\Http\Controllers\EmployeeRecordController::class, 'create']);
    Route::get('/create_employee_by_office_admin', [App\Http\Controllers\EmployeeRecordController::class, 'createEmployeeByOfficeAdmin']);
    Route::post('/store_employee_by_office_admin', [App\Http\Controllers\EmployeeRecordController::class, 'storeEmployeeByOfficeAdmin']);
    Route::get('/edit_employee/{any}', [App\Http\Controllers\EmployeeRecordController::class, 'edit']);
    Route::get('/getEmployeeRecord', [App\Http\Controllers\EmployeeRecordController::class, 'getEmployeeRecordData']);
    Route::get('/employee_record_server_side', [App\Http\Controllers\EmployeeRecordController::class, 'getEmployeeRecordServerSide']);
    Route::get('/get_assign_employee_info', [App\Http\Controllers\EmployeeRecordController::class, 'getAssignEmployeeInfo']);
    Route::get('/get_assign_organogram_info', [App\Http\Controllers\EmployeeRecordController::class, 'getAssignOrganogramInfo'])->name('employee_record.show_history');
    Route::post('/employee_record_store', [App\Http\Controllers\EmployeeRecordController::class, 'store'])->name('employee_record.store');
    Route::get('/employee_wating_record', [App\Http\Controllers\EmployeeRecordController::class, 'employeeWatingRecord']);
    // Route::get('/load_office_layer_ministry_wise', [App\Http\Controllers\EmployeeRecordController::class, 'loadOfficeLayerMinistryWise']);
    Route::get('/load_office_origin_layer_wise', [App\Http\Controllers\EmployeeRecordController::class, 'loadOfficeOriginLayerWise']);
    Route::post('/delete_employee', [App\Http\Controllers\EmployeeRecordController::class, 'destroy']);
    Route::get('/nid_validation', function (Request $request) {
        $response = NidVerify(date('Y-m-d', strtotime($request->dob)), $request->nid);
        return response(['status' => 'success', 'msg' => $response->json()]);
    });

    Route::get('/employee_work_history', [App\Http\Controllers\EmployeeRecordController::class, 'employeeWorkHistory']);
    Route::post('/employee_record_search', [App\Http\Controllers\EmployeeRecordController::class, 'searchEmployee'])->name('employee_record.search_employee');
    Route::get('/employee_search_by_all_info', [App\Http\Controllers\EmployeeRecordController::class, 'searchEmployeeRecord']);
    Route::get('/get_wating_employeerecord_data', [App\Http\Controllers\EmployeeRecordController::class, 'getWatingEmployeeRecordData']);
    Route::get('/search_wating_employeerecord', [App\Http\Controllers\EmployeeRecordController::class, 'searchWatingEmployeeRecord']);
    Route::get('/get_work_history_info', [App\Http\Controllers\EmployeeRecordController::class, 'employeeWorkHistoryInfo']);
    Route::post('/work_history_update', [App\Http\Controllers\EmployeeRecordController::class, 'employeeWorkHistoryUpdate'])->name('work_history_update');

    // office wise employee
    Route::get('office_wise_employee', [App\Http\Controllers\EmployeeRecordController::class, 'officeWiseEmployee']);
    Route::get('/generate_office_wise_employee_excel_file', [App\Http\Controllers\EmployeeRecordController::class, 'generateOfficeWiseEmployeeExcelFile']);
    Route::get('get_office_wise_employee_list', [App\Http\Controllers\EmployeeRecordController::class, 'getOfficeWiseEmployeeRecordData']);
    Route::get('search_office_wise_employee_list', [App\Http\Controllers\EmployeeRecordController::class, 'searchOfficeWiseEmployeeRecordData']);
    // office admin
    Route::resource('/office_admin', OfficeAdminController::class);
    Route::get('get_office_layer', [OfficeAdminController::class, 'get_office_layer']);
    Route::get('get_office_origin', [OfficeAdminController::class, 'get_office_origin']);
    Route::get('get_office', [OfficeAdminController::class, 'get_office']);
    Route::get('get_office_admins', [OfficeAdminController::class, 'get_office_admins']);

    // office notification change
    Route::resource('/office_notification', OfficeAdminController::class);
    Route::get('get_office_notification_list', [OfficeAdminController::class, 'get_office_notification_list']);

    // section and designation setting
    Route::get('section_designation_setting', [OfficeAdminController::class, 'section_designation_setting']);
    Route::get('get_office_by_ministry_and_layer', [OfficeAdminController::class, 'get_office_by_ministry_and_layer']);
    Route::post('section_designation_update', [OfficeAdminController::class, 'section_designation_update']);

    // office wise designation update
    Route::get('office_designation_update', [App\Http\Controllers\EmployeeSettingController::class, 'officeEmployeeDesignation']);
    Route::get('office_designation_update_list', [App\Http\Controllers\EmployeeSettingController::class, 'officeEmployeeDesignationUpdateList']);
    Route::post('get_office_employee_designation', [App\Http\Controllers\EmployeeSettingController::class, 'getOfficeEmployeeDesignation']);
    Route::post('office_employee_designation_update', [App\Http\Controllers\EmployeeSettingController::class, 'OfficeEmployeeDesignationUpdate']);
    Route::get('/generate_employee_designation_excel_file', [App\Http\Controllers\EmployeeSettingController::class, 'generateEmployeeDesignationExcelFile']);


    // office wise section visibility setting
    Route::get('office_section_visibility', [App\Http\Controllers\EmployeeSettingController::class, 'officeSectionVisibility']);
    Route::post('office_section_visibility_update', [App\Http\Controllers\EmployeeSettingController::class, 'officeSectionVisibilityUpdate']);
    // office front desk
    Route::get('office_front_desk', [OfficeAdminController::class, 'office_front_desk']);
    Route::post('get_office_front_desk_list', [OfficeAdminController::class, 'get_office_front_desk_list']);
    Route::get('assign_front_desk', [OfficeAdminController::class, 'assign_front_desk']);

    // office head
    Route::get('office_head', [OfficeAdminController::class, 'officeHead']);
    Route::post('get_office_head', [OfficeAdminController::class, 'getOfficeHead']);
    Route::get('assign_office_head', [OfficeAdminController::class, 'assignOfficeHead']);
    Route::get('search_office_head', [OfficeAdminController::class, 'searchOfficeHead']);

    //office admin
    Route::get('/office_admin_responsibility', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'index']);
    Route::get('/load_office_wise_users', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'loadOfficeWiseOrganogram']);
    Route::get('/assign_office_admin', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'assignOfficeAdmin']);

    Route::get('/office_admin_responsibility_log', [App\Http\Controllers\OfficeResponsibilityHistoryController::class, 'officeAdminResponsibilityLog']);
    Route::post('/office_admin_responsibility_log_list', [App\Http\Controllers\OfficeResponsibilityHistoryController::class, 'officeAdminResponsibilityLogList']);

    Route::get('/office_head_responsibility_log', [App\Http\Controllers\OfficeResponsibilityHistoryController::class, 'officeHeadResponsibilityLog']);
    Route::post('/office_head_responsibility_log_list', [App\Http\Controllers\OfficeResponsibilityHistoryController::class, 'officeHeadResponsibilityLogList']);

    Route::get('/office_unit_admin_responsibility_log', [App\Http\Controllers\OfficeResponsibilityHistoryController::class, 'officeUnitAdminResponsibilityLog']);
    Route::post('/office_unit_admin_responsibility_log_list', [App\Http\Controllers\OfficeResponsibilityHistoryController::class, 'officeUnitAdminResponsibilityLogList']);

    Route::get('/test_component', [App\Http\Controllers\AssignOfficeAdminResponsibilityController::class, 'testComponent']);

    //office unit admin
    Route::get('/office_unit_admin_responsibility', [App\Http\Controllers\AssignOfficeUnitAdminResponsibilityController::class, 'index'])->name('office_unit_admin_responsibility');
    Route::get('/load_office_unit_wise_users', [App\Http\Controllers\AssignOfficeUnitAdminResponsibilityController::class, 'loadOfficeUnitWiseOrganogram'])->name('office_unit.load_office_unit_wise_users');
    Route::get('/assign_office_unit_admin', [App\Http\Controllers\AssignOfficeUnitAdminResponsibilityController::class, 'assignOfficeUnitAdmin'])->name('assign_office_unit_admin');

    // office unit head
    Route::get('office_unit_head', [App\Http\Controllers\OfficeUnitHeadController::class, 'index']);
    Route::get('load_office_unit_wise_users_unit_head', [App\Http\Controllers\OfficeUnitHeadController::class, 'loadOfficeUnitWiseOrganogram']);
    Route::post('assign_office_unit_head', [App\Http\Controllers\OfficeUnitHeadController::class, 'assignOfficeUnitHead']);
    Route::get('search_office_unit_head', [\App\Http\Controllers\OfficeUnitHeadController::class, 'searchOfficeUnitHead']);

    // Role
    Route::get('role', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');
    Route::get('role/getRole', [App\Http\Controllers\RoleController::class, 'getRoleData']);
    Route::get('role/role_store', [App\Http\Controllers\RoleController::class, 'storeRole'])->name('role.store');
    Route::get('role/menus', [App\Http\Controllers\RoleController::class, 'menu'])->name('role.menus');
    // Role Menu
    Route::get('role/get_menus', [App\Http\Controllers\RoleController::class, 'getMenus'])->name('role.get_menus');
    Route::get('role/store_menus', [App\Http\Controllers\RoleController::class, 'storeMenus'])->name('role.store_menus');
    //Role Menu Map
    Route::get('role/assign', [App\Http\Controllers\RoleController::class, 'assignRole'])->name('role.assign');
    Route::get('role/get_menu_for_role_assign', [App\Http\Controllers\RoleController::class, 'getMenuForRoleAssign'])->name('role.assign_get_menu');
    Route::get('role/assign_map', [App\Http\Controllers\RoleController::class, 'assignMap'])->name('role.assign_map');

    // office admin
    Route::get('/layer_offices', [App\Http\Controllers\OfficeLayersController::class, 'index'])->name('layer_offices');

    //User Profile
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('change-profile/overview', [\App\Http\Controllers\UserController::class, 'overview']);
    Route::post('change-profile/info-change-form', [\App\Http\Controllers\UserController::class, 'infoChangeForm']);
    Route::post('change-profile/work-history', [\App\Http\Controllers\UserController::class, 'workHistory']);
    Route::post('change-profile/pass-area', [\App\Http\Controllers\UserController::class, 'password']);
    Route::post('change-profile/image', [\App\Http\Controllers\UserController::class, 'image']);
    Route::post('change-profile/signature', [\App\Http\Controllers\UserController::class, 'signature']);
    Route::post('change-profile/protikolpo', [\App\Http\Controllers\UserController::class, 'protikolpoInProfile']);
    Route::post('change-profile/notification', [\App\Http\Controllers\UserController::class, 'notification']);
    Route::post('change-profile/digital-certificate', [\App\Http\Controllers\UserController::class, 'digitalCertificate']);

    Route::post('digital-certificate/get-certificate', [\App\Http\Controllers\DigitalCertificateController::class, 'getCertificate'])->name('digital-certificate.get-certificate');
    Route::get('get-web-certificate', [\App\Http\Controllers\DigitalCertificateController::class, 'getWebCertificate'])->name('getWebCertificate');

    Route::post('/profile/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/password', [App\Http\Controllers\UserController::class, 'password'])->name('password');
    Route::post('/profile/password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('password.change');
    Route::get('/profile/image', [App\Http\Controllers\UserController::class, 'image'])->name('image');
    Route::post('/profile/image', [App\Http\Controllers\UserController::class, 'changeImage'])->name('image.change');
    Route::get('/profile/signiture', [App\Http\Controllers\UserController::class, 'signiture'])->name('signiture');
    Route::post('/profile/signiture', [App\Http\Controllers\UserController::class, 'changeSigniture'])->name('signiture.change');
    Route::get('/profile/notifications', [App\Http\Controllers\UserController::class, 'notification'])->name('notification');
    Route::post('/profile/notifications', [App\Http\Controllers\UserController::class, 'changeNotification'])->name('notification.change');
    Route::post('/check_user_alias', [App\Http\Controllers\UserController::class, 'checkUserAlias']);
    Route::post('/get_user_by_username_or_alias', [App\Http\Controllers\EmployeeRecordController::class, 'getEmployeeByUsernameOrAlias']);

    Route::group(['as' => 'user.', 'prefix' => 'user/'], function () {
        Route::get('add', [App\Http\Controllers\UserController::class, 'add'])->name('add');
        Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('list', [App\Http\Controllers\UserController::class, 'list'])->name('list');
        Route::post('delete', [App\Http\Controllers\UserController::class, 'delete'])->name('delete');
        Route::get('get_user_list', [App\Http\Controllers\UserController::class, 'getUserList'])->name('get_user_list');
        Route::get('user_list_server_side', [App\Http\Controllers\UserController::class, 'userListServerSide'])->name('user_list_server_side');
    });


    Route::resource('globalMessages', App\Http\Controllers\globalMessagesController::class);
    Route::get('msgList', [App\Http\Controllers\globalMessagesController::class, 'list'])->name('msgList');
    Route::get('loadLayersByMinistry/{id?}', [App\Http\Controllers\globalMessagesController::class, 'loadLayersByMinistry'])->name('loadLayersByMinistry');
    Route::get('loadOriginOffices/{id?}', [App\Http\Controllers\globalMessagesController::class, 'loadOriginOffices'])->name('loadOriginOffices');
    Route::get('loadOfficeUnits/{id?}', [App\Http\Controllers\globalMessagesController::class, 'loadOfficeUnits'])->name('loadOfficeUnits');
    Route::get('loadOfficeUnitOrganograms/{id?}', [App\Http\Controllers\globalMessagesController::class, 'loadOfficeUnitOrganogramsWithName'])->name('loadOfficeUnitOrganograms');
    Route::get('loadOfficesByMinistryAndLayer/{id?}/{layer?}', [App\Http\Controllers\globalMessagesController::class, 'loadOfficesByMinistryAndLayer'])->name('loadOfficesByMinistryAndLayer');
    Route::get('/notification_message', [App\Http\Controllers\globalMessagesController::class, 'notificationMessage']);
    Route::get('/show_popup_notification', [App\Http\Controllers\globalMessagesController::class, 'showPopUpNotification']);
    Route::get('/get_unit_list', [App\Http\Controllers\globalMessagesController::class, 'getUnitList']);
    Route::get('/get_unit_organogram_list', [App\Http\Controllers\globalMessagesController::class, 'getUnitOrganogramList']);

    Route::get('protikolpo_management', [App\Http\Controllers\ProtikolpoController::class, 'index']);
    Route::get('protikolpo_status', [App\Http\Controllers\ProtikolpoController::class, 'protikolpoStatus']);
    Route::get('get_portikolpo_list', [App\Http\Controllers\ProtikolpoController::class, 'getProtikolpoList']);
    Route::get('get_officer_name', [App\Http\Controllers\ProtikolpoController::class, 'getOfficerName']);
    Route::post('set_protikolpo', [App\Http\Controllers\ProtikolpoController::class, 'store']);
    Route::post('assign_protikolpo', [App\Http\Controllers\ProtikolpoController::class, 'assignProtikolpo']);
    Route::post('active_protikolpo', [App\Http\Controllers\ProtikolpoController::class, 'activeProtikolpo']);
    Route::post('cancel_protikolpo', [App\Http\Controllers\ProtikolpoController::class, 'cancelProtikolpo']);
    Route::post('cancel_protikolpo_by_user', [App\Http\Controllers\ProtikolpoController::class, 'cancelProtikolpoByUser']);
    Route::post('update_protikolpo', [App\Http\Controllers\ProtikolpoController::class, 'updateProtikolpo']);
    Route::post('update_protikolpo_by_user', [App\Http\Controllers\ProtikolpoController::class, 'updateProtikolpoByUser']);
    Route::post('get_protikolpo_status_list', [App\Http\Controllers\ProtikolpoController::class, 'getProtikolpoStatus']);
    Route::get('protikolpo_revert', [App\Http\Controllers\ProtikolpoController::class, 'protikolpoRevert']);
    Route::post('employee_protikolpo_list', [App\Http\Controllers\ProtikolpoController::class, 'emoployeeProtikolpoList']);
    Route::post('get_protikolpo_log', [App\Http\Controllers\ProtikolpoController::class, 'getProtikolpoLog']);

    Route::get('application_registration_approved', [App\Http\Controllers\ApplicationRegistrationController::class, 'index']);
    Route::get('application_registration_approved_list', [App\Http\Controllers\ApplicationRegistrationController::class, 'approvedApplicationsList']);
    Route::get('generate_approved_application_excel_file', [App\Http\Controllers\ApplicationRegistrationController::class, 'generateApprovedApplicationExcelFile']);

    Route::get('application_registration_suspended', [App\Http\Controllers\ApplicationRegistrationController::class, 'suspended']);
    Route::get('application_registration_suspended_list', [App\Http\Controllers\ApplicationRegistrationController::class, 'suspendedApplicationsList']);
    Route::get('application_registration_pending', [App\Http\Controllers\ApplicationRegistrationController::class, 'pendingApplications']);
    Route::get('application_registration_pending_list', [App\Http\Controllers\ApplicationRegistrationController::class, 'pendingApplicationList']);
    Route::get('edit_application/{id}', [App\Http\Controllers\ApplicationRegistrationController::class, 'editPendingApplication']);
    Route::get('add_application', [App\Http\Controllers\ApplicationRegistrationController::class, 'addApplication']);
    Route::post('store_application_registration', [App\Http\Controllers\ApplicationRegistrationController::class, 'store']);
    Route::post('update_application_registration', [App\Http\Controllers\ApplicationRegistrationController::class, 'update']);
    Route::post('approve_system_application/{id}', [App\Http\Controllers\ApplicationRegistrationController::class, 'approveApplication'])->name('approve_system_application');
    Route::post('suspend_system_application/{id}', [App\Http\Controllers\ApplicationRegistrationController::class, 'suspendApplication'])->name('suspend_system_application');
    Route::post('re_allow_application/{id}/{old?}', [App\Http\Controllers\ApplicationRegistrationController::class, 'reAllowApplication'])->name('re_allow_application');


    Route::get('add_theme', [App\Http\Controllers\ThemeSettingController::class, 'index']);
    Route::get('image_setting', [App\Http\Controllers\ThemeSettingController::class, 'imageSetting']);
    Route::get('global_menue_setting', [App\Http\Controllers\ThemeSettingController::class, 'globalMenueSetting']);
    Route::get('menu_setting', [App\Http\Controllers\ThemeSettingController::class, 'menueSetting']);
    Route::get('language_setting', [App\Http\Controllers\ThemeSettingController::class, 'languageSetting']);

    Route::get('office_honor_board', [App\Http\Controllers\HonorBoardController::class, 'index']);
    Route::get('get_honor_board', [App\Http\Controllers\HonorBoardController::class, 'getHonorBoard']);
    Route::post('/store_honor_board', [App\Http\Controllers\HonorBoardController::class, 'store']);
    Route::post('/delete_honor_board', [App\Http\Controllers\HonorBoardController::class, 'destroy']);
    Route::get('/search_employee_office_wise', [App\Http\Controllers\HonorBoardController::class, 'searchEmployeeOfficeWise']);
    Route::get('/generate_honor_board_excel_file', [App\Http\Controllers\HonorBoardController::class, 'GenerateHonorBoardExcelFile']);
    Route::get('locale/{locale}', [App\Http\Controllers\ChangeController::class, 'changeLocale'])->name('change.locale');
    Route::post('change_password_by_admin', [\App\Http\Controllers\PasswordResetController::class, 'changePasswordByAdmin']);
    Route::get('change/office/{office_id}/{office_unit_id}/{designation_id}', [App\Http\Controllers\ChangeController::class, 'changeDesignation'])->name('change.office');

    Route::post('clear-alert-notification', [App\Http\Controllers\HomeController::class, 'clearAlertNotification']);

    Route::get('/registration_request_list', [App\Http\Controllers\SelfRegistrationController::class, 'registrationRequestList'])->name('registration_request_list');
    Route::get('/get_registration_request_list', [App\Http\Controllers\SelfRegistrationController::class, 'getRegistrationRequestList'])->name('get_registration_request_list');
    Route::get('/search_registrations', [App\Http\Controllers\SelfRegistrationController::class, 'searchRegistrations'])->name('search_registrations');
    Route::post('/approve_registration_request', [App\Http\Controllers\SelfRegistrationController::class, 'approveRegRequest'])->name('approve_registration_request');
    Route::post('/reject_registration_request', [App\Http\Controllers\SelfRegistrationController::class, 'rejectRegRequest'])->name('reject_registration_request');
});

Route::get('/office-information', [App\Http\Controllers\HomeController::class, 'officeInformation']);
Route::post('/office-information', [App\Http\Controllers\HomeController::class, 'getOfficeInformation']);

Route::get('/office-active-users', [App\Http\Controllers\HomeController::class, 'officeWiseUserLogin']);
Route::post('/office-active-users', [App\Http\Controllers\HomeController::class, 'getOfficeWiseUserLogin']);

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    return "Cache is cleared";
});

Route::get('/clear-log', function () {
    exec('rm -f ' . storage_path('logs/laravel.log'));
    exec('rm -f ' . base_path('laravel.log'));
    return 'Logs have been cleared!';
});

