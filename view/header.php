<header>
        <nav>
            <h2>TRANG QUẢN LÝ TÀI KHOẢN</h2>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <?php 
                if ((isset($_SESSION['username']) && isset($_SESSION['password']) ) || (isset($_COOKIE['username']) && isset($_COOKIE['password'])  ) ) {
                    echo '<li><a href="account.php">Thông tin tài khoản</a></li>
                    <li><a href="logout.php">Đăng xuất</a></li>';
                } else {
                    echo '<li><a href="register.php">Đăng ký</a></li>
                    <li><a href="login.php">Đăng nhập</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
