@extends('admin.layouts.sidebar')
@section('tittle', 'Set Notification')
@section('page', 'Set Notification')
@section('content')
    <div class="card h-auto">
        <div class="card-body">
            <form id="postm">
                @csrf
            <label  class="form-label" for="editor">Broadcast Message</label>
{{--            <textarea id="ckeditor"></textarea>--}}
            <textarea name="message" id="editor">{{$message->message}}</textarea><br>
                <hr>
                <button type="submit" class="btn btn-primary">Post Message</button>
            </form>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#postm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Processing',
                    text: 'Please wait...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });
                $('#loadingSpinner').show();
                $.ajax({
                    url: "{{ route('admin/mes') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle the success response here
                        $('#loadingSpinner').hide();

                        console.log(response);
                        // Update the page or perform any other actions based on the response

                        if (response.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {
                                location.reload(); // Reload the page
                            });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Pending',
                                text: response.message
                            });
                            // Handle any other response status
                        }

                    },
                    error: function(xhr) {
                        $('#loadingSpinner').hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'fail',
                            text: xhr.responseText
                        });
                        // Handle any errors
                        console.log(xhr.responseText);

                    }
                });

                // Send the AJAX request
            });
        });

    </script>


@endsection
