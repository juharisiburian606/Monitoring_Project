<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin - SCBD</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            background: #fff;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
            text-align: center;
        }

        .logo img {
            width: 140px;
            margin-bottom: 25px;
        }

        h2 {
            font-size: 22px;
            font-weight: 600;
            color: #0f1c2e;
            margin-bottom: 6px;
        }

        p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 28px;
        }

        .input-group {
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            outline: none;
            font-size: 14px;
            background: #fff;
            transition: 0.2s;
        }

        .input-group input:focus {
            border-color: #0f172a;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            color: #fff;
            font-weight: 600;
            background: linear-gradient(to right, #152133, #0a0f17);
            margin-top: 10px;
        }

        /* ========= RESPONSIVE TABLET ========= */
        @media (max-width: 820px) {
            .login-container {
                max-width: 90%;
                padding: 40px 25px;
            }
            .logo img {
                width: 130px;
            }
        }

        /* ========= RESPONSIVE HANDPHONE ========= */
        @media (max-width: 480px) {
            .login-container {
                max-width: 92%;
                padding: 35px 22px;
            }
            h2 {
                font-size: 20px;
            }
            .logo img {
                width: 120px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="logo">
            <!-- Ganti ini dengan logo kamu -->
            <img src="SCBD LOGO.png" alt="SCBD Logo">
        </div>

        <h2>Login to You Acount</h2>
        <p>Silahkan login untuk masuk sistem montoring project</p>

        <form action="" method="post">
            <div class="input-group">
                <input type="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <input type="password" placeholder="Password" required>
            </div>

            <button class="btn-login">Masuk Sekarang</button>
        </form>
    </div>

</body>
</html>
