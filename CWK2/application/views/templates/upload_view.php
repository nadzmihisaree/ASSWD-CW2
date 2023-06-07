<?php
$this->load->view('templates/header.php');
?>

<?php
$this->load->view('templates/nav.php');
?>


<section class="mt-5 pt-5">
    <form class= "col-5 mt-5 mx-auto ">
       
        <div class="form-group mb-5">
            <label for="exampleFormControlFile1" class="mb-4 fs-4">Choose image to upload...</label><br>
            <input type="file" class="form-control-file" id="image">
        </div>
        
        <div class="form-group mb-5">
            <label for="exampleFormControlTextarea1" class="fs-4">Caption</label>
            <textarea class="form-control" id="caption" rows="3"></textarea>
        </div>

        <div class="form-group mb-5">
            <label for="exampleFormControlTextarea1" class="fs-4">Hashtags</label>
            <textarea class="form-control" id="hashtags" rows="3"></textarea>
        </div>

        <button type="button" class="btn btn-primary" id="upload">Upload</button>

    </form>
</section>

<script>

   //block user from routing to other pages
   document.addEventListener('DOMComtentLoaded', function(event){
        console.log('DOM fully loaded and parsed');
        if(localStorage.getItem('user_id') == null){
            window.location.href = "<?php echo base_url();?>Landing";
        }
    }); 
   
    
    $(document).on('click', '#upload', function(e) {
            // e.preventDefault();
            // e.stopPropagation();
            var caption = $('#caption').val();
            var image = $('#image').val();
            var hashtags = $('#hashtags').val();
            var user_id = localStorage.getItem('user_id');

            console.log("caption",caption);
            
            var formData = new FormData();
            formData.append('caption', caption);
            formData.append('image', $('#image')[0].files[0]);
            formData.append('hashtags', hashtags);
            formData.append('userID', user_id);
            
            console.log("formData",formData);

            $.ajax({
                url: '<?php echo base_url() ?>api/Post/',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                async: false,
            }).done(function(data) {
                
                    console.log(data);
                    console.log("succesful");
                    alert("Post not added: ");

                    window.location.reload();
                
            }).fail(function(data) {
                console.log(data);
                console.log("fail");
                alert("Post added successfully" );
            })
        });

    
</script>



<?php
$this->load->view('templates/footer.php');
?>