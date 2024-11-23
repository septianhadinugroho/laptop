<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul -->
    <title>Login | Laporan Terintegrasi Online Platform</title>

    <!-- Icon Web-->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/loginregis.css">
</head>

   <!-- Awal Login -->
   <body>
    <!-- Notifikasi -->
   <div id="notification" class="notification"></div>
   @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('{{ session('error') }}', 'error');
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errors = '';
                @foreach ($errors->all() as $error)
                    errors += '{{ $error }}\n';
                @endforeach
                showNotification(errors, 'error');
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('{{ session('success') }}', 'success');
            });
        </script>
    @endif
      <div class="wrapper">
         <div class="title-text">
            <div class="title login">
               Login Form
            </div>
            <div class="title signup">
               Sign Up Form
            </div>
         </div>
         <div class="form-container">
            <div class="slide-controls">
               <input type="radio" name="slide" id="login" checked>
               <input type="radio" name="slide" id="signup">
               <label for="login" class="slide login">Login</label>
               <label for="signup" class="slide signup">Sign Up</label>
               <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form action="{{ route('login') }}" method="POST" class="login">
                    @csrf
                  <div class="field">
                     <input type="text" name="email" placeholder="Email Address" required>
                  </div>
                  <div class="field">
                     <input type="password" name="password" placeholder="Password" required>
                  </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Login">
                  </div>
                  <div class="signup-link">
                     Belum Punya Akun? <a href="">Sign Up Sekarang</a>
                  </div>
               </form>
               <form action="{{ route('register') }}" method="POST" class="signup">
                @csrf
                <div class="field">
                    <input type="text" name="name" placeholder="Nama Lengkap" required> <!-- Tambahkan field ini -->
                </div>
                  <div class="field">
                     <input type="email" name="email" placeholder="Email Address" required>
                  </div>
                  <div class="field">
                     <input type="password" name="password" placeholder="Password" required>
                  </div>
                  <div class="field">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Sign Up">
                  </div>
               </form>
            </div>
         </div>
      </div>

      <!-- Akhir Login -->

     <!-- Awal JS Login -->
      <script>
         const loginText = document.querySelector(".title-text .login");
         const loginForm = document.querySelector("form.login");
         const signupForm = document.querySelector("form.signup");
         const loginBtn = document.querySelector("label.login");
         const signupBtn = document.querySelector("label.signup");
         const signupLink = document.querySelector("form .signup-link a");
         const notification = document.getElementById("notification");

         signupBtn.onclick = () => {
            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
         };

         loginBtn.onclick = () => {
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
         };

         signupLink.onclick = () => {
            signupBtn.click();
            return false;
         };

         // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.innerText = message;
            notification.className = `notification ${type} show`;

            // Menghilangkan notifikasi setelah 3 detik
            setTimeout(() => {
                notification.classList.remove("show");
            }, 3000); // 3000 ms = 3 detik
        }
      </script>
      <!-- Akhir JS Login -->

   </body>
</html>
