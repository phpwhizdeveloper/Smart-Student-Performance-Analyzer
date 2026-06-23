<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Academic Marks Entry</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSRF Token for Laravel AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; }
        .form-label { font-weight: 500; }
    </style>
</head>
<body class="py-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card p-4">
                <h4 class="mb-3 text-success">Add Student Marks</h4>
                <form id="marksForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Student ID</label>
                        <input type="number" class="form-control" name="student_id" placeholder="Enter Student ID">
                        <div class="text-danger small error-student_id mt-1"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject ID</label>
                        <input type="number" class="form-control" name="subject_id" placeholder="Enter Subject ID">
                        <div class="text-danger small error-subject_id mt-1"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marks (0 - 100)</label>
                        <input type="number" class="form-control" name="marks" min="0" max="100" placeholder="Enter Marks">
                        <div class="text-danger small error-marks mt-1"></div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Save Marks</button>
                </form>
                <div id="marksAlert" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 Bundle JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function resetErrors(form, alertContainer) {
        form.find('.form-control').removeClass('is-invalid');
        form.find('.text-danger').html('');
        $(alertContainer).html('');
    }

    function showFieldErrors(form, errors) {
        $.each(errors, function(key, value) {
            let inputField = form.find('[name="' + key + '"]');
            inputField.addClass('is-invalid');
            form.find('.error-' + key).html(value[0]);
        });
    }

    function validateFormEmptyFields(form) {
        let localErrors = {};
        let isValid = true;
        form.find('.form-control').each(function() {
            if ($(this).val().trim() === "") {
                let fieldName = $(this).attr('name');
                localErrors[fieldName] = ["This field is required."];
                isValid = false;
            }
        });
        if (!isValid) { showFieldErrors(form, localErrors); }
        return isValid;
    }

    $('#marksForm').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        resetErrors(form, '#marksAlert');

        if (!validateFormEmptyFields(form)) { return false; }

        $.ajax({
            url: "{{ url('/marks') }}", // Updated endpoint targeting your standard web controller path
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#marksAlert').html('<div class="alert alert-success">' + response.success + '</div>');
                form[0].reset();
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    showFieldErrors(form, errors);
                } else {
                    $('#marksAlert').html('<div class="alert alert-danger">An unexpected error occurred.</div>');
                }
            }
        });
    });
});
</script>
</body>
</html>
