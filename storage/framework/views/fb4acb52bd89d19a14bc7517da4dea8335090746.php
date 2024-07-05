

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('navbar'); ?>
<img class="img-fluid" src="<?php echo e(URL::asset('assets/viewUser/img/raida/Header.png')); ?>" alt="">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="container-xxl height-countdown bg-countdown">
        <div class="container px-lg-5">
            <div class="row g-5">
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;">
                    <div class="peserta justify-content-center p-4" style="height: 150px; width: 100%;">
                        <div class="text-center">
                            <p style="font-weight: bold" class="text-uppercase">Peserta</p>
                            <hr class="new" />
                            <p style="color: black; font-weight: bold"><?php echo e(count($peserta)); ?> Peserta</p>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;">
                    <div class="peserta justify-content-center p-4" style="height: 150px; width: 100%;">
                        <div class="text-center">
                            <p style="font-weight: bold" class="text-uppercase">Countdown</p>
                            <hr class="new" />
                            <p style="color: black;" id="demo" class="mb-0 countdown"></p>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;">
                    <div class="peserta justify-content-center p-4" style="height: 150px; width: 100%;">
                        <div class="text-center">
                            <p style="font-weight: bold" class="text-uppercase">Kontingen</p>
                            <hr class="new" />
                            <p style="color: black; font-weight: bold"><?php echo e(count($kontingen)); ?> Peserta</p>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="container-xxl py-5">
        <img src="assets/viewUser/img/raida/maung 1.1.png" style="float: inline-end" alt="">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <img src="assets/viewUser/img/raida/raimuna daer xiv logo.png" style="width: 50%" alt="">
            </div>
            <div class="row">
                <div class="wow zoomIn" data-wow-delay="0.1s">
                    <p style="margin-left: 100px; color:black; font-weight: bold">Raimuna adalah pertemuan Pramuka Penegak
                        dan Pandega, berasal dari bahasa Ambai di Papua yang berarti "sekumpulan orang dengan tujuan
                        tertentu" dan "kekuatan bernilai baik untuk kesuskesan." <br> Raimuna dirancang untuk pengembangan
                        diri, peningkatan kualitas, dan kemajuan generasi muda.</p>
                    <p style="margin-left: 100px; color:black; font-weight: bold">Raimuna Daerah Jawa Barat XIV Tahun 2024
                        akan berlangsung di Bumi Perkemahan Pramuk Letjen TNI (Purn) Dr. (HC) Mashudi, Kiarapayung,
                        Sumedang, dari 16 hingga 21 September 2024.</p>
                </div>
            </div>
            <div class="row" style="margin-left: 100px">
                <div class="wow zoomIn" data-wow-delay="0.2s">
                    <img src="assets/viewUser/img/raida/Ordinary Activity.png" style="width: 20%; margin-left: 20px;" />
                    <img src="assets/viewUser/img/raida/Extra Ordinary Activity.png"
                        style="width: 20%; margin-left: 20px;" />
                    <img src="assets/viewUser/img/raida/Multicultural Learning Center.png"
                        style="width: 20%; margin-left: 20px;" />
                    <img src="assets/viewUser/img/raida/Youth Empowerment Center.png"
                        style="width: 20%; margin-left: 20px;" />
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="container-xxl py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 px-lg-5" style="border-radius: 30px">
            <h2 style="text-align: center" class="p-5">ARTIKEL RAIDA</h2>
            <div class="owl-carousel owl-theme testimonial-carousel">
                <?php $__currentLoopData = $artikel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="testimonial-item bg-transparent border rounded text-white p-4">
                        <div class="container-img">
                            <img src="<?php echo e(Storage::url('img/artikel/' . $data->foto)); ?>"
                                style="height: 250px; width: 100%;" />
                            <div class="bottom-centerd mt-5">
                                <p class="text-capitalize " style="color: black"><?php echo e($data->judul); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    


    
    <div class="container-xxl py-5">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <img src="assets/viewUser/img/raida/berdampak serentak.png" style="width: 100%" />
            </div>
            <div class="text-center">
                <a href="" class="btn btn-lg text-white"
                    style="border-radius: 50px; background-color: #E38725">Pendaftaran Kontingen</a>
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("Sep 16, 2024 00:00:00").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
    <style>
        .countdown {
            text-align: center;
            font-size: 30px;
            margin-top: 0px;
            color: yellow;
            font-weight: bold;
        }

        hr.new {
            border: 3px solid #fff;
            border-radius: 5px;
        }

        .container-img {
            position: relative;
            text-align: center;
            color: white;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('viewUser.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\raida-jabar-2024\resources\views/viewUser/index.blade.php ENDPATH**/ ?>