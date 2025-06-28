<header>
    <a href="index.php" class="logo"><span class="green">E</span>co<span class="green">R</span>ide</a>
    <div class="menu">
        <nav>
            <ul>
                <li><a href="rides.php">Covoiturage</a></li>
                <?php if (!isset($_SESSION['role'])): ?>
                    <li><a href="register.php">Créer un compte</a></li>
                    <li><a href="login.php">Se connecter</a></li>
                <?php else: ?>
                    <li><a href="logout.php">Se déconnecter</a></li>
                <?php endif; ?>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>
    <!-- Icône du menu burger pour le mobile -->
    <span class="material-symbols-outlined menu-burger" id="toggler">menu</span>
</header>
