<?php
$this->load->view('templates/header.php');
?>

<?php
$this->load->view('templates/nav_landing.php');
?>

<!-- section 1 -->
<section>
    <div class="swiper bannerSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="../assets/images/nature.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="../assets/images/beach.jpg" />
            </div>
            <div class="swiper-slide">
                <img src="../assets/images/puppy.jpg" />
            </div>
            <div class="swiper-slide">
                <img src="../assets/images/bridge.jpg" />
            </div>
        </div>

        <div class="swiper-pagination"></div>
    </div>
</section>
<!--/ section 1 -->


<!-- section 2 -->
<section class="">

    <div class="swiper homeSection2">
        <div class="d-flex justify-content-end pe-5 my-5">
            <img src="../assets/images/arrow-prev.svg" class="swiper-button-prev mx-4 m-0" alt="">
            <img src="../assets/images/arrow-next.svg" class="swiper-button-next mx-4 m-0" alt="">
        </div>
        <div class="swiper-wrapper mb-5">
            <div class="swiper-slide me-5 px-4"><img src="../assets/images/puppy.jpg" alt=""></div>
            <div class="swiper-slide me-5 px-4"><img src="../assets/images/bridge.jpg" alt=""></div>
            <div class="swiper-slide me-5 px-4"><img src="../assets/images/beach.jpg" alt=""></div>
            <div class="swiper-slide me-5 px-4"><img src="../assets/images/nature.jpg" alt=""></div>
            <div class="swiper-slide me-5 px-4"><img src="../assets/images/camera.jpg" alt=""></div>
            <div class="swiper-slide me-5 px-4"><img src="../assets/images/puppy.jpg" alt=""></div>
        </div>

    </div>
</section>
<!--/ section 2 -->

<script>


      //block user from routing to other pages
      document.addEventListener('DOMComtentLoaded', function(event){
        console.log('DOM fully loaded and parsed');
        if(localStorage.getItem('user_id') == null){
            window.location.href = "https://w1790276.users.ecs.westminster.ac.uk/CWK2/index.php/Landing";
        }
    }); 
   
</script>

<?php
$this->load->view('templates/footer.php');
?>