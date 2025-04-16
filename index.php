<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
  
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <?php
    include('link.php');
    ?>


</head>


<body>

    <?php
    include('nav.php');
    ?>





<section class="home_hero">
        <img src="images/home_banner.jpeg" alt="Couple under ancient temple" class="home_hero-image">
    </section>


    <div class="container home_section">
    <section class="home_content">
        <h2 class="home_title">Timeless Photography for Every Story</h2>
        <p class="home_description">Every moment tells a story—your story. Whether it's a heartfelt portrait, a joyous celebration, or an intimate connection.</p>
        <button class="home_button">Contact Us</button>
    </section>
    </div>


    <section class="home_gallery">
        <div class="home_gallery-item"><img src="images/phry1.png" alt="Wedding moment"></div>
        <div class="home_gallery-item"><img src="images/photo2.jpeg" alt="Vintage car couple"></div>
        <div class="home_gallery-item"><img src="images/phry4.png" alt="Traditional wedding"></div>
        <div class="home_gallery-item"><img src="images/photo4.jpeg" alt="Engagement celebration"></div>
        <div class="home_gallery-item"><img src="images/phry6.png" alt="Festive wedding"></div>
    </section>






    <section class="home_memory">
        <h2>Converting moments to memories</h2>
        <button class="gallery-btn">View gallery</button>
        <div class="memory-grid">
            <img src="images/photo1.jpeg" alt="Couple running on the beach">
            <img src="images/photo2.jpeg" alt="Couple near a vintage car">
            <img src="images/photo3.jpeg" alt="Wedding ceremony">
            <img src="images/photo4.jpeg" alt="Bride portrait">
            <img src="images/photo5.jpeg" alt="Wedding rituals">
            <img src="images/phry1.png" alt="Temple wedding shoot">
            <img src="images/phry2.png" alt="Bride traditional attire">
        </div>
    </section>




    <?php
    include('footer.php');
    ?>


</body>

</html>