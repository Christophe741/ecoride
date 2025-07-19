<header class="header">
  <a href="index.php" class="header__logo">
    <span class="header__logo--green">E</span>co<span class="header__logo--green">R</span>ide
  </a>
  <div class="header__menu">
    <nav>
      <ul class="header__list">
        <li><a href="<?= $basePath ?>search.php" class="header__link">Covoiturage</a></li>
        
        <?php if (!isset($_SESSION['role'])): ?>
          <li><a href="<?= $basePath ?>register.php" class="header__link">Créer un compte</a></li>
          <li><a href="<?= $basePath ?>login.php" class="header__link">Se connecter</a></li>
        <?php else: ?>
          <li><a href="<?= $basePath ?>logout.php" class="header__link">Se déconnecter</a></li>
        <?php endif; ?>
        
        <li><a href="<?= $basePath ?>contact.php" class="header__link">Contact</a></li>
      </ul>
    </nav>
  </div>

  <div class="material-symbols-outlined header__burger" id="toggler">menu</div>
</header>
