<!-- resources/views/query-form.blade.php -->


</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Query Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="queryInput">Write your query:</label>
                                <input type="text" class="form-control" id="queryInput" name="query" placeholder="Your query here" required>
                            </div>
                            <button  id="btn" class="btn btn-danger">Submit</button>
                        </form>

                    </div>
                    <div id="apiResponseDiv">
                        <p id="apiResponseParagraph"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- <script>
    // public/js/main.js

$(document).ready(function () {
    // Handle form submission with AJAX
    var button = document.getElementById("btn");
    button.addEventListener("click", function ()  {
        event.preventDefault();
      alert('btn is click');
        // Get the form data
        var formData = $(this).serialize();

        // Send the AJAX request
        $.ajax({
            url: "{{route('open-ai')}}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Display success message
                alert(response.message);

                // You can update the page content or take other actions as needed here
            },
            error: function (xhr, status, error) {
                // Handle errors if any
                alert('Error occurred: ' + error);
            }
        });
    });
});

</script> --}}

<script>
    // public/js/main.js

    $(document).ready(function () {
        // Handle form submission with AJAX
        var button = document.getElementById("btn");
        button.addEventListener("click", function (event) {
            event.preventDefault();

            // Get the form data
            var formData = $(this).serialize();

            // Get the CSRF token from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Send the AJAX request
            $.ajax({
                url: "{{ route('open-ai') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
                },
                success: function (response) {
                    // Display success message
                    const apiResponse = JSON.parse(response);
                    console.log(apiResponse);
                    const apiResponseParagraph = document.getElementById('apiResponseParagraph');

// Set the content of the <p> element to the "content" field from the JSON response
                             apiResponseParagraph.textContent = apiResponse.content;
console.log(response);
                   // alert(response);

                    // You can update the page content or take other actions as needed here
                },
                error: function (xhr, status, error) {
                    // Handle errors if any
                    alert('Error occurred: ' + error);
                }
            });
        });
    });
</script>

</body>
</html>
