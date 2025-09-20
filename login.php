<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập & Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">


        <div id="signin-form" class="form-wrapper">
            <form action="db/login.php" method="POST">
                <span class="form-title">ĐĂNG NHẬP</span>

                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input class="input-field" type="text" name="username" placeholder="Tên đăng nhập" required>
                </div>

                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input class="input-field" type="password" name="password" placeholder="Mật khẩu" required>
                </div>
                
                <button class="form-button" type="submit">ĐĂNG NHẬP</button>

                <div class="form-footer">
                    <span>Bạn chưa có tài khoản?</span>
                    <a href="#" id="show-signup">Đăng ký ngay</a>
                </div>
            </form>
        </div>

        

        <div id="signup-form" class="form-wrapper" style="display: none;">
            <form action="db/register.php" method="POST">
                <span class="form-title">ĐĂNG KÍ</span>

                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input class="input-field" type="text" name="username" placeholder="Tên đăng nhập" required>
                </div>
                
                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input class="input-field" type="password" name="password" placeholder="Mật khẩu" required>
                </div>

                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input class="input-field" type="email" name="email" placeholder="Email" required>
                </div>
                
                <div class="input-group select-group">
                    <span class="role-label">Vai trò :</span>
                    <span class="input-icon"><i class="fas fa-briefcase"></i></span>
                    <select name="role" class="styled-select" required>
                        <option value="1">Người tìm việc</option>
                        <option value="2">Người thuê</option>
                    </select>
                </div>

                <button class="form-button" type="submit">ĐĂNG KÍ</button>

                <div class="form-footer">
                    <span>Bạn đã có tài khoản? </span>
                    <a href="#" id="show-signin">Đăng nhập ngay</a>
                </div>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
