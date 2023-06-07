<?php
$this->load->view('templates/header.php');
?>

<?php
$this->load->view('templates/nav.php');
?>


<!-- section 1 -->
<section class="mt-5 pt-5">
    <div class="col-4 mx-auto my-5">
        <div class="input-group rounded">
            <input type="search" id="searchText" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <span class="bg-transparent input-group-text border-0" id="searchBtn">
                <i class="fas fa-search"></i>
            </span>
        </div>
    </div>
</section>
<!--/ section 1 -->

<!-- section 2 -->
<section>
    <div class="row m-0" id="post_display">
        
        
    </div>
</section>
<!--/ section 2 -->

<section>
    <!-- modal popup view -->
    <div class="modal fade bd-example-modal-lg " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content px-4">
                <div class="modal-header">
                    <div class="">
                        <h5 class="modal-title" id="uname1"></h5>
                        <p id="date"></p>
                    </div>
                    
                    
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <img class="w-100 popup-img" src="../assets/images/signup-bbg.jpg" alt="">
                    <div class="mt-2">
                        <i class="fa fa-heart fs-3 pe-4" style="color:red " aria-hidden="true"></i>
                        <i class="fa fa-share fs-3 pe-4" aria-hidden="true"></i>
                    </div>

                    <div class="d-flex"><p id ="uname2"></p> - <p id="capt"></p></div>
                    <p id="comm"></p>
                    <p id="tag"></p>
                    <div id="commentsSection"></div>

                </div>
             
            </div>
        </div>
    </div>

</section>



<script>

    //block user from routing to other pages
    document.addEventListener('DOMComtentLoaded', function(event){
        console.log('DOM fully loaded and parsed');
        if(localStorage.getItem('user_id') == null){
            window.location.href = "Landing";
        }
    }); 

    var userID = localStorage.getItem('user_id');
    var username = localStorage.getItem('user_name');
    var desc = localStorage.getItem('user_desc');
    var profpic = localStorage.getItem('user_profpic') !== null ? localStorage.getItem('user_profpic') : 'user_profile.png';

// replace text using jquerry
    // $(document).ready(function(){
    //     $('#uname').text(username);
    //     $('#desc').text(desc);
    //     $('.user_profile').attr('src', 'http://localhost/CWK2/profileImages/'+profpic);
    // });

    // popup modal view
    $(document).on('click', '.explore-img', function(e){
        e.preventDefault();
        e.stopPropagation();
        var image = $(this).attr('src');
        var postID = $(this).attr('data-postid');
        var postTime = $(this).attr('data-postTime');
        var userName = $(this).attr('data-username');
        var userID = $(this).attr('data-userid');
        var postCaption = $(this).attr('data-caption');
        var postTag = $(this).attr('data-tag');

        $('#commentsSection').empty();
        $('#uname1').text(userName);
        $('#uname2').text(userName);
        $('#date').text(postTime);
        $('#capt').text(postCaption);
        $('#tag').text(postTag);
        
        $.ajax({
            url: 'api/Comment/' + postID,
            type: 'GET'
        }).done(function(response) {
            if(response){
                for(var i=0; i<response.length; i++){
                    $('#commentsSection').append(`
                        <div class="d-flex align-items-start my-3">
                                <div class="ms-3 w-100" >
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6> ${response[i].userName} </h6>
                                        <h6> ${response[i].createdTime} </h6>
                                    </div>
                                    <p>${response[i].commentDescription}</p>
                                </div>
                            </div>
                        `);
                }
            }else{
                console.log("no comments -- ",response);
            }
        }).fail(function(response) {
            console.log("no  -- ",response); 
        });

        console.log(postID);

        // deletePost(postID);
        $('.popup-img').attr('src', image);
        $('#exampleModal').modal('show');
        
    });

    // $(document).on('click', '#editP', function(){
    //     $('#editProfModal').modal('show');
    //     $('#usernm').val(username);
    //     $('#bio').val(desc);
    // });

    // $(document).on('click', '#saveEditProf', function(){
    //     console.log("uid", userID);
    //     var newUsername = $('#usernm').val();
    //     var newDesc = $('#bio').val();
    //     var formData = new FormData();
    //     formData.append('profilePic', $('#profpic')[0].files[0]);
    //     formData.append('userName', newUsername);
    //     formData.append('userDesc', newDesc);

    //     $.ajax({
    //         url: '<?php echo base_url(); ?>api/Authentication/editprof/' + userID,
    //         type: 'POST',
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //     }).done(function(response) {
    //         console.log("success -- ",response);
    //         localStorage.setItem('user_name', response.data.userName);
    //         localStorage.setItem('user_desc', response.data.userDescription);
    //         localStorage.setItem('user_profpic', response.data.profilePic);
    //         location.reload();
    //     }).fail(function(response) {
    //         console.log("no  -- ",response); 
    //     });
    // });


    $(document).on('click', '#searchBtn', function(e){
        e.preventDefault();
        e.stopPropagation();
        
        var search = $('#searchText').val();
        console.log("************",search);
        $.ajax({
            url: "<?php echo base_url(); ?>api/Search/" + search,
            type: "GET", 
            dataType: "json"
        }).done(function(response){
            // var count = response.length;
            
            $('#post_display').empty();

            for (var i = 0; i < response.length; i++) {
                var post = response[i];
                var image = response[i]['image'];
                var postID = post['postID'];
                var postTime = post['createdTime'];
                var userName = post['userName'];
                var userID = post['userID'];
                var postCaption = post['caption'];
                var tags = post['hashtags'];

                if(tags == null){
                    tags = [];
                }else{
                    // tags = tags.split(",");
                    tag = tags.join(" ");
                }
                // console.log("==--==--==", post);

                $('#post_display').append(`
                <div class="col-4 d-flex justify-content-center">
                    <img  src= "https://localhost/CWK2/postImages/${image}" data-postid="${postID}" class="mb-4 explore-img" style = "height : 300px ; width : 350px ;"
                    data-caption="${postCaption}" data-postTime="${postTime}" data-userName="${userName}" data-tag="${tag}">
                </div>
                `);
                // $('#post_count').text(count);
            }
        });
    });


    $(document).ready(function(){
        $.ajax({
            url: "<?php echo base_url(); ?>api/Post/" + userID,
            type: "GET", 
            dataType: "json"
        }).done(function(response){
            var count = response.length;
            
            for (var i = 0; i < response.length; i++) {
                var post = response[i];
                var image = response[i]['image'];
                var postID = post['postID'];
                var postTime = post['createdTime'];
                var userName = post['userName'];
                var userID = post['userID'];
                var postCaption = post['caption'];
                var tags = post['hashtags'];

                var tag = tags.join(" ");
                // console.log("==--==--==", post);

                $('#post_display').append(`
                <div class="col-4 d-flex justify-content-center">
                    <img  src= "https://localhost/CWK2/postImages/${image}" data-postid="${postID}" class="mb-4 explore-img" style = "height : 300px ; width : 350px ;"
                    data-caption="${postCaption}" data-postTime="${postTime}" data-userName="${userName}" data-tag="${tag}">
                </div>
                `);
                $('#post_count').text(count);
            }
        });
    });

</script>


<?php
$this->load->view('templates/footer.php');
?>