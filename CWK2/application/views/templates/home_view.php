<?php
$this->load->view('templates/header.php');
?>

<?php
$this->load->view('templates/nav.php');
?>


<section class= "mt-5 pt-5">
    <div class="row m-0 mt-5">
        <div class="col-3 align-items-center d-flex flex-column">
            <div class="position-fixed align-items-center d-flex flex-column">
                <img src="../assets/images/user_profile.png " class="user_profile" alt="">
                <h3 id="uname"></h3>
                <p id = "desc"></p>
                <a href="https://w1790276.users.ecs.westminster.ac.uk/CWK2/index.php/Profile"><button>View Profile</button></a>
            </div>
            

        </div>
        <div class="col-9" id="home_card">

        </div>
    </div>
</section>


<script>

     //block user from routing to other pages
     document.addEventListener('DOMComtentLoaded', function(event){
        console.log('DOM fully loaded and parsed');
        if(localStorage.getItem('user_id') == null){
            window.location.href = "https://w1790276.users.ecs.westminster.ac.uk/CWK2/index.php/Landing";
        }
    }); 
   

    var username = localStorage.getItem('user_name');
    var user_id = localStorage.getItem('user_id');
    var desc = localStorage.getItem('user_desc');
    // replace text using jquerry
    
    $(document).ready(function(){
        $('#uname').text(username);
        $('#desc').text(desc);
    });


    // get posts from database and display append

    $(document).ready(function(){
        $.ajax({
            url: "<?php echo base_url(); ?>api/Post/",
            type: "GET", 
            dataType: "json"
        }).done(function(response){
            
            // console.log(response);

            // $.each(data, function(key, value){
            for (var i = 0; i < response.length; i++) {
                var post = response[i];
                var image = response[i]['image'];
                var username = response[i]['userName'];
                var date = response[i]['createdTime'];
                var comments = response[i]['comments'];
                var caption = response[i]['caption'];
                var tag = response[i]['tag'];

                var tags = tag.join(" ");
                console.log("+++++++",tag);
                console.log(post['postID']);

                $('#home_card').append(`
                    <div class="col-10  mx-auto p-4 home_card mb-4" >
                        <div class="">
                            <p class= "fs-4 fw-bolder m-0">${username}</p>
                            <p class = "fst-italic">${date}</p>
                        </div>
                        <div class="">
                            <img class="" src="https://w1790276.users.ecs.westminster.ac.uk/CWK2/postImages/${image}" alt="" style = " object-fit: cover; height: 350px; width: 100%;">
                            <div class="mt-2">
                                <i class="fa fa-heart fs-3 pe-4" style="color:red" aria-hidden="true"></i>
                                <i class="fa fa-share fs-3 pe-4" aria-hidden="true"></i>
                            </div>
                            <p class = "m-0">${caption}</p>
                            <p>${tags}</p>
                            <div class="card_scroll shadow p-3 rounded">
                                <div id="cmts">
                                    ${
                                        comments.map((comment) => {
                                            return `<p class = "m-0">
                                                    <span style="font-weight: bold">${comment.userName}</span> 
                                                    ${comment.commentDescription}
                                                </p>`
                                        }).join('')
                                    }
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <input type="text" class="form-control comment_input" placeholder="Add a comment..." id="comment_input_${post['postID']}">
                                <button class="btn btn-outline-secondary" id="comment_button" data-postID="${post['postID']}">Comment</button>
                            </div>
                        </div>
                    </div>             
                `);
            }
        });
    });

        $(document).on('click', '#comment_button', function(e){
            e.preventDefault();
            e.stopPropagation();
            var post_id = $(this).attr('data-postID');
            console.log(post_id);

            var comment = $('#comment_input_'+post_id).val();
            console.log(comment);
            console.log("POST ID", post_id);
            

            $.ajax({
                url: "https://w1790276.users.ecs.westminster.ac.uk/CWK2/index.php/api/Comment/",
                type: "POST", 
                // dataType: "json",
                data: {
                    postID: post_id,
                    userID: user_id,
                    commentDescription: comment
                }
            }).done(function(response){
                console.log(response);
                window.location.reload();
               


                alert("Successfully commented");
            });
        });
    

    



</script>

<?php
$this->load->view('templates/footer.php');
?>