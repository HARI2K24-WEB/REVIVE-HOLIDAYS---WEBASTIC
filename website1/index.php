<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Travel Site</title>
  <link rel="stylesheet" href="style.css">
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!--Bootstrap icon-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>

  <!-- Header -->
   <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="assets/revivelogo.jpg" alt="Revive Holidays Logo">
        <span>Revive Holidays</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#aboutus">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="#packages">Packages</a></li>
          <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Packages Section -->
  <section id="packages">
    <h2>Packages</h2>
    <div class="package-slider">
      <?php
      $result = $conn->query("SELECT * FROM packages ORDER BY created_at DESC");
      while($row = $result->fetch_assoc()) {
      ?>
        <div class="package-card">
          <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Package">
          <h3><?php echo htmlspecialchars($row['place_name']); ?> - <?php echo htmlspecialchars($row['package_name']); ?></h3>
          <p><b>Day 1:</b> <?php echo nl2br(htmlspecialchars($row['day1'])); ?></p>
          <p><b>Day 2:</b> <?php echo nl2br(htmlspecialchars($row['day2'])); ?></p>
          <p><b>Day 3:</b> <?php echo nl2br(htmlspecialchars($row['day3'])); ?></p>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Gallery Section -->
  <section id="gallery">
    <h2>Gallery</h2>
    <div class="gallery-grid">
      <?php
      $images = glob("uploads/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
      foreach ($images as $img) {
          echo "<img src='$img' alt='Gallery Image'>";
      }
      ?>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact">
    <h2>Contact Us</h2>
    <form action="contact.php" method="POST">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </section>




  
 <!-- Footer -->
<footer class="bg-dark text-light pt-5 pb-4">
  <div class="container text-center text-md-start">
    <div class="row text-center text-md-start">

      <!-- Company Info -->
      <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Revive Holidayss</h5>
        <p>
          Experience unforgettable adventures with our curated travel packages.
          From tropical paradises to mountain peaks, we make your dream destinations reality.
        </p>
      </div>

      <!-- Links -->
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
        <h5 class="text-uppercase mb-3 font-weight-bold text-warning">Quick Links</h5>
        <p><a href="#home" class="text-light text-decoration-none">Home</a></p>
        <p><a href="#about" class="text-light text-decoration-none">About</a></p>
        <p><a href="#packages" class="text-light text-decoration-none">Packages</a></p>
        <p><a href="#gallary" class="text-light text-decoration-none">Gallary</a></p>
        <p><a href="#contact" class="text-light text-decoration-none">Contact</a></p>
      </div>

      <!-- Contact -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contact</h5>
        <p><i class="fas fa-home me-2"></i> Coimbatore ,Tamil nadu</p>
        <p><i class="fas fa-envelope me-2"></i> reviveholidayss.in@gmail.com</p>
        <p><i class="fas fa-phone me-2"></i> +91 93644 37888</p>
      </div>

      <!-- Social Media -->
      <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Follow us</h5>
        <a href="https://www.instagram.com/revive_holidayss/"
                            class="instagram" target="_blank">
                            <i class="bi bi-instagram" style="color: rgb(202, 25, 149);"></i>
                        </a>
      </div>
    </div>

    <hr class="mb-2">
    <!-- Copyright -->
    <div class="row align-items-center">
      <div class="col-md-7 col-lg-8">
        <p class="text-center text-md-start">© 2025 ReviveHolidayss — All Rights Reserved</p>
      </div>
      <div class="col-md-5 col-lg-4">
        <p class="text-center text-md-end">
          Designed by <span><a  class="text-warning fw-bold" href="https://webastic.in/" style="text-decoration: none;">WebAstic</a></span>
        </p>
      </div>
    </div>
  </div>
</footer>
</body>

<script src="script.js"></script>
</html>
