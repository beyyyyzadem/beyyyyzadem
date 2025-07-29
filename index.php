<?php
// includes/navbar.php
session_start();
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$wishlistCount = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
$userLoggedIn = isset($_SESSION['user']);
?>
<style>
  :root {
    --primary: #FF3E55; /* Premium kırmızı */
    --primary-dark: #E0354A;
    --secondary: #2C3E50;
    --accent: #FF9500;
    --light: #F8F9FA;
    --lighter: #FFFFFF;
    --dark: #1A1A1A;
    --gray: #6C757D;
    --light-gray: #E9ECEF;
    --success: #28A745;
    --danger: #DC3545;
    --warning: #FFC107;
    --info: #17A2B8;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
    --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
    --transition: all 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
    --radius: 8px;
    --radius-sm: 4px;
    --font-primary: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
    --font-secondary: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Base Reset */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  /* Font Import */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap');

  /* Notification Bar */
  .notification-bar {
    background: linear-gradient(90deg, var(--primary), var(--accent));
    color: white;
    padding: 10px 0;
    font-size: 14px;
    font-family: var(--font-secondary);
    position: relative;
    z-index: 1100;
  }

  .notification-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .notification-message {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .notification-message .icon {
    font-size: 16px;
    animation: pulse 2s infinite;
  }

  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
  }

  .notification-close {
    background: none;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    opacity: 0.8;
    transition: var(--transition);
  }

  .notification-close:hover {
    opacity: 1;
    transform: rotate(90deg);
  }

  /* Main Navbar */
  .main-navbar {
    background: var(--lighter);
    box-shadow: var(--shadow-sm);
    position: sticky;
    top: 0;
    z-index: 1050;
    transition: var(--transition);
  }

  .main-navbar.scrolled {
    box-shadow: var(--shadow-md);
  }

  .navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
    padding: 12px 20px;
    position: relative;
  }

  /* Logo Section */
  .logo-section {
    display: flex;
    align-items: center;
    gap: 30px;
  }

  .brand-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: var(--transition);
  }

  .brand-logo:hover {
    transform: translateY(-2px);
  }

  .brand-logo img {
    height: 36px;
    margin-right: 10px;
  }

  .brand-name {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 24px;
    color: var(--primary);
    letter-spacing: -0.5px;
  }

  .brand-tagline {
    font-family: var(--font-secondary);
    font-size: 12px;
    color: var(--gray);
    margin-top: -4px;
    letter-spacing: 0.5px;
  }

  /* Delivery Info */
  .delivery-info {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 16px;
    background: var(--light);
    border-radius: var(--radius);
    cursor: pointer;
    transition: var(--transition);
  }

  .delivery-info:hover {
    background: var(--light-gray);
  }

  .delivery-icon {
    color: var(--primary);
    font-size: 16px;
  }

  .delivery-text {
    font-family: var(--font-secondary);
    font-size: 13px;
    font-weight: 500;
    color: var(--dark);
  }

  .delivery-arrow {
    color: var(--gray);
    font-size: 12px;
  }

  /* Search Bar */
  .search-container {
    flex: 1;
    max-width: 600px;
    margin: 0 30px;
    position: relative;
  }

  .search-form {
    display: flex;
    width: 100%;
    position: relative;
  }

  .search-input {
    width: 100%;
    padding: 12px 20px;
    padding-right: 50px;
    border: 1px solid var(--light-gray);
    border-radius: var(--radius);
    font-family: var(--font-secondary);
    font-size: 14px;
    color: var(--dark);
    background: var(--light);
    transition: var(--transition);
  }

  .search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(255, 62, 85, 0.2);
    background: var(--lighter);
  }

  .search-button {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    width: 50px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    border-radius: 0 var(--radius) var(--radius) 0;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .search-button:hover {
    background: linear-gradient(90deg, var(--primary-dark), var(--primary));
  }

  .search-button i {
    font-size: 16px;
  }

  /* Search Suggestions */
  .search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: var(--lighter);
    border-radius: 0 0 var(--radius) var(--radius);
    box-shadow: var(--shadow-lg);
    padding: 10px 0;
    display: none;
    z-index: 1000;
  }

  .search-container:focus-within .search-suggestions {
    display: block;
    animation: fadeIn 0.3s ease-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .suggestion-item {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    color: var(--dark);
    text-decoration: none;
    transition: var(--transition);
  }

  .suggestion-item:hover {
    background: var(--light);
    color: var(--primary);
  }

  .suggestion-icon {
    margin-right: 12px;
    color: var(--gray);
    font-size: 14px;
    width: 20px;
    text-align: center;
  }

  .suggestion-text {
    font-family: var(--font-secondary);
    font-size: 14px;
  }

  .suggestion-text strong {
    font-weight: 600;
    color: var(--primary);
  }

  /* User Actions */
  .user-actions {
    display: flex;
    gap: 20px;
  }

  .action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    position: relative;
    padding: 5px 8px;
    transition: var(--transition);
  }

  .action-item:hover {
    transform: translateY(-2px);
  }

  .action-icon {
    font-size: 22px;
    color: var(--dark);
    margin-bottom: 2px;
    transition: var(--transition);
  }

  .action-item:hover .action-icon {
    color: var(--primary);
  }

  .action-label {
    font-family: var(--font-secondary);
    font-size: 12px;
    font-weight: 500;
    color: var(--gray);
    transition: var(--transition);
  }

  .action-item:hover .action-label {
    color: var(--dark);
  }

  .action-badge {
    position: absolute;
    top: -2px;
    right: 0;
    background: var(--danger);
    color: white;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 10px;
    min-width: 18px;
    text-align: center;
    line-height: 1;
  }

  /* User Dropdown */
  .user-dropdown {
    position: relative;
  }

  .user-profile {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 5px 8px;
    border-radius: var(--radius-sm);
    transition: var(--transition);
  }

  .user-profile:hover {
    background: var(--light);
  }

  .user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--light-gray);
    transition: var(--transition);
  }

  .user-profile:hover .user-avatar {
    border-color: var(--primary);
  }

  .user-name {
    font-family: var(--font-secondary);
    font-size: 13px;
    font-weight: 500;
    color: var(--dark);
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .user-dropdown-arrow {
    color: var(--gray);
    font-size: 12px;
    transition: var(--transition);
  }

  .user-profile:hover .user-dropdown-arrow {
    color: var(--primary);
    transform: translateY(2px);
  }

  /* Dropdown Menu */
  .dropdown-menu {
    position: absolute;
    right: 0;
    top: 100%;
    background: var(--lighter);
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    padding: 15px 0;
    min-width: 240px;
    z-index: 1000;
    display: none;
    animation: fadeIn 0.2s ease-out;
  }

  .user-dropdown:hover .dropdown-menu {
    display: block;
  }

  .dropdown-header {
    padding: 0 20px 10px;
    border-bottom: 1px solid var(--light-gray);
    margin-bottom: 10px;
  }

  .dropdown-user {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .dropdown-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--primary);
  }

  .dropdown-user-info {
    flex: 1;
  }

  .dropdown-user-name {
    font-family: var(--font-primary);
    font-weight: 600;
    font-size: 14px;
    color: var(--dark);
    margin-bottom: 2px;
  }

  .dropdown-user-email {
    font-family: var(--font-secondary);
    font-size: 12px;
    color: var(--gray);
  }

  .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 20px;
    color: var(--dark);
    text-decoration: none;
    transition: var(--transition);
  }

  .dropdown-item:hover {
    background: var(--light);
    color: var(--primary);
  }

  .dropdown-item i {
    width: 20px;
    text-align: center;
    font-size: 16px;
  }

  .dropdown-divider {
    height: 1px;
    background: var(--light-gray);
    margin: 10px 0;
  }

  /* Category Bar */
  .category-bar {
    background: var(--lighter);
    border-bottom: 1px solid var(--light-gray);
    position: sticky;
    top: 60px;
    z-index: 1040;
    transition: var(--transition);
  }

  .category-bar.scrolled {
    top: 0;
    box-shadow: var(--shadow-sm);
  }

  .category-container {
    display: flex;
    gap: 20px;
    padding: 12px 20px;
    max-width: 1400px;
    margin: 0 auto;
    overflow-x: auto;
    scrollbar-width: none;
  }

  .category-container::-webkit-scrollbar {
    display: none;
  }

  /* Mega Menu */
  .mega-menu-trigger {
    position: relative;
  }

  .mega-menu-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: var(--primary);
    color: white;
    border-radius: var(--radius);
    font-family: var(--font-primary);
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: var(--transition);
  }

  .mega-menu-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
  }

  .mega-menu-btn i {
    font-size: 16px;
  }

  .mega-menu {
    position: absolute;
    left: 0;
    right: 0;
    top: 100%;
    background: var(--lighter);
    box-shadow: var(--shadow-lg);
    padding: 30px;
    display: none;
    z-index: 1030;
    animation: fadeIn 0.3s ease-out;
  }

  .mega-menu-trigger:hover .mega-menu {
    display: block;
  }

  .mega-menu-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 30px;
    max-width: 1400px;
    margin: 0 auto;
  }

  .mega-menu-column {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .mega-menu-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font-primary);
    font-weight: 600;
    font-size: 16px;
    color: var(--primary);
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--light-gray);
  }

  .mega-menu-title i {
    font-size: 18px;
  }

  .mega-menu-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
    color: var(--dark);
    text-decoration: none;
    font-family: var(--font-secondary);
    font-size: 14px;
    transition: var(--transition);
  }

  .mega-menu-link:hover {
    color: var(--primary);
    padding-left: 5px;
  }

  .mega-menu-link i {
    font-size: 12px;
    color: var(--gray);
  }

  .mega-menu-banner {
    grid-column: span 2;
    background: linear-gradient(135deg, var(--light), var(--light-gray));
    border-radius: var(--radius);
    padding: 25px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .mega-menu-banner::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: var(--primary);
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.15;
  }

  .mega-menu-banner img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
    border-radius: var(--radius-sm);
  }

  .mega-menu-banner-title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 18px;
    color: var(--dark);
    margin-bottom: 8px;
  }

  .mega-menu-banner-text {
    font-family: var(--font-secondary);
    font-size: 14px;
    color: var(--gray);
    margin-bottom: 20px;
    line-height: 1.5;
  }

  .mega-menu-banner-btn {
    align-self: flex-start;
    background: var(--primary);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-family: var(--font-secondary);
    font-weight: 600;
    font-size: 14px;
    transition: var(--transition);
  }

  .mega-menu-banner-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 62, 85, 0.3);
  }

  /* Category Links */
  .category-link {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    color: var(--dark);
    text-decoration: none;
    font-family: var(--font-secondary);
    font-weight: 500;
    font-size: 14px;
    white-space: nowrap;
    transition: var(--transition);
    border-radius: var(--radius-sm);
  }

  .category-link:hover {
    color: var(--primary);
    background: var(--light);
  }

  .category-link i {
    font-size: 16px;
  }

  .category-badge {
    background: var(--danger);
    color: white;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: 4px;
  }

  /* Responsive Adjustments */
  @media (max-width: 1200px) {
    .delivery-info {
      display: none;
    }
    
    .search-container {
      margin: 0 15px;
    }
  }

  @media (max-width: 992px) {
    .mega-menu-grid {
      grid-template-columns: repeat(4, 1fr);
    }
    
    .mega-menu-banner {
      grid-column: span 4;
    }
  }

  @media (max-width: 768px) {
    .navbar-container {
      flex-wrap: wrap;
      padding-bottom: 0;
    }
    
    .search-container {
      order: 3;
      margin: 15px 0 0;
      width: 100%;
    }
    
    .category-bar {
      top: 110px;
    }
    
    .category-bar.scrolled {
      top: 50px;
    }
    
    .mega-menu-grid {
      grid-template-columns: repeat(2, 1fr);
    }
    
    .mega-menu-banner {
      grid-column: span 2;
    }
  }
</style>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Notification Bar -->
<div class="notification-bar">
  <div class="notification-content">
    <div class="notification-message">
      <span class="icon">🎉</span>
      <span>Özel Fırsat! 500 TL ve üzeri alışverişlerde 75 TL indirim. Kupon kodu: <strong>PREMIUM75</strong></span>
    </div>
    <button class="notification-close">
      <i class="fas fa-times"></i>
    </button>
  </div>
</div>

<!-- Main Navbar -->
<nav class="main-navbar" id="mainNavbar">
  <div class="navbar-container">
    <!-- Logo Section -->
    <div class="logo-section">
      <a href="index.php" class="brand-logo">
        <img src="images/logo-premium.png" alt="PremiumShop">
        <div>
          <div class="brand-name">HergunPazar</div>
          <div class="brand-tagline">ELİT ALIŞVERİŞ DENEYİMİ</div>
        </div>
      </a>
      
      <div class="delivery-info">
        <i class="fas fa-map-marker-alt delivery-icon"></i>
        <span class="delivery-text">Teslimat Adresi Belirle</span>
        <i class="fas fa-chevron-down delivery-arrow"></i>
      </div>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
      <form class="search-form" action="search.php" method="GET">
        <input type="text" class="search-input" name="q" placeholder="Premium ürünlerde arama yapın..." autocomplete="off">
        <button type="submit" class="search-button">
          <i class="fas fa-search"></i>
        </button>
        
        <!-- Search Suggestions -->
        <div class="search-suggestions">
          <a href="#" class="suggestion-item">
            <i class="fas fa-search suggestion-icon"></i>
            <span class="suggestion-text">En popüler <strong>iPhone 15 Pro</strong> modelleri</span>
          </a>
          <a href="#" class="suggestion-item">
            <i class="fas fa-search suggestion-icon"></i>
            <span class="suggestion-text"><strong>MacBook</strong> Air M2 2023</span>
          </a>
          <a href="#" class="suggestion-item">
            <i class="fas fa-search suggestion-icon"></i>
            <span class="suggestion-text"><strong>Apple Watch</strong> Series 9</span>
          </a>
          <a href="#" class="suggestion-item">
            <i class="fas fa-tag suggestion-icon"></i>
            <span class="suggestion-text"><strong>Apple</strong> kategorisinde arama yap</span>
          </a>
        </div>
      </form>
    </div>

    <!-- User Actions -->
    <div class="user-actions">
      <?php if($userLoggedIn): ?>
        <!-- User Dropdown -->
        <div class="user-dropdown">
          <div class="user-profile">
            <img src="<?= $_SESSION['user']['avatar'] ?? 'images/default-avatar.jpg' ?>" class="user-avatar" alt="Profil">
            <span class="user-name"><?= $_SESSION['user']['name'] ?></span>
            <i class="fas fa-chevron-down user-dropdown-arrow"></i>
          </div>
          
          <!-- Dropdown Menu -->
          <div class="dropdown-menu">
            <div class="dropdown-header">
              <div class="dropdown-user">
                <img src="<?= $_SESSION['user']['avatar'] ?? 'images/default-avatar.jpg' ?>" class="dropdown-user-avatar" alt="Profil">
                <div class="dropdown-user-info">
                  <div class="dropdown-user-name"><?= $_SESSION['user']['name'] ?></div>
                  <div class="dropdown-user-email"><?= $_SESSION['user']['email'] ?></div>
                </div>
              </div>
            </div>
            
            <a href="profile.php" class="dropdown-item">
              <i class="fas fa-user"></i>
              <span>Profilim</span>
            </a>
            <a href="orders.php" class="dropdown-item">
              <i class="fas fa-box"></i>
              <span>Siparişlerim</span>
            </a>
            <a href="wishlist.php" class="dropdown-item">
              <i class="far fa-heart"></i>
              <span>Favorilerim</span>
              <?php if($wishlistCount > 0): ?>
                <span style="margin-left: auto; font-size: 12px; color: var(--primary);"><?= $wishlistCount ?></span>
              <?php endif; ?>
            </a>
            
            <div class="dropdown-divider"></div>
            
            <a href="coupons.php" class="dropdown-item">
              <i class="fas fa-tag"></i>
              <span>Kuponlarım</span>
              <span style="margin-left: auto; font-size: 12px; color: var(--success);">3 Yeni</span>
            </a>
            <a href="messages.php" class="dropdown-item">
              <i class="fas fa-envelope"></i>
              <span>Mesajlarım</span>
              <span style="margin-left: auto; font-size: 12px; color: var(--danger);">2 Okunmamış</span>
            </a>
            
            <div class="dropdown-divider"></div>
            
            <a href="settings.php" class="dropdown-item">
              <i class="fas fa-cog"></i>
              <span>Hesap Ayarları</span>
            </a>
            <a href="logout.php" class="dropdown-item">
              <i class="fas fa-sign-out-alt"></i>
              <span>Çıkış Yap</span>
            </a>
          </div>
        </div>
      <?php else: ?>
        <!-- Login/Register -->
        <a href="login.php" class="action-item">
          <i class="far fa-user action-icon"></i>
          <span class="action-label">Giriş Yap</span>
        </a>
      <?php endif; ?>
      
      <!-- Wishlist -->
      <a href="wishlist.php" class="action-item">
        <i class="far fa-heart action-icon"></i>
        <span class="action-label">Favoriler</span>
        <?php if($wishlistCount > 0): ?>
          <span class="action-badge"><?= $wishlistCount ?></span>
        <?php endif; ?>
      </a>
      
      <!-- Cart -->
      <a href="cart.php" class="action-item">
        <i class="fas fa-shopping-bag action-icon"></i>
        <span class="action-label">Sepetim</span>
        <?php if($cartCount > 0): ?>
          <span class="action-badge"><?= $cartCount ?></span>
        <?php endif; ?>
      </a>
    </div>
  </div>
</nav>

<!-- Category Bar with Mega Menu -->
<div class="category-bar" id="categoryBar">
  <div class="category-container">
    <!-- Mega Menu Trigger -->
    <div class="mega-menu-trigger">
      <a href="#" class="mega-menu-btn">
        <i class="fas fa-bars"></i>
        <span>Tüm Kategoriler</span>
      </a>
      
      <!-- Mega Menu Content -->
      <div class="mega-menu">
        <div class="mega-menu-grid">
          <!-- Column 1 - Electronics -->
          <div class="mega-menu-column">
            <h4 class="mega-menu-title">
              <i class="fas fa-laptop"></i>
              <span>Elektronik</span>
            </h4>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Akıllı Telefonlar</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Bilgisayarlar</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Televizyonlar</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Kulaklıklar</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Tabletler</span>
            </a>
          </div>
          
          <!-- Column 2 - Fashion -->
          <div class="mega-menu-column">
            <h4 class="mega-menu-title">
              <i class="fas fa-tshirt"></i>
              <span>Moda</span>
            </h4>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Erkek Giyim</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Kadın Giyim</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Ayakkabı</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Çanta</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Saat & Aksesuar</span>
            </a>
          </div>
          
          <!-- Column 3 - Home -->
          <div class="mega-menu-column">
            <h4 class="mega-menu-title">
              <i class="fas fa-home"></i>
              <span>Ev & Yaşam</span>
            </h4>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Mobilya</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Ev Tekstili</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Mutfak</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Banyo</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Aydınlatma</span>
            </a>
          </div>
          
          <!-- Column 4 - Beauty -->
          <div class="mega-menu-column">
            <h4 class="mega-menu-title">
              <i class="fas fa-spa"></i>
              <span>Kozmetik</span>
            </h4>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Parfüm</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Makyaj</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Cilt Bakımı</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Saç Bakımı</span>
            </a>
            <a href="#" class="mega-menu-link">
              <i class="fas fa-chevron-right"></i>
              <span>Erkek Bakım</span>
            </a>
          </div>
          
          <!-- Banner Column -->
          <div class="mega-menu-banner">
            <img src="images/mega-menu-banner.jpg" alt="Özel Fırsat">
            <h3 class="mega-menu-banner-title">Premium Üyelere Özel</h3>
            <p class="mega-menu-banner-text">Premium üyelerimiz için özel indirimler ve avantajlarla dolu yeni sezon fırsatları!</p>
            <a href="#" class="mega-menu-banner-btn">Keşfet</a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Category Links -->
    <a href="category.php?cat=electronics" class="category-link">
      <i class="fas fa-laptop"></i>
      <span>Elektronik</span>
    </a>
    
    <a href="category.php?cat=women-fashion" class="category-link">
      <i class="fas fa-female"></i>
      <span>Kadın</span>
    </a>
    
    <a href="category.php?cat=men-fashion" class="category-link">
      <i class="fas fa-male"></i>
      <span>Erkek</span>
    </a>
    
    <a href="category.php?cat=home-living" class="category-link">
      <i class="fas fa-home"></i>
      <span>Ev & Yaşam</span>
    </a>
    
    <a href="category.php?cat=beauty" class="category-link">
      <i class="fas fa-spa"></i>
      <span>Kozmetik</span>
    </a>
    
    <a href="category.php?cat=sports" class="category-link">
      <i class="fas fa-running"></i>
      <span>Spor & Outdoor</span>
    </a>
    
    <a href="category.php?cat=premium" class="category-link">
      <i class="fas fa-crown"></i>
      <span>Premium Ürünler</span>
      <span class="category-badge">Yeni</span>
    </a>
    
    <a href="campaigns.php" class="category-link">
      <i class="fas fa-percentage"></i>
      <span>Kampanyalar</span>
    </a>
    
    <a href="brands.php" class="category-link">
      <i class="fas fa-star"></i>
      <span>Lüks Markalar</span>
    </a>
  </div>
</div>

<!-- JavaScript -->
<script>
  // Sticky Navbar Behavior
  window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    const categoryBar = document.getElementById('categoryBar');
    const scrollPosition = window.scrollY;
    
    if (scrollPosition > 20) {
      navbar.classList.add('scrolled');
      categoryBar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
      categoryBar.classList.remove('scrolled');
    }
  });

  // Close Notification
  document.querySelector('.notification-close').addEventListener('click', function() {
    document.querySelector('.notification-bar').style.display = 'none';
    document.body.style.paddingTop = '0';
  });

  // Search Focus Management
  const searchInput = document.querySelector('.search-input');
  const searchSuggestions = document.querySelector('.search-suggestions');
  
  searchInput.addEventListener('focus', function() {
    searchSuggestions.style.display = 'block';
  });
  
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-container')) {
      searchSuggestions.style.display = 'none';
    }
  });

  // Mobile Menu Toggle (would be implemented with media queries)
  // This is just a placeholder for actual mobile menu functionality
  function toggleMobileMenu() {
    // Implementation would go here
  }

  // Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });

  // User dropdown stays open when hovering over it
  const userDropdown = document.querySelector('.user-dropdown');
  const dropdownMenu = document.querySelector('.dropdown-menu');
  
  userDropdown.addEventListener('mouseleave', function(e) {
    // Check if mouse is leaving to go to dropdown
    if (!e.relatedTarget || !e.relatedTarget.closest('.dropdown-menu')) {
      dropdownMenu.style.display = 'none';
    }
  });
  
  dropdownMenu.addEventListener('mouseleave', function() {
    this.style.display = 'none';
  });
</script>