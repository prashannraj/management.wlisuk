<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="company_name">Company Name :</label>
            <input type="text" name="company_name" value="{{ old('company_name', optional($data['serviceproviders'])->company_name) }}" class="form-control" id="company_name">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="address">Company Address :</label>
            <input type="text" name="address" value="{{ old('address', optional($data['serviceproviders'])->address) }}" class="form-control" id="address">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="regulated_by">Regulated By :</label>
            <input type="text" name="regulated_by" value="{{ old('regulated_by', optional($data['serviceproviders'])->regulated_by) }}" class="form-control" id="regulated_by">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="email_one">Company Email :</label>
            <input type="email" name="email_one" value="{{ old('email_one', optional($data['serviceproviders'])->email_one) }}" class="form-control" id="email_one">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="email_two">Company Email 2 :</label>
            <input type="email" name="email_two" value="{{ old('email_two', optional($data['serviceproviders'])->email_two) }}" class="form-control" id="email_two">
        </div>
    </div>
</div>

<!-- Main Contact Section -->
<div class="row">
    <div class="col-12 text-center">
        <h3>Main Contact</h3>
    </div>
    <!-- Start Main Contact Fields Container -->
    <div id="main_contact_fields_container">
        <!-- First Main Contact (Initially present) -->
        <div class="row" id="contact_group_0">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="main_contact_name_0">Main Contact 1 Name :</label>
                    <input type="text" name="main_contact[0][name]" value="{{ old('main_contact.0.name') }}" class="form-control" id="main_contact_name_0">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="main_contact_phone_0">Main Contact 1 Phone :</label>
                    <input type="text" name="main_contact[0][phone]" value="{{ old('main_contact.0.phone') }}" class="form-control" id="main_contact_phone_0">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="main_contact_email_0">Main Contact 1 Email :</label>
                    <input type="email" name="main_contact[0][email]" value="{{ old('main_contact.0.email') }}" class="form-control" id="main_contact_email_0">
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-danger remove_contact" data-index="0">Remove Contact</button>
            </div>
        </div>
    </div>
    <!-- End Main Contact Fields Container -->

    <!-- Add Button for New Contacts -->
    <div class="col-md-12 text-center">
        <button type="button" id="add_main_contact" class="btn btn-primary">Add Another Main Contact</button>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
    // Initialize datepicker
    $('.datepicker').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });

    // Function to add new main contact fields dynamically
    let contactIndex = 1;  // Start with the first additional contact
    $('#add_main_contact').on('click', function() {
        const newContactFieldHtml = `
            <div class="row" id="contact_group_${contactIndex}">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="main_contact_name_${contactIndex}">Main Contact ${contactIndex + 1} Name :</label>
                        <input type="text" name="main_contact[${contactIndex}][name]" class="form-control" id="main_contact_name_${contactIndex}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="main_contact_phone_${contactIndex}">Main Contact ${contactIndex + 1} Phone :</label>
                        <input type="text" name="main_contact[${contactIndex}][phone]" class="form-control" id="main_contact_phone_${contactIndex}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="main_contact_email_${contactIndex}">Main Contact ${contactIndex + 1} Email :</label>
                        <input type="email" name="main_contact[${contactIndex}][email]" class="form-control" id="main_contact_email_${contactIndex}">
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-danger remove_contact" data-index="${contactIndex}">Remove Contact</button>
                </div>
            </div>
        `;
        // Append new fields to the container without changing the position of the heading
        $('#main_contact_fields_container').append(newContactFieldHtml);
        contactIndex++;
    });

    // Remove main contact field
    $(document).on('click', '.remove_contact', function() {
        const index = $(this).data('index');
        $(`#contact_group_${index}`).remove();
    });
</script>
@endpush
