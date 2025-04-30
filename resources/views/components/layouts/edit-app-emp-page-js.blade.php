@props(['Url' => ''])

<script>
    document.getElementById("image").addEventListener("change", function(event) {
        let file = event.target.files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function(e) {
                let imgPreview = document.querySelector(".profile-img-wrap .profile-image");

                // **Instantly Update Image Preview**
                imgPreview.src = e.target.result;

                let img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    let canvas = document.createElement("canvas");
                    let ctx = canvas.getContext("2d");

                    // **Resize Image**
                    let maxWidth = 300;
                    let maxHeight = 300;
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);

                    // **Convert to Compressed JPEG (80% quality)**
                    canvas.toBlob(function(blob) {
                        let compressedFile = new File([blob], file.name, {
                            type: "image/jpeg"
                        });

                        // **Replace File Input with Compressed Image**
                        let dt = new DataTransfer();
                        dt.items.add(compressedFile);
                        document.getElementById("image").files = dt.files;
                    }, "image/jpeg", 0.8);
                };
            };

            reader.readAsDataURL(file);
        }
    });

</script>



<script>
    $(document).ready(function() {
        function toggleAddButton(section, buttonId) {
            if ($(section).children().length === 0) {
                $(buttonId).show(); // Show the Add button
            } else {
                $(buttonId).hide(); // Hide the Add button
            }
        }

        function initializeDatetimepickers() {
            $('.datetimepicker').datetimepicker({
                format: 'DD MMM, YYYY'
                , useCurrent: false
                , showTodayButton: false, // 🔹 Removes the "Today" button
                widgetPositioning: {
                    horizontal: 'auto', // Keeps it aligned horizontally
                    vertical: 'bottom' // Forces calendar to appear below
                }
                , icons: {
                    time: 'fa fa-clock'
                    , date: 'fa fa-calendar'
                    , up: 'fa fa-chevron-up'
                    , down: 'fa fa-chevron-down'
                    , previous: 'fa fa-chevron-left'
                    , next: 'fa fa-chevron-right'
                    , clear: 'fa fa-trash'
                    , close: 'fa fa-times'
                }
            });
        }



        $(document).on('click', '.add-child', function() {
            var newChild = $('#child-template').html();
            $('#children-container').append(newChild);
            toggleAddButton('#children-container', '#heading-add-child');
            initializeDatetimepickers();
        });


        $(document).on('click', '.remove-child', function() {
            $(this).closest('.child-entry').remove();
            toggleAddButton('#children-container', '#heading-add-child');
        });

        $(document).on('click', '.add-experience', function() {
            var newExperience = $('#experience-template').html();
            $('#experience-container').append(newExperience);
            toggleAddButton('#experience-container', '#heading-add-experience');
            initializeDatetimepickers();
        });

        $(document).on('click', '.remove-experience', function() {
            $(this).closest('.work-experience-entry').remove();
            toggleAddButton('#experience-container', '#heading-add-experience');
        });

        $(document).on('click', '.add-entry', function() {
            var newEntry = $('#eligibility-template').html();
            $('#eligibility-container').append(newEntry); // Append correctly
            toggleAddButton('#eligibility-container', '#heading-add-eligibility');
            initializeDatetimepickers();
        });


        $(document).on('click', '.remove-civil-service', function() {
            $(this).closest('.civil-service-entry').remove(); // Remove correctly
            toggleAddButton('#eligibility-container', '#heading-add-eligibility');
        });

        $(document).on('click', '.add-voluntary-work', function() {
            var newVoluntaryWork = $('#voluntary-work-template').html();
            $('#voluntary-work-container').append(newVoluntaryWork);
            toggleAddButton('#voluntary-work-container', '#heading-add-voluntary-work');
            initializeDatetimepickers();
        });

        $(document).on('click', '.remove-voluntary-work', function() {
            $(this).closest('.voluntary-work-entry').remove();
            toggleAddButton('#voluntary-work-container', '#heading-add-voluntary-work');
        });

        $(document).on('click', '.add-training', function() {
            var newTraining = $('#training-template').html();
            $('#training-container').append(newTraining);
            toggleAddButton('#training-container', '#heading-add-training');
            initializeDatetimepickers();
        });

        $(document).on('click', '.remove-training', function() {
            $(this).closest('.training-entry').remove();
            toggleAddButton('#training-container', '#heading-add-training');
        });

        $(document).on('click', '.add-other-info', function() {
            var newInfo = $('#other-info-template').html();
            $('#other-info-container').append(newInfo);
            toggleAddButton('#other-info-container', '#heading-add-other-info');
            initializeDatetimepickers();
        });

        // Employee Other Information - Remove
        $(document).on('click', '.remove-other-info', function() {
            $(this).closest('.other-info-entry').remove();
            toggleAddButton('#other-info-container', '#heading-add-other-info');
        });



        // Initialize existing sections
        toggleAddButton('#children-container', '#heading-add-child');
        toggleAddButton('#experience-container', '#heading-add-experience');
        toggleAddButton('#eligibility-container', '#heading-add-eligibility');
        toggleAddButton('#voluntary-work-container', '#heading-add-voluntary-work');
        toggleAddButton('#training-container', '#heading-add-training');
        toggleAddButton('#other-info-container', '#heading-add-other-info');


        initializeDatetimepickers();
    });

</script>

<script>
    $(document).ready(function() {
        function validateDynamicForm(formId, rules, messages, entryClass, customValidation = null) {
            $(formId).validate({
                ignore: ":hidden:not(.force-validate)", // Ignore hidden fields except those explicitly required
                rules: rules
                , messages: messages
                , errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
                , submitHandler: function(form) {
                    console.log("✅ Form validation passed, attempting to submit...");

                    let valid = true;

                    // Remove previous error messages and styling
                    $('.text-danger').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    // Custom validation for dynamic fields
                    $(entryClass).each(function() {
                        if (customValidation) {
                            let entryValid = customValidation($(this));
                            valid = entryValid && valid;
                        }
                    });

                    if (valid) {
                        console.log("🚀 Form is valid, submitting...");
                        form.submit();
                    } else {
                        console.log("❌ Form validation failed.");
                    }
                }
            });
        }

        if ($('#eligibilityForm').length) {
            validateDynamicForm('#eligibilityForm', {
                "eligibility_type[]": {
                    required: true
                }
                , "exam_date[]": {
                    required: true
                    , date: true
                }
                , "exam_place[]": {
                    required: true
                }
                , "rating[]": {
                    required: true
                    , number: true // Ensure rating is a number
                }
            }, {
                "eligibility_type[]": "Please enter eligibility name"
                , "exam_date[]": "Please enter a valid date of examination"
                , "exam_place[]": "Please enter place of examination"
                , "rating[]": "Please enter a valid rating number" // Custom error message for invalid rating
            }, '.civil-service-entry', function(entry) {
                // Skip validation if the entire entry is hidden
                if (entry.closest(':hidden').length > 0) {
                    return true;
                }

                let eligibilityType = entry.find('input[name^="eligibility_type"]:visible');
                let examDate = entry.find('input[name^="exam_date"]:visible');
                let examPlace = entry.find('input[name^="exam_place"]:visible');
                let rating = entry.find('input[name^="rating"]:visible');
                let valid = true;

                if (eligibilityType.length && eligibilityType.val().trim() === '') {
                    eligibilityType.addClass('is-invalid');
                    eligibilityType.after('<span class="text-danger">Please enter eligibility name</span>');
                    valid = false;
                }
                if (examDate.length && examDate.val().trim() === '') {
                    examDate.addClass('is-invalid');
                    examDate.after('<span class="text-danger">Please select date of examination</span>');
                    valid = false;
                }
                if (examPlace.length && examPlace.val().trim() === '') {
                    examPlace.addClass('is-invalid');
                    examPlace.after('<span class="text-danger">Please enter place of examination</span>');
                    valid = false;
                }
                if (rating.length && (isNaN(rating.val()) || rating.val().trim() === '')) {
                    rating.addClass('is-invalid');
                    rating.after('<span class="text-danger">Please enter a valid rating number</span>');
                    valid = false;
                }

                return valid;
            });
        }



        // **Validation for Children Form**
        if ($('#childInfo').length) {
            validateDynamicForm('#childInfo', {
                "child_name[]": {
                    required: true
                }
                , "child_birthdate[]": {
                    required: true
                    , date: true
                }
            }, {
                "child_name[]": "Please enter child's name"
                , "child_birthdate[]": "Please enter a valid birthdate"
            }, '.child-entry', function(entry) {
                // Skip validation if the card is hidden
                if (entry.is(':hidden')) return true;

                let childName = entry.find('input[name^="child_name"]');
                let childBirthdate = entry.find('input[name^="child_birthdate"]');
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                if (childName.val().trim() === '') {
                    childName.addClass('is-invalid');
                    childName.after('<span class="text-danger">Please enter child name</span>');
                    valid = false;
                }
                if (childBirthdate.val().trim() === '') {
                    childBirthdate.addClass('is-invalid');
                    childBirthdate.after('<span class="text-danger">Please select birthdate</span>');
                    valid = false;
                }

                return valid;
            });
        }

        if ($('#educationForm').length) {
            validateDynamicForm('#educationForm', {
                "school_name[]": {
                    required: true
                }
                , "year_from[]": {
                    required: true
                    , validYear: true // Custom validation rule
                }
                , "year_to[]": {
                    required: true
                    , validYear: true // Custom validation rule
                }
                , "year_graduated[]": {
                    validYear: true // Custom validation rule (optional)
                }
            }, {
                "school_name[]": "Please enter the school name"
                , "year_from[]": "Please enter a valid start year (YYYY)"
                , "year_to[]": "Please enter a valid end year (YYYY)"
                , "year_graduated[]": "Please enter a valid graduation year (YYYY)"
            }, '.education-entry', function(entry) {
                let valid = true;

                // Remove previous validation messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Loop through each education entry and validate the year fields
                entry.find('input[name^="year_from[]"]').each(function() {
                    let yearFrom = $(this);
                    if (!isValidYear(yearFrom.val())) {
                        yearFrom.addClass('is-invalid');
                        yearFrom.after('<span class="text-danger">Please enter a valid start year (YYYY)</span>');
                        valid = false;
                    }
                });

                entry.find('input[name^="year_to[]"]').each(function() {
                    let yearTo = $(this);
                    if (!isValidYear(yearTo.val())) {
                        yearTo.addClass('is-invalid');
                        yearTo.after('<span class="text-danger">Please enter a valid end year (YYYY)</span>');
                        valid = false;
                    }
                });

                entry.find('input[name^="year_graduated[]"]').each(function() {
                    let yearGraduated = $(this);
                    if (yearGraduated.val() && !isValidYear(yearGraduated.val())) {
                        yearGraduated.addClass('is-invalid');
                        yearGraduated.after('<span class="text-danger">Please enter a valid graduation year (YYYY)</span>');
                        valid = false;
                    }
                });

                // Validate school name
                let schoolName = entry.find('input[name^="school_name"]');
                if (schoolName.val().trim() === '') {
                    schoolName.addClass('is-invalid');
                    schoolName.after('<span class="text-danger">Please enter the school name</span>');
                    valid = false;
                }

                return valid;
            });
        }






        if ($('#experiencForm').length) {
            validateDynamicForm('#experiencForm', {
                "department_agency_office_company[]": {
                    required: true
                }
                , "position_title[]": {
                    required: true
                }
                , "from_date[]": {
                    required: true
                    , date: true
                }
                , "to_date[]": {
                    required: true
                    , date: true
                    , validateEndDate: true // Custom validation for to_date
                }
                , "monthly_salary[]": {
                    required: true
                    , number: true
                }
                , "salary_grade[]": {
                    required: true
                }
                , "status_of_appointment[]": {
                    required: true
                }
                , "govt_service[]": {
                    required: true
                }
            }, {
                "department_agency_office_company[]": "Company/Agency name cannot be empty."
                , "position_title[]": "Please provide the position title."
                , "from_date[]": "Start date is required. Use a valid date format."
                , "to_date[]": "End date is required. Use a valid date format."
                , "monthly_salary[]": "Enter a valid monthly salary (numbers only)."
                , "salary_grade[]": "Salary grade is required. If not applicable, enter 'N/A'."
                , "status_of_appointment[]": "Specify the appointment status (e.g., permanent, contractual)."
                , "govt_service[]": "Indicate if this is government service (Yes or No)."
            }, '.work-experience-entry', function(entry) {
                let valid = true;

                if (entry.is(':hidden')) {
                    return true;
                }

                entry.find('input, select').each(function() {
                    let input = $(this);
                    let fieldName = input.attr('name');
                    let errorMessage = "";

                    switch (fieldName) {
                        case "department_agency_office_company[]":
                            errorMessage = "Company/Agency name is required.";
                            break;
                        case "position_title[]":
                            errorMessage = "Position title must be provided.";
                            break;
                        case "from_date[]":
                            errorMessage = "Enter a valid 'From' date.";
                            break;
                        case "to_date[]":
                            errorMessage = "Enter a valid 'To' date.";
                            break;
                        case "monthly_salary[]":
                            errorMessage = "Monthly salary must be a valid number.";
                            break;
                        case "salary_grade[]":
                            errorMessage = "Salary grade is required (enter 'N/A' if not applicable).";
                            break;
                        case "status_of_appointment[]":
                            errorMessage = "Specify the appointment status (e.g., permanent, contractual).";
                            break;
                        case "govt_service[]":
                            errorMessage = "Indicate whether this is government service.";
                            break;
                    }

                    // Field validation
                    if (input.val().trim() === '') {
                        input.addClass('is-invalid');
                        if (!input.next('.text-danger').length) {
                            input.after('<span class="text-danger">' + errorMessage + '</span>');
                        }
                        valid = false;
                    } else {
                        input.removeClass('is-invalid');
                        input.next('.text-danger').remove();
                    }
                });

                // Custom validation for checking that to_date is after from_date
                let fromDate = entry.find('input[name^="from_date[]"]');
                let toDate = entry.find('input[name^="to_date[]"]');

                let fromDateVal = fromDate.val();
                let toDateVal = toDate.val();

                if (fromDateVal && toDateVal) {
                    let fromDateParsed = moment(fromDateVal, 'DD MMM, YYYY');
                    let toDateParsed = moment(toDateVal, 'DD MMM, YYYY');

                    // Check if to_date is before from_date
                    if (toDateParsed.isBefore(fromDateParsed)) {
                        toDate.addClass('is-invalid');
                        if (!toDate.next('.text-danger').length) {
                            toDate.after('<span class="text-danger">End date must be later than start date.</span>');
                        }
                        valid = false;
                    }
                }

                return valid;
            });
        }


        if ($('#voluntaryForm').length) {
            validateDynamicForm('#voluntaryForm', {
                "organization_name[]": {
                    required: true
                }
                , "voluntary_from_date[]": {
                    required: true
                    , date: true
                }
                , "voluntary_to_date[]": {
                    required: true
                    , date: true
                }
                , "voluntary_hours[]": {
                    required: true
                    , number: true
                    , min: 1
                }
                , "position_nature_of_work[]": {
                    required: true
                }
            }, {
                "organization_name[]": "Please enter organization name and address"
                , "voluntary_from_date[]": "Please enter a valid from date"
                , "voluntary_to_date[]": "Please enter a valid to date"
                , "voluntary_hours[]": "Please enter the number of hours"
                , "position_nature_of_work[]": "Please enter position or nature of work"
            }, '.voluntary-work-entry', function(entry) {
                if (entry.is(':hidden')) {
                    return true; // Skip validation for hidden cards
                }

                let orgName = entry.find('input[name^="organization_name"]');
                let fromDate = entry.find('input[name^="voluntary_from_date"]');
                let toDate = entry.find('input[name^="voluntary_to_date"]');
                let hours = entry.find('input[name^="voluntary_hours"]');
                let position = entry.find('input[name^="position_nature_of_work"]');
                let valid = true;

                // Remove previous error messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate fields
                if (orgName.val().trim() === '') {
                    orgName.addClass('is-invalid');
                    orgName.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }
                if (fromDate.val().trim() === '') {
                    fromDate.addClass('is-invalid');
                    fromDate.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }
                if (toDate.val().trim() === '') {
                    toDate.addClass('is-invalid');
                    toDate.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }
                if (hours.val().trim() === '' || parseInt(hours.val()) <= 0) {
                    hours.addClass('is-invalid');
                    hours.after('<span class="text-danger">Required field (must be at least 1)</span>');
                    valid = false;
                }
                if (position.val().trim() === '') {
                    position.addClass('is-invalid');
                    position.after('<span class="text-danger">Required field</span>');
                    valid = false;
                }

                // Custom validation for checking that to_date is after from_date
                let fromDateVal = fromDate.val();
                let toDateVal = toDate.val();

                if (fromDateVal && toDateVal) {
                    let fromDateParsed = moment(fromDateVal, 'DD MMM, YYYY');
                    let toDateParsed = moment(toDateVal, 'DD MMM, YYYY');

                    // Check if to_date is after from_date
                    if (toDateParsed.isBefore(fromDateParsed)) {
                        toDate.addClass('is-invalid');
                        toDate.after('<span class="text-danger">End date must be later than start date.</span>');
                        valid = false;
                    }
                }

                return valid;
            });

            // Custom validation method for the date_to > date_from validation
            $.validator.addMethod("validateEndDate", function(value, element) {
                let fromDateVal = $(element).closest('.voluntary-work-entry').find('input[name^="voluntary_from_date"]').val();
                if (fromDateVal) {
                    let fromDateParsed = moment(fromDateVal, 'DD MMM, YYYY');
                    let toDateParsed = moment(value, 'DD MMM, YYYY');
                    return toDateParsed.isAfter(fromDateParsed);
                }
                return true;
            }, "End date must be later than start date.");
        }



        if ($('#trainingForm').length) {
            validateDynamicForm('#trainingForm', {
                "training_title[]": {
                    required: true
                }
                , "training_from_date[]": {
                    required: true
                    , date: true
                }
                , "training_to_date[]": {
                    required: true
                    , date: true
                }
                , "training_hours[]": {
                    required: true
                    , number: true
                }
                , "type_of_ld[]": {
                    required: true
                }
                , "conducted_by[]": {
                    required: true
                }
            }, {
                "training_title[]": "Please enter the training title"
                , "training_from_date[]": "Please enter a valid from date"
                , "training_to_date[]": "Please enter a valid to date"
                , "training_hours[]": "Please enter the number of hours"
                , "type_of_ld[]": "Please enter the type of L&D"
                , "conducted_by[]": "Please enter the conducting organization"
            }, '.training-entry', function(entry) {
                if (entry.is(':hidden')) {
                    return true; // Skip validation for hidden cards
                }

                let valid = true;

                // Define fields and messages
                let fields = [{
                        input: entry.find('input[name^="training_title"]')
                        , message: "Training title is required."
                    }
                    , {
                        input: entry.find('input[name^="training_from_date"]')
                        , message: "Start date is required and must be a valid date."
                    }
                    , {
                        input: entry.find('input[name^="training_to_date"]')
                        , message: "End date is required and must be a valid date."
                    }
                    , {
                        input: entry.find('input[name^="training_hours"]')
                        , message: "Training hours are required and must be a number."
                    }
                    , {
                        input: entry.find('input[name^="type_of_ld"]')
                        , message: "Type of L&D is required."
                    }
                    , {
                        input: entry.find('input[name^="conducted_by"]')
                        , message: "Conducting organization is required."
                    }
                ];

                // Remove previous error messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate each field
                fields.forEach(field => {
                    if (field.input.val().trim() === '') {
                        field.input.addClass('is-invalid').after(`<span class="text-danger">${field.message}</span>`);
                        valid = false;
                    }
                });

                // Custom validation: Ensure 'to_date' is later than 'from_date'
                let fromDate = entry.find('input[name^="training_from_date"]').val();
                let toDate = entry.find('input[name^="training_to_date"]').val();

                if (fromDate && toDate) {
                    // Parse dates
                    let start = new Date(fromDate);
                    let end = new Date(toDate);

                    // Compare the dates
                    if (end < start) {
                        entry.find('input[name^="training_to_date"]').addClass('is-invalid').after('<span class="text-danger">End date must be after the start date.</span>');
                        valid = false;
                    }
                }

                return valid;
            });
        }



        if ($('#otherForm').length) {
            validateDynamicForm('#otherForm', {
                "special_skills_hobbies[]": {
                    required: true
                }
                , "non_academic_distinctions[]": {
                    required: true
                }
                , "membership_associations[]": {
                    required: true
                }
            }, {
                "special_skills_hobbies[]": "Please enter the skills or hobbies"
                , "non_academic_distinctions[]": "Please enter the awards or recognitions"
                , "membership_associations[]": "Please enter the professional affiliations"
            }, '.other-info-entry', function(entry) {
                // Skip validation if the card is hidden
                if (entry.is(':hidden')) {
                    return true; // Skip validation for hidden cards
                }

                let valid = true;

                // Define fields and messages
                let fields = [{
                        input: entry.find('input[name^="special_skills_hobbies"]')
                        , message: "Special skills & hobbies is required."
                    }
                    , {
                        input: entry.find('input[name^="non_academic_distinctions"]')
                        , message: "Non-academic distinctions is required."
                    }
                    , {
                        input: entry.find('input[name^="membership_associations"]')
                        , message: "Membership in associations is required."
                    }
                ];

                // Remove previous error messages
                entry.find('.text-danger').remove();
                entry.find('.is-invalid').removeClass('is-invalid');

                // Validate each field
                fields.forEach(field => {
                    if (field.input.val().trim() === '') {
                        field.input.addClass('is-invalid').after(`<span class="text-danger">${field.message}</span>`);
                        valid = false;
                    }
                });

                return valid;
            });
        }


        $('#govIdsForm').validate({
            rules: {
                gsis_id_no: {
                    required: true
                    , maxlength: 20
                }
                , pagibig_no: {
                    required: true
                    , maxlength: 20
                }
                , philhealth_no: {
                    required: true
                    , maxlength: 20
                }
                , sss_no: {
                    required: true
                    , maxlength: 20
                }
                , tin_no: {
                    required: true
                    , maxlength: 20
                }
                , agency_employee_no: {
                    maxlength: 50
                }
            }
            , messages: {
                gsis_id_no: {
                    required: "Please enter your GSIS ID No."
                    , maxlength: "GSIS ID No. must not exceed 20 characters."
                }
                , pagibig_no: {
                    required: "Please enter your Pag-IBIG No."
                    , maxlength: "Pag-IBIG No. must not exceed 20 characters."
                }
                , philhealth_no: {
                    required: "Please enter your PhilHealth No."
                    , maxlength: "PhilHealth No. must not exceed 20 characters."
                }
                , sss_no: {
                    required: "Please enter your SSS No."
                    , maxlength: "SSS No. must not exceed 20 characters."
                }
                , tin_no: {
                    required: "Please enter your TIN No."
                    , maxlength: "TIN No. must not exceed 20 characters."
                }
                , agency_employee_no: {
                    maxlength: "Agency Employee No. must not exceed 50 characters."
                }
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });

        $('#personalInfo').validate({
            rules: {
                gender: 'required'
                , height: {
                    required: true
                    , number: true
                    , min: 0.5, // Minimum valid height (e.g., 50 cm)
                    max: 3 // Maximum valid height (e.g., 3 meters)
                }
                , weight: {
                    required: true
                    , number: true
                    , min: 1, // Minimum valid weight (1 kg)
                    max: 500 // Maximum valid weight (500 kg)
                }
                , blood_type: 'required'
                , nationality: 'required'
                , civil_status: 'required'
            }
            , messages: {
                gender: 'Please select gender'
                , height: {
                    required: 'Please enter height'
                    , number: 'Height must be a valid number'
                    , min: 'Height must be at least 0.5 meters'
                    , max: 'Height cannot exceed 3 meters'
                }
                , weight: {
                    required: 'Please enter weight'
                    , number: 'Weight must be a valid number'
                    , min: 'Weight must be at least 1 kg'
                    , max: 'Weight cannot exceed 500 kg'
                }
                , blood_type: 'Please enter blood type'
                , nationality: 'Please enter nationality'
                , civil_status: 'Please enter civil status'
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });

        $('#family_validate').validate({
            rules: {
                father_name: 'required'
                , mother_name: 'required'
                , spouse_name: 'required'
                , spouse_occupation: 'required'
                , spouse_employer: 'required'
            }
            , messages: {
                father_name: 'Please enter father\'s name'
                , mother_name: 'Please enter mother\'s name'
                , spouse_name: 'Please enter spouse\'s name'
                , spouse_occupation: 'Please enter spouse\'s occupation'
                , spouse_employer: 'Please enter spouse\'s employer'
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });

        $('#profileForm').validate({
            rules: {
                fname: {
                    required: true
                }
                , mname: {
                    required: true
                }
                , lname: {
                    required: true
                }
                , birth_date: {
                    required: true
                    , date: true
                }
                , residential_address: {
                    required: true
                }
                , residential_zip: {
                    required: true
                    , digits: true
                    , minlength: 4
                    , maxlength: 4
                }
                , permanent_address: {
                    required: true
                }
                , permanent_zip: {
                    required: true
                    , digits: true
                    , minlength: 4
                    , maxlength: 4
                }
                , phone_number: {
                    required: true
                    , digits: true
                    , minlength: 11
                    , maxlength: 11
                }
                , mobile_number: {
                    required: true
                    , digits: true
                    , minlength: 11
                    , maxlength: 11
                }
            }
            , messages: {
                fname: "Please enter first name"
                , mname: "Please enter middle name"
                , lname: "Please enter last name"
                , birth_date: "Please enter a valid birth date"
                , residential_address: "Please enter residential address"
                , residential_zip: {
                    required: "Please enter your residential zip code"
                    , digits: "Zip code must contain only digits"
                    , minlength: "Zip code must be 4 digits long"
                    , maxlength: "Zip code must be 4 digits long"
                }
                , permanent_address: "Please enter permanent address"
                , permanent_zip: {
                    required: "Please enter your permanent zip code"
                    , digits: "Zip code must contain only digits"
                    , minlength: "Zip code must be 4 digits long"
                    , maxlength: "Zip code must be 4 digits long"
                }
                , phone_number: {
                    required: "Please enter your phone number"
                    , digits: "Phone number must contain only digits"
                    , minlength: "Phone number must be exactly 11 digits"
                    , maxlength: "Phone number must be exactly 11 digits"
                }
                , mobile_number: {
                    required: "Please enter your mobile number"
                    , digits: "Mobile number must contain only digits"
                    , minlength: "Mobile number must be exactly 11 digits"
                    , maxlength: "Mobile number must be exactly 11 digits"
                }
            }
            , submitHandler: function(form) {
                form.submit();
            }
        });
    });

</script>
