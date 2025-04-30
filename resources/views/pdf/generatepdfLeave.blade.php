<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 5px;
        }

        .form-container {
            border: 1px solid #000;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .header .title {
            font-size: 16px;
            margin-top: 10px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .col {
            flex: 1;
            margin: 0 5px;
        }

        .col label {
            display: block;
            margin-bottom: 5px;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
            /* controls spacing between checkboxes */
            margin-left: 8px;
            margin-top: 5px;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            justify-self: center;
            gap: 2px;
            height: 20px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            /* change width */
            height: 18px;
            /* change height */
            accent-color: #007bff;
            /* optional: change checkbox color (modern browsers) */
        }

        .tiny.section {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 10px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 8px;
            height: 15px;
        }

        .tiny.section label {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        label {
            font-size: 10px;
        }



        .input-line {
            border-bottom: 1px solid black;
            display: inline-block;
            min-width: 200px;
            margin-left: 5px;
        }

        .signature-line {
            border-top: 1px solid black;
            width: 300px;
            margin: 0 auto;
            padding-top: 4px;
        }

        .center {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .table tr:last-child td:first-child {
            border-right: none;

        }

        .table tr:last-child td:last-child {
            border-left: none;
        }

        .tiny {
            font-size: 10px;
        }

        .upper-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            border-right: none;
            border-left: none;
        }

        .upper-table td {
            border: none;
            padding: 8px;
            height: 20px;
        }

        .upper-table tr+tr td {
            border-top: 1px solid black;
        }

        .upperstable td {
            vertical-align: top;
        }

        .signature-line {
            margin-top: 20px;
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="form-container">
        <div class="row">
            <div style="flex: 1; font-size: 10px; padding: 15px 0 0 15px;">
                Civil Service Form No. 6<br>
                Revised 2020
            </div>
            <div style="text-align: right; font-size: 10px; padding: 0 15px 0 0;">
                ANNEX A
            </div>
        </div>
        <div class="header">
            <div style="position: absolute; top: 65px; left: 160px;">
                @if (!empty($company) && !empty($company->logo))
                <img src="{{ public_path('assets/images/' . $company->logo) }}" width="60" height="60" alt="Logo">
                @else
                <img src="{{ public_path('assets/img/logo.png') }}" width="60" height="60" alt="Logo">
                @endif
            </div>
            <div>Republic of the Philippines</div>
            <div><em>Local Government Unit</em></div>
            <div><em>Cuyapo, Nueva Ecija</em></div>
            <div class="title">APPLICATION FOR LEAVE</div>
        </div>

        <table class="upper-table">
            <tr class="upperstable">
                <td colspan="2" style="width: 170px">1. OFFICE/DEPARTMENT <div style="font-weight: bold; width:40%; height: 13px; display: block; margin-top: 5px; text-align: start;">{{ $department_name }}</div>
                </td>
                <td colspan="3">
                    <span style="margin-right: 3px;">2. NAME : </span>
                    <span style="margin-left: 5px;">(Last)</span>
                    <span style="margin-left: 78px;">(Middle)</span>
                    <span style="margin-left: 85px;">(First)</span>
                    <div style="font-weight: bold;">
                        <div style="position: absolute; top: 175px; left: 328px;">{{ $employee_lname }}</div>
                        <div style="position: absolute; top: 175px; left: 436px;">{{ $employee_mname }}</div>
                        <div style="position: absolute; top: 175px; left: 558px;">{{ $employee_fname }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">3. DATE OF FILING <div style="font-weight: bold; width:40%; height: 13px; border-bottom: 1px solid #000; display: inline-block; margin-top: 25px; text-align: center;">{{ $created_at }}</div>
                </td>
                <td colspan="2">4. POSITION <div style=" font-weight: bold; width: 60%; height: auto; min-height: 13px; border-bottom: 1px solid #000; display: inline-block; margin-top: 25px; text-align: center; word-break: break-word; white-space: normal;">{{ $position_name }}</div>
                </td>
                <td colspan="2">5. SALARY <div style="font-weight: bold; width:40%; height: 13px; border-bottom: 1px solid #000; display: inline-block; margin-top: 25px; text-align: center;"></div>
                </td>
            </tr>
        </table>

        <!-- 🔽 NEW TABLE FOR SECTION 6 AND BELOW -->
        <table class="table">
            <tr>
                <td colspan="5" class="center" style="border-right: none; border-left: none; border-top: none;"><strong>6. DETAILS OF APPLICATION</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="border-left: none;">
                    6.A TYPE OF LEAVE TO BE AVAILED OF<br>
                    <div class="checkbox-group tiny">
                        @foreach($leave_types as $leaveType)
                        <label>
                            <input type="checkbox" name="leave_type[]" value="{{ $leaveType }}" {{ in_array($leaveType, $selected_leave_types) ? 'checked' : '' }}>
                            {{ $leaveType }}
                            @if ($leaveType == 'Vacation Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                            @elseif ($leaveType == 'Mandatory/Forced Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                            @elseif ($leaveType == 'Sick Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                            @elseif ($leaveType == 'Maternity Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)</span>
                            @elseif ($leaveType == 'Paternity Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)</span>
                            @elseif ($leaveType == 'Special Privilege Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                            @elseif ($leaveType == 'Solo Parent Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(RA No. 8972 / CSC MC No. 8, s. 2004)</span>
                            @elseif ($leaveType == 'Study Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                            @elseif ($leaveType == '10-Day VAWC Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(RA No. 9262 / CSC MC No. 15, s. 2005)</span>
                            @elseif ($leaveType == 'Rehabilitation Privilege')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                            @elseif ($leaveType == 'Special Leave Benefits for Women')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(RA No. 9710 / CSC MC No. 25, s. 2010)</span>
                            @elseif ($leaveType == 'Special Emergency (Calamity) Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(CSC MC No. 2, s. 2012, as amended)</span>
                            @elseif ($leaveType == 'Adoption Leave')
                            <span style="font-size: 7px; color: black; letter-spacing: -0.3px;">(R.A. No. 8552)</span>
                            @endif
                        </label>
                        @endforeach
                        <label>Others: <div style="width: 65%; height: 15px; border-bottom: 1px solid #000; display: block; padding-bottom: 2px; margin-bottom: 10px;"></div></label>
                    </div>

                </td>
                <td colspan="3" style="border-right: none;">
                    6.B DETAILS OF LEAVE
                    <div class="checkbox-group tiny section">
                        <div class="section-title">In case of Vacation/Special Privilege Leave:</div>
                        <label>
                            <input type="checkbox" {{ $vacation_location == 'Philippines' ? 'checked' : '' }}> Within the Philippines
                        </label>
                        <label>
                            <input type="checkbox" {{ $vacation_location == 'Abroad' ? 'checked' : '' }}>
                            Abroad (Specify): @if($vacation_location == 'Abroad' && $abroad_specify != 'N/A') <span style="font-size: 9px; font-weight: bold; width: 50%; border-bottom: 1px solid #000; display: inline-block; text-align: start;">{{ $abroad_specify }}</span>
                            @else
                            <span style="font-size: 9px; font-weight: bold; width: 20%; border-bottom: 1px solid #000; display: inline-block; text-align: center;"></span>
                            @endif
                        </label>

                        <div class="section-title">In case of Sick Leave:</div>
                        <label>
                            <input type="checkbox" {{ $sick_location == 'In Hospital' ? 'checked' : '' }}> In Hospital (Specify illness):
                            @if($illness_specify != 'N/A' && $sick_location == 'In Hospital')
                            <span style="font-size: 9px; font-weight: bold; width: 50%; border-bottom: 1px solid #000; display: inline-block; text-align: start;">{{ $illness_specify }}</span>
                            @else
                            <span style="font-weight: bold; width: 20%; border-bottom: 1px solid #000; display: inline-block; text-align: center;"></span>
                            @endif
                        </label>
                        <label>
                            <input type="checkbox" {{ $sick_location == 'Out Patient' ? 'checked' : '' }}> Out Patient (Specify illness):
                            @if($illness_specify != 'N/A' && $sick_location == 'Out Patient')
                            <span style="font-size: 9px; font-weight: bold; width: 50%; border-bottom: 1px solid #000; display: inline-block; text-align: start;">{{ $illness_specify }}</span>
                            @else
                            <span style="font-size: 9px; font-weight: bold; width: 20%; border-bottom: 1px solid #000; display: inline-block; text-align: center;"></span>
                            @endif
                        </label>


                        <div class="section-title">In case of Special Leave Benefits for Women:</div>
                        <div>(Specify illness) @if($women_illness != 'N/A') <span style="font-size: 9px; font-weight: bold; width: 70%; border-bottom: 1px solid #000; display: inline-block; text-align: start;">{{ $women_illness }}</div></span>
                        @else
                        <span style="font-size: 9px; font-weight: bold; width: 20%; border-bottom: 1px solid #000; display: inline-block; text-align: center;"></span>
                        @endif

                        <div class="section-title">In case of Study Leave:</div>
                        <label>
                            <input type="checkbox" {{ strpos($study_reason, 'Completion of Master’s Degree') !== false ? 'checked' : '' }}> Completion of Master’s Degree
                        </label>
                        <label>
                            <input type="checkbox" {{ strpos($study_reason, 'BAR/Board Examination Review') !== false ? 'checked' : '' }}> BAR/Board Examination Review
                        </label>


                        <div class="section-title">Other purpose:</div>
                        <label><input type="checkbox"> Monetization of Leave Credits</label>
                        <label><input type="checkbox"> Terminal Leave</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-left: none;">
                    6.C NUMBER OF WORKING DAYS APPLIED FOR
                    <br>
                    <div style="margin-left: 20px; margin-top: 5px;">
                        <div style="font-weight: bold; width: 65%; height: 15px; border-bottom: 1px solid #000; display: block; padding-bottom: 1px; text-align: center;">{{ $number_of_days }}</div>
                        <div class="section-title" style="font-weight: normal;"> INCLUSIVE DATES </div>
                        <div style="font-weight: bold; width: 65%; height: 15px; border-bottom: 1px solid #000; display: block; padding-bottom: 1px; text-align: center;">
                            {{ date('F d, Y', strtotime($date_from)) }} to {{ date('F d, Y', strtotime($date_to)) }}
                        </div>
                    </div>
                </td>
                <td colspan="3" style="border-right: none;">
                    6.D COMMUTATION
                    <div class="checkbox-group tiny section">
                        <label>
                            <input type="checkbox" name="commutation_not_requested" {{ $commutation === 'Not Requested' ? 'checked' : '' }} disabled> Not Requested
                        </label>
                        <label>
                            <input type="checkbox" name="commutation_requested" {{ $commutation === 'Requested' ? 'checked' : '' }} disabled> Requested
                        </label>
                        <br><br>
                        <div class="signature-line" style="margin-top: 10px; text-align: center;">(Signature of Applicant)</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="center" style="border-right: none; border-left: none;"><strong>7. DETAILS OF ACTION ON APPLICATION</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="border-left: none;">
                    7.A CERTIFICATION OF LEAVE CREDITS<br>
                    <div style="width: 100%; text-align: center; margin: 10px 0 8px 0;">As of <div style="font-weight: bold; width: 65%; height: 15px; border-bottom: 1px solid #000; display: inline-block; padding-bottom: 1px; text-align: center;">{{ date('d F, Y'); }}</div>
                    </div>
                    <table class="table tiny">
                        <tr>
                            <th></th>
                            <th style="font-weight: normal;">Vacation Leave</th>
                            <th style="font-weight: normal;">Sick Leave</th>
                        </tr>
                        <tr>
                            <td>Total Earned</td>
                            <td style="font-weight: bold; text-align: center;">{{ $total_vacation_leave_days }}</td>
                            <td style="font-weight: bold; text-align: center;">{{ $total_sick_leave_days }}</td>
                        </tr>
                        <tr>
                            <td>Less this application</td>
                            <td style="font-weight: bold; text-align: center;">@if($leave_type !== 'Vacation Leave' || $leave_status == 'Declined') 0 @else {{ $number_of_days }} @endif</td>
                            <td style="font-weight: bold; text-align: center;">@if($leave_type !== 'Sick Leave' || $leave_status == 'Declined') 0 @else {{ $number_of_days }} @endif</td>
                        </tr>
                        <tr>
                            <td>Balance</td>
                            <td style="font-weight: bold; text-align: center;">{{ $total_vacation_leave_balance }}</td>
                            <td style="font-weight: bold; text-align: center;">{{ $total_sick_leave_balance }}</td>
                        </tr>
                    </table>
                    <br><br>
                    <div class="signature-line" style="margin-top: 10px; text-align: center;">
                        (Authorized Officer)
                    </div>
                </td>
                <td colspan="3" style="border-right: none; padding: 10px; word-wrap: break-word; overflow-wrap: break-word;">
                    7.B RECOMMENDATION
                    <div class="checkbox-group tiny section">
                        <label>
                            <input type="checkbox" {{ $leave_status == 'Approved' ? 'checked' : '' }}> For Approval
                        </label>
                        <label>
                            <input type="checkbox" {{ $leave_status == 'Declined' ? 'checked' : '' }}> For Disapproval due to:
                        </label>
                    </div>
                    @if($decline_reason && $decline_reason != 'N/A')
                    <!-- Only show decline reason if it's not null or 'N/A' -->
                    <div style="font-weight: bold; width: 47%; overflow-wrap: break-word; word-break: break-word; display: block; margin-top: 10px; position: absolute; top: 815px; left: 385px; font-size: 12px; line-height: 1.7em; max-height: 3.6em; overflow: hidden;">
                        {{ $decline_reason }}
                    </div>
                    @else
                    @endif

                    <!-- Ensuring signature line takes up full width -->
                    <div style="width: 100%; border-top: 1px solid black; margin-top: 20px; height: 15px;"></div>
                    <div style="width: 100%; border-top: 1px solid black; margin-top: 5px; height: 15px;"></div>
                    <div style="width: 100%; border-top: 1px solid black; margin-top: 5px; height: 15px;"></div>
                    <br><br>

                    <!-- Ensuring signature line takes up full width -->
                    <div class="signature-line" style="margin-top: 12px; text-align: center;">
                        @if ($approved_by_name !== 'N/A')
                        <div style="text-align: center; font-weight: bold; font-size: 10px; margin-top: 2px;">
                            {{ $approved_by_name }}
                        </div>
                        @endif
                        (Authorized Officer)
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-left: none; border-bottom: none; height: 180px">
                    7.C APPROVED FOR: <br><br>
                    <div style="margin-left: 20px;">
                        <div style="width: 15%; height: 15px; border-bottom: 1px solid #000; display: inline-block; padding-bottom: 2px;"></div> days with pay<br>
                        <div style="width: 15%; height: 15px; border-bottom: 1px solid #000; display: inline-block; padding-bottom: 2px;"></div> days without pay<br>
                        <div style="width: 15%; height: 15px; border-bottom: 1px solid #000; display: inline-block; padding-bottom: 2px;"></div> others (Specify) <div style="width: 15%; height: 15px; border-bottom: 1px solid #000; display: inline-block; padding-bottom: 2px;"></div>
                    </div>
                </td>
                <td colspan="3" style="border-right: none; border-bottom: none;">
                    7.D DISAPPROVED DUE TO: <br><br>
                    <div style="margin-left: 20px;">
                        <div style="width: 100%; border-top: 1px solid black; height: 15px;"></div>
                        <div style="width: 100%; border-top: 1px solid black; margin-top: 5px; height: 15px;"></div>
                        <div style="width: 100%; border-top: 1px solid black; margin-top: 5px; height: 15px;"></div>
                    </div>
                    <br><br>
                    <div class="signature-line" style="position: absolute; top: 1090px; left: 50%; transform: translateX(-50%); margin-top: 12px; text-align: center;">
                        @php
                        use App\Models\CompanySettings;
                        $company = CompanySettings::first();
                        @endphp

                        @if ($company && $company->municipal_mayor)
                        <div class="mayor-name" style="font-weight: bold;">
                            {{ $company->municipal_mayor }}
                        </div>
                        @else
                        <div class="mayor-name">
                        </div>
                        @endif
                        Municipal Mayor
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div style="page-break-before: always;"></div>

    <style>
        .instructions-container {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 10px 20px;
        }

        .instructions-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
            border: ;
            border: 1.5px solid #000;
            width: 100%;
            padding: 5px;
        }

        .columns-table {
            width: 100%;
            border-collapse: collapse;
        }

        .column-cell {
            width: 50%;
            vertical-align: top;
            padding-right: 10px;
        }

        .column-cell ol {
            padding-left: 15px;
            margin: 0;
        }

        .column-cell ol li {
            margin-bottom: 14px;
            text-align: justify;
        }

        .column-cell ul {
            list-style-type: disc;
            /* Bullets for the first level unordered lists */
            padding-left: 5px;
            margin: 5px 0 0 0;
        }

        .column-cell ul li {
            margin-bottom: 4px;
            text-align: justify;
        }

        .column-cell ol ul {
            list-style-type: disc;
            /* Bullets for unordered lists inside ordered lists */
            padding-left: 5px;
            margin-left: 5px;
        }

        .column-cell ol ol.alpha-list {
            list-style-type: lower-alpha;
            /* Alphabetic list (a, b, c, d) for nested ordered lists */
            padding-left: 5px;
            margin-left: 5px;
        }

        .note {
            font-size: 9px;
            margin-top: 15px;
            font-style: italic;
            text-align: justify;
        }

        p {
            margin: 0 0 15px 0;
            padding: 0;
        }

    </style>

    <div class="instructions-container">
        <div class="instructions-title">INSTRUCTIONS AND REQUIREMENTS</div>

        <table class="columns-table">
            <tr>
                <td class="column-cell">
                    <p>Application for any type of leave shall be made on this Form and <strong><u>to be accomplished at least in duplicate</u></strong> with documentary requirements, as follows:</p>
                    <ol type="1">
                        <li><b>Vacation leave*</b><br>
                            It shall be filed five (5) days in advance, whenever possible, of the effective date of such leave. Vacation leave within the Philippines or abroad shall be indicated in the form for purposes of securing travel authority and completing clearance from money and work accountabilities.
                        </li>
                        <li><b>Mandatory/Forced leave</b><br>
                            Annual five-day vacation leave shall be forfeited if not taken during the year. In case the scheduled leave has been cancelled in the exigency of the service by the head of agency, it shall no longer be deducted from the accumulated vacation leave. Availment of one (1) day or more Vacation Leave (VL) shall be considered for complying the mandatory/forced leave subject to the conditions under Section 25, Rule XVI of the Omnibus Rules Implementing E.O. No. 292.
                        </li>
                        <li><b>Sick leave*</b>
                            <ul>
                                <li>It shall be filed immediately upon employee’s return from such leave.</li>
                                <li>If filed in advance or exceeding five (5) days, application shall be accompanied by a <u> medical certificate </u>. In case medical consultation was not availed of, an <u> affidavit </u> shall be executed by an applicant.</li>
                            </ul>
                        </li>
                        <li><b>Maternity leave* – 105 days</b>
                            <ul>
                                <li>Proof of pregnancy e.g. ultrasound, doctor’s certificate on the expected date of delivery</li>
                                <li>Accomplished Notice of Allocation of Maternity Leave Credits (CS Form No. 6a), if needed</li>
                                <li>In case of miscarriage employees shall enjoy maternity leave benefits for sixty (60) days.</li>
                            </ul>
                        </li>
                        <li><b>Paternity leave – 7 days</b><br>
                            Proof of child’s delivery e.g. birth certificate, medical certificate and marriage contract
                        </li>
                        <li><b>Special Privilege leave – 3 days</b><br>
                            It shall be filed/approved for at least one (1) week prior to availment,
                            except on emergency cases. Special privilege leave within the
                            Philippines or abroad shall be indicated in the form for purposes of
                            securing travel authority and completing clearance from money and work
                            accountabilities.
                        </li>
                        <li><b>Solo Parent leave – 7 days</b><br>
                            It shall be filed in advance or whenever possible five (5) days before going on such leave with updated Solo Parent Identification Card.
                        </li>
                        <li><b>Study leave* – up to 6 months</b>
                            <ul>
                                <li>Shall meet the agency’s internal requirements, if any;</li>
                                <li>Contract between the agency head or authorized representative and the employee concerned.</li>
                            </ul>
                        </li>
                        <li><b>VAWC leave – 10 days</b>
                            <ul>
                                <li>It shall be filed in advance or immediately upon the woman employee’s return from such leave.</li>
                                <li>It shall be accompanied by any of the following supporting documents:
                                    <ol type="a" class="alpha-list">
                                        <li>Barangay Protection Order (BPO) obtained from the barangay;</li>
                                        <li>Temporary/Permanent Protection Order (TPO/PPO) obtained from the court;</li>
                                        <li>If the protection order is not yet issued by the barangay or the court, a certification issued by the Punong Barangay/Kagawad or Prosecutor or the Clerk of Court that the application for the BPO, TPO or PPO has been filed with the said office shall be sufficient
                                            to support the application for the ten-day leave; or
                                        </li>
                                        <li>In the absence of the BPO/TPO/PPO or the certification, a police
                                            report specifying the details of the occurrence of violence on the
                                            victim and a medical certificate may be considered, at the
                                            discretion of the immediate supervisor of the woman employee
                                            concerned.</li>
                                    </ol>
                                </li>
                            </ul>
                        </li>
                    </ol>
                </td>
                <td class="column-cell">
                    <ol start="10">
                        <li><b>Rehabilitation leave* – up to 6 months</b>
                            <ul>
                                <li>Application shall be made within one (1) week from the time of the accident.</li>
                                <li>Letter request supported by relevant reports such as the police report, if any.</li>
                                <li>Medical certificate on the nature of the injuries, the course of
                                    treatment involved, and the need to undergo rest, recuperation, and
                                    rehabilitation, as the case may be</li>
                                <li>Written concurrence of a government physician should be obtained
                                    relative to the recommendation for rehabilitation if the attending
                                    physician is a private practitioner, particularly on the duration of the
                                    period of rehabilitation.
                                </li>
                            </ul>
                        </li>
                        <li><b>Special leave benefits for women* – up to 2 months</b>
                            <ul>
                                <li>The application may be filed in advance, that is, at least five (5) days
                                    prior to the scheduled date of the gynecological surgery that will be
                                    undergone by the employee. In case of emergency, the application
                                    for special leave shall be filed immediately upon employee’s return
                                    but during confinement the agency shall be notified of said surgery.</li>
                                <li>The application shall be accompanied by a medical certificate filled
                                    out by the proper medical authorities, e.g. the attending surgeon
                                    accompanied by a clinical summary reflecting the gynecological
                                    disorder which shall be addressed or was addressed by the said
                                    surgery; the histopathological report; the operative technique used
                                    for the surgery; the duration of the surgery including the perioperative period (period of confinement around surgery); as well as
                                    the employees estimated period of recuperation for the same.
                                </li>
                            </ul>
                        </li>
                        <li><b>Special Emergency (Calamity) leave – up to 5 days</b>
                            <ul>
                                <li>The special emergency leave can be applied for a maximum of five
                                    (5) straight working days or staggered basis within thirty (30) days
                                    from the actual occurrence of the natural calamity/disaster. Said
                                    privilege shall be enjoyed once a year, not in every instance of
                                    calamity or disaster.</li>
                                <li>The head of office shall take full responsibility for the grant of special
                                    emergency leave and verification of the employee’s eligibility to be
                                    granted thereof. Said verification shall include: validation of place of
                                    residence based on latest available records of the affected
                                    employee; verification that the place of residence is covered in the
                                    declaration of calamity area by the proper government agency; and
                                    such other proofs as may be necessary.
                                </li>
                            </ul>
                        </li>
                        <li><b>Monetization of leave credits</b><br>
                            Application for monetization of fifty percent (50%) or more of the
                            accumulated leave credits shall be accompanied by letter request to
                            the head of the agency stating the valid and justifiable reasons.
                        </li>
                        <li><b>Terminal leave*</b><br>
                            Proof of employee’s resignation or retirement or separation from the
                            service.
                        </li>
                        <li><b>Adoption Leave</b>
                            <ul>
                                <li> Application for adoption leave shall be filed with an authenticated
                                    copy of the Pre-Adoptive Placement Authority issued by the
                                    Department of Social Welfare and Development (DSWD).</li>
                            </ul>
                        </li>
                    </ol>
                </td>
            </tr>
        </table>

        <p class="note">
            * For leave of absence for thirty (30) calendar days or more and terminal leave, application shall be accompanied by a <u>clearance from money, property and work-related accountabilities</u> (pursuant to CSC Memorandum Circular No. 2, s. 1985).
        </p>
    </div>


</body>

</html>
