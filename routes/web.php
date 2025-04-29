<?php

use App\Http\Controllers\pdfController;
use App\Http\Middleware\LeaveUpdateMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// ----------- Public Routes -------------- //

// --------- Authenticated Routes ---------- //
Route::middleware('auth')->group(function () {
    Route::get('home', function () {
        return view('home');
    });
});

Auth::routes();

Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    // -----------------------------login--------------------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(LoginController::class)->group(function () {
        Route::get('/login/hr/lgu/admins/cuyapo', 'loginadmin')->name('loginadmin')->middleware(LeaveUpdateMiddleware::class);
        Route::get('/login/hr/employees/cuyapo', 'login')->name('login')->middleware(LeaveUpdateMiddleware::class);
        Route::post('/login/hr/lgu/admins/cuyapo', 'authenticate');
        Route::post('/login/hr/employees/cuyapo', 'authenticateEmployee');
        Route::get('/logout', 'logout')->name('logout');
    });

    // ------------------------------ Register ---------------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'storeUser')->name('register');
        Route::get('/check-super-admin', 'checkSuperAdmin')->name('check/super/admin');
        Route::get('/check-email-user', 'checkEmailUser')->name('check/email/user');
    });

    // ----------------------------- Forget Password --------------------------//
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'getEmail')->name('forget-password');
        Route::post('forget-password', 'postEmail')->name('forget-password');
    });

    // ---------------------------- Reset Password ----------------------------//
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'getPassword');
        Route::get('reset-password/employee/{token}', 'getEmployeePassword');
        Route::post('reset-password', 'updatePassword');
    });
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // ------------------------- Main Dashboard ----------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(HomeController::class)->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/home', 'index')->name('home');
            Route::get('em/dashboard', 'emDashboard')->name('em/dashboard');
        });
    });

    // --------------------------- Lock Screen ----------------------------//
    Route::controller(LockScreen::class)->group(function () {
        Route::get('lock_screen', 'lockScreen')->middleware('auth')->name('lock_screen');
        Route::post('unlock', 'unlock')->name('unlock');
    });

    // --------------------------- Settings -------------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(SettingController::class)->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('company/settings/page', 'companySettings')->name('company/settings/page');
            /** index page */
            Route::post('company/settings/save', 'saveRecord')->name('company/settings/save');
        });
    });

    // --------------------------- Manage Users ---------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(UserManagementController::class)->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('profile_user', 'profile')->name('profile_user');
            Route::post('profile/information/save', 'profileInformation')->name('profile/information/save');
            Route::get('userManagement', 'index')->name('userManagement');
            Route::post('user/add/save', 'addNewUserSave')->name('user/add/save');
            Route::post('update', 'update')->name('update');
            Route::post('user/delete', 'delete')->name('user/delete');
            Route::get('change/password', 'changePasswordView')->name('change/password');
            Route::post('change/password/db', 'changePasswordDB')->name('change/password/db');
            /** save or update emergency contact */
            Route::get('get-users-data', 'getUsersData')->name('get-users-data');
            /** get all data users */
        });
    });

    // -------------------------------- Job ------------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(JobController::class)->group(function () {
        Route::get('/', 'jobList')->name('form/job/list');
        Route::get('job/list/search', 'jobListSearch')->name('job/list/search');
        Route::get('form/job/view/{id}', 'jobView');
        Route::post('form/apply/job/save', 'applyJobSaveRecord')->name('form/apply/job/save');
        Route::post('get/information/emppos', 'getInformationEmppos')->name('hr/get/information/emppos');
        Route::post('get/information/apppos', 'getInformationApppos')->name('hr/get/information/apppos');
        
        Route::middleware('auth')->group(function () {
            Route::get('jobs/dashboard/index', 'jobsDashboard')->name('jobs/dashboard/index');
            Route::get('jobs', 'Jobs')->name('jobs');
            Route::get('jobsTypes', 'JobsTypes')->name('jobsTypes');
            Route::post('form/jobTypes/save', 'JobTypesSaveRecord')->name('form/jobTypes/save');
            Route::post('form/jobTypes/update', 'JobTypesUpdateRecord')->name('form/jobTypes/update');
            Route::post('form/jobTypes/delete', 'JobTypesDeleteRecord')->name('form/jobTypes/delete');
            Route::get('job/applicants/{job_title}', 'jobApplicants');
            Route::get('applicant/view/edit/{applicant_id}', 'viewRecord');
            Route::get('job/details/{id}', 'jobDetails');
            Route::post('form/jobs/save', 'JobsSaveRecord')->name('form/jobs/save');
            Route::post('form/apply/job/update', 'applyJobUpdateRecord')->name('form/apply/job/update');
            Route::post('form/apply/job/delete', 'applyJobDeleteRecord')->name('form/apply/job/delete');
            Route::get('page/shortlist/candidates', 'shortlistCandidatesIndex')->name('page/shortlist/candidates');
            Route::get('page/rejected/applicant', 'rejectedApplicantIndex')->name('page/rejected/applicant');
            Route::get('page/candidates', 'candidatesIndex')->name('page/candidates');
            Route::post('save/candidates', 'saveRecord')->name('all/applicant/save');
            Route::post('/saveProfile', 'updateProfileInfo')->name('all/applicant/save/profileInfo');
            Route::post('/savePersonal', 'updatePersonalInfo')->name('all/applicant/save/personalInfo');
            Route::post('/saveGovIds', 'updateGovIdsInfo')->name('all/applicant/save/govIds');
            Route::post('/saveFamily', 'updateFamilyInfo')->name('all/applicant/save/familyInfo');
            Route::post('/saveChildren', 'updateChildrenInfo')->name('all/applicant/save/childrenInfo');
            Route::post('/saveEducation', 'updateEducationInfo')->name('all/applicant/save/educationInfo');
            Route::post('/saveEligibilities', 'updateEligibilitiesInfo')->name('all/applicant/save/eligibilitiesInfo');
            Route::post('/saveExperience', 'updateExperienceInfo')->name('all/applicant/save/experienceInfo');
            Route::post('/saveVoluntary', 'updateVoluntaryInfo')->name('all/applicant/save/voluntaryInfo');
            Route::post('/saveTraining', 'updateTrainingInfo')->name('all/applicant/save/trainingInfo');
            Route::post('/saveOther', 'updateOtherInfo')->name('all/applicant/save/otherInfo');
            Route::get('page/schedule/timing', 'scheduleTimingIndex')->name('page/schedule/timing');
            Route::post('save/schedule/timing', 'scheduleTimingEdit')->name('save/schedule/timing');
            Route::get('page/aptitude/result', 'aptituderesultIndex')->name('page/aptitude/result');
            Route::post('jobtypestatus/update', 'jobTypeStatusUpdate')->name('jobtypestatus/update'); // update status job type ajax
            Route::post('jobstatus/update', 'jobStatusUpdate')->name('jobstatus/update'); // update status job type ajax
            Route::post('appstatus/update', 'appStatusUpdate')->name('appstatus/update'); // update status application ajax

        });
    });

    // ------------------------- Form Employee ---------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(EmployeeController::class)->group(function () {
        Route::post('/check-email', 'checkEmail')->name('check/email');
        Route::post('get/information/emppos', 'getInformationEmppos')->name('hr/get/information/emppos');
        Route::post('/save', 'saveRecord')->name('all/employee/save');
        Route::middleware('auth')->group(function () {
            // ---------------- Employee Management Routes ---------------------
            Route::prefix('all/employee')->group(function () {
                Route::get('/card', 'cardAllEmployee')->name('all/employee/card');
                Route::get('/list', 'listAllEmployee')->name('all/employee/list');
                Route::post('/saveProfile', 'updateProfileInfo')->name('all/employee/save/profileInfo');
                Route::post('/savePersonal', 'updatePersonalInfo')->name('all/employee/save/personalInfo');
                Route::post('/saveGovIds', 'updateGovIdsInfo')->name('all/employee/save/govIds');
                Route::post('/saveFamily', 'updateFamilyInfo')->name('all/employee/save/familyInfo');
                Route::post('/saveChildren', 'updateChildrenInfo')->name('all/employee/save/childrenInfo');
                Route::post('/saveEducation', 'updateEducationInfo')->name('all/employee/save/educationInfo');
                Route::post('/saveEligibilities', 'updateEligibilitiesInfo')->name('all/employee/save/eligibilitiesInfo');
                Route::post('/saveExperience', 'updateExperienceInfo')->name('all/employee/save/experienceInfo');
                Route::post('/saveVoluntary', 'updateVoluntaryInfo')->name('all/employee/save/voluntaryInfo');
                Route::post('/saveTraining', 'updateTrainingInfo')->name('all/employee/save/trainingInfo');
                Route::post('/saveOther', 'updateOtherInfo')->name('all/employee/save/otherInfo');
                Route::get('/view/edit/{employee_id}', 'viewRecord');
                Route::post('/update', 'updateRecord')->name('all/employee/update');
                Route::post('/delete/{employee_id}', 'deleteRecord')->name('employee/delete');
                Route::post('/search', 'employeeSearch')->name('all/employee/search');
                Route::post('/list/search', 'employeeListSearch')->name('all/employee/list/search');
            });
            Route::prefix('form')->group(function () {
                // ----------------------- Departments -------------------------
                Route::prefix('departments')->controller(EmployeeController::class)->group(function () {
                    Route::get('/page', 'index')->name('form/departments/page');
                    Route::post('/save', 'saveRecordDepartment')->name('form/departments/save');
                    Route::post('/update', 'updateRecordDepartment')->name('form/department/update');
                    Route::post('/delete', 'deleteRecordDepartment')->name('form/department/delete');
                    Route::post('admin/employee/{emp_id}/assign-head', 'assignHead')->name('admin/assignHead');
                    Route::post('/add/employee', 'addEmployeeToDepartment')->name('employee/assignToDepartment');
                    Route::get('employee/departments/{department}', 'employeeDepartments');
                    Route::post('/employee/editPosition', 'editPosition')->name('employee/editPosition');
                    Route::post('/employee/changeDepartment', 'changeDepartment')->name('employee/changeDepartment');
                    Route::delete('/employee/deleteFromDepartment/{emp_id}/{department_id}/{created_at}', 'deleteFromDepartment')->name('employee/deleteFromDepartment');
                });
                // ----------------------- Designations ------------------------
                // ----------------------- Positions ------------------------
                Route::prefix('positions')->group(function () {
                    Route::get('/page', 'positionsIndex')->name('form/positions/page');
                    Route::post('/save', 'saveRecordPositions')->name('form/positions/save');
                    Route::post('/update', 'updateRecordPositions')->name('form/positions/update');
                    Route::post('/delete', 'deleteRecordPositions')->name('form/positions/delete');
                    Route::get('/check-position-employees/{id}', 'checkPositionEmployees')->name('check/employeesPosition');
                });
            });
            // ------------------------- Profile Employee --------------------------//
        });
    });

    // ------------------------- Form Holiday ---------------------------//
    Route::controller(HolidayController::class)->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('form/holidays/new', 'holiday')->name('form/holidays/new');
            Route::post('form/holidays/save', 'saveRecord')->name('form/holidays/save');
            Route::post('form/holidays/update', 'updateRecord')->name('form/holidays/update');
            Route::post('form/holidays/delete', 'deleteRecord')->name('form/holidays/delete');
        });
    });


        // ------------------------- Form PDF ---------------------------//
        Route::controller(pdfController::class)->group(function () {
            Route::middleware('auth')->group(function () {
                Route::post('form/leave/print', 'printLeave')->name('form/leave/print');
            });
        });

    // ---------------------------- Leaves ------------------------------//
    Route::middleware([LeaveUpdateMiddleware::class])->controller(LeavesController::class)->group(function () {
        Route::middleware('auth')->group(function () {
            // ------------------- Employee Management Routes ---------------------
            Route::prefix('form/leaves')->group(function () {
                Route::get('/new', 'leavesAdmin')->name('form/leaves/new');
                Route::post('/save', 'saveRecordLeave')->name('form/leaves/save');
                Route::post('/edit', 'editRecordLeave')->name('form/leaves/edit');
                Route::post('/approve', 'approveRecordLeave')->name('form/leaves/approve');
                Route::post('/decline', 'declineRecordLeave')->name('form/leaves/decline');
                Route::post('/pending', 'pendingRecordLeave')->name('form/leaves/pending');
                Route::get('/employee/new', 'leavesEmployee')->name('form/leaves/employee/new');
                Route::post('/edit/delete', 'deleteLeave')->name('form/leaves/edit/delete');
                Route::get('/leaves/admin/search', 'leaveSearch')->name('form/leaves/list/search');
                Route::post('/leavesettings/update', 'updateSplLeaveSettings')->name('form/leaveSettings/update');
                Route::post('/mapaternityleavesettings/update', 'updateMaPaternityLeaveSettings')->name('form/mapaternityLeaveSettings/update');
                Route::get('/custom-leave-policy/get', 'getCustomLeavePolicy')->name('leave/getCustomLeavePolicy');
                Route::post('/custom-leave-policy/save', 'saveCustomLeavePolicy')->name('leave/saveCustomLeavePolicy');
                Route::post('/custom-leave-policy/update', 'updateCustomLeavePolicy')->name('leave/updateCustomLeavePolicy');
                Route::post('/custom-leave-policy/delete', 'deleteCustomLeavePolicy')->name('leave/deleteCustomLeavePolicy');

                Route::get('/calendar', 'calendar')->name('form/leaves/calendar');
            });
            // --------------------- Form Attendance  -------------------------//
            Route::post('get/information/leave', 'getInformationLeave')->name('hr/get/information/leave');
            Route::post('get/information/editleave', 'getEditInformationLeave')->name('hr/get/information/editleave');
            Route::post('get/information/leave-options', 'getLeaveOptions')->name('hr/get/information/leaveOptions');
            Route::get('get/staff-leave-options', 'getStaffLeaveOptions')->name('hr/get/leaveStaffOptions');
            Route::get('get/session_user_id', 'getSessionUserId')->name('hr/get/userId');
            Route::get('leave/details/{id}', 'leaveDetails');
            Route::get('form/leavesettings/page', 'leaveSettings')->name('form/leavesettings/page');
        });
    });



    // ---------------------------- Reports  ----------------------------//
    Route::controller(ExpenseReportsController::class)->group(function () {
        Route::get('form/employee/reports/page', 'employeeReportsIndex')->middleware('auth')->name('form/employee/reports/page');
        Route::post('/employee-graph', 'getGraphData')->name('all/employee/graph/data');
        Route::get('/employee-storedgraph', 'getAllStoredGraphs')->name('all/employee/storedgraph/data');
        Route::delete('/delete-graph/{graphId}', 'deleteGraph')->name('all/employee/delete-graph');
    });

});
