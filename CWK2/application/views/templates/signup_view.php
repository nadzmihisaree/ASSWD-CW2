<?php
$this->load->view('templates/header.php');
?>

<div class="row m-0 overflow-hidden vh-100" id="signup">
    <div class="col-12 col-sm-6 p-0">
        <img src="../assets/images/signup-bbg.jpg" style="height: 100%; width:100%; object-fit: cover;" alt="">

    </div>
    <div class="col-12 col-sm-6">
        <div class="align-items-center d-flex flex-column py-5">
            <div class="d-flex justify-content-center pb-5">
                <img src="../assets/images/logo1.jpg" style="height: 20%; width:20%" alt="">
            </div>
            <div class="col-6">
                <form>
                    <h4>Sign <span style="color: var(--dark-brown)">Up</span></h4>
                    <input class="form_input my-3 p-3" type="text" id="username" placeholder="Name"><br>
                    <input class="form_input my-3 p-3" type="text" id="email" placeholder="Email"><br>

                    <div id="show_hide_password" class="my-3 align-items-center d-flex" style="background-color: var(--bg-dark-cream);">
                        <input class="form_input p-3" type="password" id="password" placeholder="Password">
                        <div class="input-group-addon pe-3" >
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div id="show_hide_confirmpassword" class="my-3 align-items-center d-flex" style="background-color: var(--bg-dark-cream);">
                        <input class="form_input p-3" type="password" id="reenter" placeholder="Re-Enter password"><br>
                        <div class="input-group-addon pe-3" >
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    

                    <div class="d-flex justify-content-center my-4">
                        <input class="submit_button p-2 " type="button" value="Sign Up">
                    </div>


                </form>
            </div>

            <P>Already Have an account? <a href="LogIn" style="color: var(--dark-brown);text-decoration: none;">Log In</a></P>

        </div>
    </div>
</div>

<!-- <form class="px-4">
                <div class="pt-4 pb-3 fw-bold login_name">Sign Up</div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="inputUserName" placeholder="Enter Username" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="inputEmail" placeholder="Enter Email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3 input-group" id="show_hide_password">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    <div class="input-group-addon" style="background-color:#a3a3a3; border-radius: 0 10px 10px 0; padding: 5px">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="mb-3 input-group" id="show_hide_confirmpassword">
                    <input type="password" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password">
                    <div class="input-group-addon" style="background-color:#a3a3a3; border-radius: 0 10px 10px 0; padding: 5px">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" type="button" id="signup">Signup</button>
                </div>
            </form> -->


<script>

   //block user from routing to other pages
   document.addEventListener('DOMComtentLoaded', function(event){
        console.log('DOM fully loaded and parsed');
        if(localStorage.getItem('user_id') == null){
            window.location.href = "https://w1790276.users.ecs.westminster.ac.uk/CWK2/index.php/Landing";
        }
    }); 
   
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });
    });
    $(document).ready(function() {
        $("#show_hide_confirmpassword a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_confirmpassword input').attr("type") == "text"){
                $('#show_hide_confirmpassword input').attr('type', 'password');
                $('#show_hide_confirmpassword i').addClass( "fa-eye-slash" );
                $('#show_hide_confirmpassword i').removeClass( "fa-eye" );
            }else if($('#show_hide_confirmpassword input').attr("type") == "password"){
                $('#show_hide_confirmpassword input').attr('type', 'text');
                $('#show_hide_confirmpassword i').removeClass( "fa-eye-slash" );
                $('#show_hide_confirmpassword i').addClass( "fa-eye" );
            }
        });
    });

    var SignupModel = Backbone.Model.extend({
        defaults: {
            username: '',
            email: '',
            password: '',
            reenter: ''
        }
    });
    
    var SignupView = Backbone.View.extend({
        el: '#signup',
        events: {
            'click .submit_button': 'signup'
        },
        initialize: function() {
            this.model = new SignupModel();
            this.listenTo(this.model, 'change', this.render);
        },
        render: function() {
            this.$el.find('#username').val(this.model.get('username'));
            this.$el.find('#email').val(this.model.get('email'));
            this.$el.find('#password').val(this.model.get('password'));
        },
        signup: function() {
            this.model.set({
                username: this.$el.find('#username').val(),
                email: this.$el.find('#email').val(),
                password: this.$el.find('#password').val(),
                reenter: this.$el.find('#reenter').val(),
            });
            if(this.model.get('email') == "" ){
                alert('Please enter email');
                // Show an error message or take other necessary action
            }
            else if(this.model.get('password') == "" ){
                alert('Please enter password');
                // Show an error message or take other necessary action
            }
            else if(this.model.get('reenter') == "" ){
                alert('Please confirm the password');
                // Show an error message or take other necessary action
            }
            else if(this.model.get('password') !== this.model.get('reenter') ){
                alert('Password and Confirm Password must be same');
                // Show an error message or take other necessary action
            }
            else{
                $.ajax({
                    url: 'https://w1790276.users.ecs.westminster.ac.uk/CWK2/index.php/api/Authentication/register',
                    type: 'POST',
                    data: this.model.toJSON(),
                    
                }).done(function(response) {
                    console.log(response);
                    if(response){
                        alert('User Registered Successfully');
                        window.location.href = 'https://w1790276.users.ecs.westminster.ac.uk/CWK2/index.php/Profile';
                    }
                    else{
                        alert('User Registration Failed');
                    }
                });
            }
        }
    });
    var signupView = new SignupView();
</script>