<?php
$this->load->view('templates/header.php');
?>

<div class="row m-0 overflow-hidden vh-100" id="login">
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
                    <h4>Log <span style="color: var(--dark-brown)">In</span></h4>
                    <input class="form_input my-3 p-3" type="text" id="username" placeholder="Name"><br>

                    <div id="show_hide_password" class="my-3 align-items-center d-flex" style="background-color: var(--bg-dark-cream);">
                        <input class="form_input p-3" type="password" id="password" placeholder="Password">
                        <div class="input-group-addon pe-3" >
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <input class="submit_button p-2 " type="button" value="Log In">
                    </div>


                </form>
            </div>

            <P>Don't have an account? <a href="SignUp" style="color: var(--dark-brown);text-decoration: none;">Sign Up</a></P>

        </div>
    </div>
</div>

<script>

   //block user from routing to other pages
   document.addEventListener('DOMComtentLoaded', function(event){
        console.log('DOM fully loaded and parsed');
        if(localStorage.getItem('user_id') == null){
            window.location.href = "<?php echo base_url() ?>Landing";
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
    

    var LoginModel = Backbone.Model.extend({
        defaults: {
            username: '',
            email: '',
            password: '',
            
        }
    });
    
    var LoginView = Backbone.View.extend({
        el: '#login',
        events: {
            'click .submit_button': 'login'
        },
        initialize: function() {
            this.model = new LoginModel();
            this.listenTo(this.model, 'change', this.render);
        },
        render: function() {
            this.$el.find('#username').val(this.model.get('username'));
            // this.$el.find('#email').val(this.model.get('email'));
            this.$el.find('#password').val(this.model.get('password'));
        },
        login: function() {
            this.model.set({
                username: this.$el.find('#username').val(),
                password: this.$el.find('#password').val(),
                
            });
           
            if(this.model.get('password') == "" ){
                alert('Please enter password');
            }
            
            else{
                $.ajax({
                    url: '<?php echo base_url() ?>api/Authentication/login',
                    type: 'POST',
                    data: this.model.toJSON(),
                    
                }).done(function(response) {
                    console.log(response);
                    if(response){

                        console.log(response);

                        localStorage.setItem('token', response.token);
                        localStorage.setItem('user_id', response.id);
                        localStorage.setItem('user_name', response.username);
                        localStorage.setItem('user_desc', response.userDescription);
                        localStorage.setItem('user_profpic', response.profilePic);

                        alert('User Logged In Successfully');
                        window.location.href = '<?php echo base_url() ?>Profile';
                    }
                    else{
                        alert('User failed to login');
                    }
                }).fail(function(response) {
                    console.log(response);
                    alert('User failed to login');
                })
            }
        }
    });
    var loginView = new LoginView();
</script>