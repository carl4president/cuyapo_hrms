    {{-- update --}}
    <script>
        $(document).ready(function() {
            var url = "{{ route('hr/get/information/emppos') }}";

            // Function to reset a dropdown with a placeholder
            function resetDropdown(selector, placeholder) {
                $(selector).empty(); // Clear all options
                $(selector).append(`<option value="" disabled selected>${placeholder}</option>`);
            }

            // Function to populate designations based on departmentId
            function populatePositions(departmentId, preselectedPositionId = null, dropdownSelector = '#position') {
                if (departmentId) {
                    $(dropdownSelector).html('<option disabled selected>Loading...</option>');
                    $.ajax({
                        url: url
                        , type: "POST"
                        , data: {
                            id: departmentId
                            , _token: $('meta[name="csrf-token"]').attr("content")
                        }
                        , dataType: "json"
                        , success: function(response) {
                            console.log(preselectedPositionId);

                            if (response.positions) {
                                resetDropdown(dropdownSelector, 'Select Position');
                                response.positions.forEach((position) => {
                                    $(dropdownSelector).append(
                                        `<option value="${position.id}" ${
                                preselectedPositionId == position.id ? "selected" : ""
                            }>${position.position_name}</option>`
                                    );
                                });
                            }
                        }
                        , error: function(xhr, status, error) {
                            console.error("Error fetching positions:", error);
                        }
                    });
                }
            }



            // Event listener for opening the Edit Job modal
            $(document).on('click', '.edit_job', function() {
                var _this = $(this).parents('tr');


                // Populate form fields
                $('#e_id').val(_this.find('.id').text());
                $('#e_no_of_vacancies').val(_this.find('.no_of_vacancies').text());
                $('#e_experience').val(_this.find('.experience').text());
                $('#e_salary_from').val(_this.find('.salary_from').text());
                $('#e_salary_to').val(_this.find('.salary_to').text());
                $('#e_start_date').val(_this.find('.start_date').text());
                $('#e_expired_date').val(_this.find('.expired_date').text());
                $('#e_age').val(_this.find('.age').text());
                $('#e_description').val(_this.find('.description').text());

                // Get IDs from the clicked row
                var departmentId = _this.find('.department_id').text();
                var positionId = _this.find('.position').text();

                // Set the department value directly (without triggering change)...
                $('#e_department').val(departmentId);
                // ...and then explicitly call populateDesignations with the preselected designation
                populatePositions(departmentId, positionId, '#e_position');
                // Populate positions after a slight delay to ensure designations are loaded
                setTimeout(() => {}, 300);

                // Set job type and status
                var job_type = _this.find(".job_type").text();
                var _option = '<option selected value="' + job_type + '">' + _this.find('.job_type').text() + '</option>'
                $(_option).appendTo("#e_job_type");


                var status = _this.find(".status").text();
                var _option = '<option selected value="' + status + '">' + _this.find('.status').text() + '</option>'
                $(_option).appendTo("#e_status");
            });

            // Event listener for department dropdown change (for user-initiated changes)
            $('#e_department').off('change').on('change', function() {
                const departmentId = $(this).val();
                populatePositions(departmentId, null, '#e_position')
            });
            
            

        });

    </script>
