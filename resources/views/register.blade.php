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
         <h2 style="margin-top: 10px;">Register Form Using OTP</h2>
         <br>
         <form id="contact_us" method="POST" action="#">
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Please enter name">
               <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="form-group">
               <label for="email">Email Id</label>
               <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email" placeholder="Please enter email id">
               <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
            <div class="form-group">
               <label for="phone_no">Mobile Number</label>
               <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Please enter mobile number" value="{{old('phone_no')}}" maxlength="12">
               <span class="text-danger">{{ $errors->first('phone_no') }}</span>
            </div>
            <div class="alert alert-success d-none" id="msg_div">
               <span id="res_message"></span>
            </div>
            <div class="form-group">
               <button type="submit" id="send_otp" value="otp" class="btn btn-success sendotp">Send OTP</button>
            </div>
         </form>
         
         <form id="verify">
            {{ csrf_field() }}
            <div class="form-group" id="otpfield">
               <label for="phone_no">Enter OTP</label>
               <input type="text" name="otp" class="form-control" id="otp" placeholder="Please enter OTP number" value="{{old('otp')}}" maxlength="5" required="">
            </div>
            <div class="form-group">
               <button type="submit" id="send_form" value="form"  class="btn btn-success sendform">Submit</button>
            </div>
            <div class="alert alert-success"  style="display:none;" id="msg_div2">
               <span id="res_message2"></span>
            </div>
            @if(session()->get('success'))
            <div class="alert alert-success">
               {{ session()->get('success') }}  
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
               <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
            @endif

          </form>
          
            <table style="width:100%">
               <thead>
                  <tr>
                     <th>Name</th>
                     <th>Phone No</th>
                     <th>Email</th>
                  </tr>
               </thead>
               <tbody id="tbody">
                  @foreach($details as $detail)
                  <tr>
                     <td>{{ $detail->name }}</td>
                     <td>{{ $detail->phone_no }}</td>
                     <td>{{ $detail->email }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         
      </div>
      <script type="text/javascript">
         $(document).ready(function(){
           $('#otpfield').hide();
           $('#send_form').hide();
         });
         
         
         $('.sendotp').click(function(){
            
             if($("#contact_us").length > 0) {
         
             $("#contact_us").validate({
            
                rules: {
                  name: {
                    required: true,
                    maxlength: 50
                  },
            
                  phone_no: {
                    required: true,
                    digits:true,
                    minlength: 12,
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
                  minlength: "The contact number should be 12 digits",
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
            
                $('#send_otp').html('Sending..');
                $.ajax({
                  url: "{{url('/contact-form')}}" ,
                  type: "POST",
                  data: $('#contact_us').serialize(),
                  success: function( response ) {
            
                      $('#send_otp').html('Submit');
                      $('#res_message').show();
                      $('#res_message').html(response.msg);
            
                      $('#otpfield').show();
                      $('#send_form').show();
                      $('#send_otp').hide();
            
                      $('#msg_div').removeClass('d-none');
                                            
                      setTimeout(function(){
                        $('#res_message').hide();
                        $('#msg_div').hide();
                      },10000);

                      
                  }
            
                });
            
              }
            
             })
         
            }     
         });
         
         
         
         $('.sendform').click(function(){

          $("#verify").validate({
            rules: {
                  otp: {
                    required: true,
                    maxlength: 4
                  }
            },
            messages: {
                  otp: {
                    required: "Please enter otp",
                    maxlength: "Your opt should be 4 characters long."
                  }
            },
            submitHandler: function(form) {
              $.ajaxSetup({
                  headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
         
               $.ajax({
                 url: "{{url('/verifyOtp')}}" ,
                 type: "POST",
                 data: $('#verify').serialize(),
                 success: function( response ) {
                    console.log(response);
                    $('#res_message2').show();
                    $('#res_message2').html(response.msg);

                    $('#msg_div2').show();

                    if( response.statusCode == 200 ) {
                        var html =  '<tr>'+
                                     '<td>'+ $('#name').val() +'</td>'+
                                     '<td>'+ $('#phone_no').val() +'</td>'+
                                     '<td>'+ $('#email').val() +'</td>'+
                                    '</tr>';

                        $('#tbody').append(html);
                    }

                    document.getElementById("contact_us").reset();
                    document.getElementById("verify").reset();
                 }
              })
            }
         });
         
       
        })
         
      </script>
   </body>
</html>