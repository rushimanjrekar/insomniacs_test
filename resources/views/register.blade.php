<!doctype html>

<html lang="en">

  <head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>laravel 6 Ajax Form Submission Example</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

  <style>

   .error{ color:red; } 

  </style>

  <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}
th {
  text-align: left;
}
</style>


</head>

  

<body>

  

<div class="container">

    <h2 style="margin-top: 10px;">laravel 6 Ajax</h2>

    <br>

    <br>

    

    <form id="contact_us" method="post" action="javascript:void(0)">

      @csrf

      <div class="form-group">

        <label for="formGroupExampleInput">Name</label>

        <input type="text" name="name" class="form-control" id="formGroupExampleInput" placeholder="Please enter name">

        <span class="text-danger">{{ $errors->first('name') }}</span>

      </div>

      <div class="form-group">

        <label for="email">Email Id</label>

        <input type="text" name="email" class="form-control" id="email" placeholder="Please enter email id">

        <span class="text-danger">{{ $errors->first('email') }}</span>

      </div>      

      <div class="form-group">

        <label for="phone_no">Mobile Number</label>

        <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Please enter mobile number" maxlength="10">

        <span class="text-danger">{{ $errors->first('phone_no') }}</span>

      </div>

      <div class="alert alert-success d-none" id="msg_div">

              <span id="res_message"></span>

      </div>

      <div class="form-group">

       <button type="submit" id="send_form" class="btn btn-success">Submit</button>

      </div>


<table style="width:100%">
<thead>
  <tr>
    <th>Name</th>
    <th>Phone No</th> 
    <th>Email</th>
  </tr>
</thead>
<tbody>
   @foreach($details as $detail)
  <tr>
  <td>{{ $detail->name }}</td>
  <td>{{ $detail->phone_no }}</td>
  <td>{{ $detail->email }}</td>
  
  </tr>  
  @endforeach
</tbody>  
  </table>




    </form>

  

</div>

<script>

   if ($("#contact_us").length > 0) {

    $("#contact_us").validate({

      

    rules: {

      name: {

        required: true,

        maxlength: 50

      },

  

       phone_no: {

            required: true,

            digits:true,

            minlength: 10,

            maxlength:12,

        },

        email: {

                required: true,

                maxlength: 50,

                email: true,

            },    

    },

    messages: {

        

      name: {

        required: "Please enter name",

        maxlength: "Your last name maxlength should be 50 characters long."

      },

      phone_no: {

        required: "Please enter contact number",

        digits: "Please enter only numbers",

        minlength: "The contact number should be 10 digits",

        maxlength: "The contact number should be 12 digits",

      },

      email: {

          required: "Please enter valid email",

          email: "Please enter valid email",

          maxlength: "The email name should less than or equal to 50 characters",

        },

         

    },

    submitHandler: function(form) {

     $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });

      $('#send_form').html('Sending..');

      $.ajax({

        url: 'http://localhost/form/contact-form' ,

        type: "POST",

        data: $('#contact_us').serialize(),

        success: function( response ) {

            $('#send_form').html('Submit');

            $('#res_message').show();

            $('#res_message').html(response.msg);

            $('#msg_div').removeClass('d-none');


            document.getElementById("contact_us").reset(); 

            setTimeout(function(){

            $('#res_message').hide();

            $('#msg_div').hide();

            },10000);

        }

      });

    }

  })

}

</script>

</body>

</html>