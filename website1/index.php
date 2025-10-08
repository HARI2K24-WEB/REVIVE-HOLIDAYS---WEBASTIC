<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Travel Site</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="navbar">
      <div class="logo">
        <ul>
          <li><img src="assets/revivelogo.jpg" alt=""></li>
          <a href="index.php">Revive Holidays</a>
        </ul>
      </div>
      <nav>
        <ul>
          <li><a href="#packages">Packages</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

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

</body>

<script src="script.js"></script>
</html>
