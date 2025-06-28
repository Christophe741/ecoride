<header class="site-header">
  <a href="index.php" class="site-header__logo">
    <span class="site-header__logo--green">E</span>co<span class="site-header__logo--green">R</span>ide
  </a>
  <div class="site-header__menu">
    <nav class="site-header__nav">
      <ul class="site-header__list">
        <li class="site-header__item"><a href="rides.php" class="site-header__link">Covoiturage</a></li>
        
        <?php if (!isset($_SESSION['role'])): ?>
          <li class="site-header__item"><a href="register.php" class="site-header__link">Créer un compte</a></li>
          <li class="site-header__item"><a href="login.php" class="site-header__link">Se connecter</a></li>
        <?php else: ?>
          <li class="site-header__item"><a href="logout.php" class="site-header__link">Se déconnecter</a></li>
        <?php endif; ?>
        
        <li class="site-header__item"><a href="contact.php" class="site-header__link">Contact</a></li>
      </ul>
    </nav>
  </div>

  <div class="material-symbols-outlined menu-burger" id="toggler">menu</div>
</header>
