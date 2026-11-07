<?php $title = 'Home'; require 'includes/header.php'; ?>
  <section class="hero">
    <div class="hero-left">
      <h1>BLOOD<br>DONATION</h1>
      <p class="script">Saves Lives</p>
    </div>
    <img class="hero-img" src="assets/img/hero.png" alt="Raised hand in front of the globe">
    <div class="hero-right">
      <h2>Together,<br>we're Stronger</h2>
      <p>Register as a donor, find a matching blood group in your city, or post a request when someone needs blood.</p>
      <a class="btn-red" href="<?= empty($_SESSION['user_id']) ? 'signup.php' : 'donor.php' ?>">Donate</a>
    </div>
    <div class="socials"><a href="#">f</a><a href="#">ig</a><a href="#">yt</a></div>
    <div class="mascot">
      <p class="script small">stay informed,<br>follow us.</p>
      <img src="assets/img/drop.png" alt="Smiling blood drop">
    </div>
  </section>
<?php require 'includes/footer.php'; ?>
