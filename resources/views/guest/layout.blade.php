<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#28a745">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Kementerian Agama Nganjuk">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIBUTEK (Sistem Buku Tamu Elektronik) Kementerian Agama Kabupaten Nganjuk')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 50%, #20c997 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            overflow-x: hidden;
        }

        .container-fluid {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .form-header h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2.5rem;
        }

        .form-header p {
            opacity: 0.9;
            margin: 0;
        }

        .form-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 16px; /* Prevents zoom on iOS */
            transition: all 0.3s ease;
            -webkit-appearance: none;
            appearance: none;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            outline: none;
        }

        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
            padding-right: 40px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-primary:hover, .btn-primary:active {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
        }

        .welcome-section {
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .welcome-section h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .welcome-section p {
            font-size: 1.2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .icon-feature {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .icon-feature i {
            font-size: 2rem;
        }

        .required {
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .welcome-section {
                display: none;
            }

            .form-header h1 {
                font-size: 2rem;
            }

            .form-body {
                padding: 1.5rem;
            }

            .container-fluid {
                padding: 1rem;
            }

            .form-container {
                border-radius: 15px;
                margin: 1rem 0;
            }

            .form-header {
                padding: 1.5rem;
            }

            .btn-primary {
                padding: 12px 30px;
                font-size: 1rem;
                width: 100%;
                min-height: 44px; /* Apple recommended touch target */
            }

            /* Prevent horizontal scroll */
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
                max-width: 100vw;
            }

            /* Optimize touch targets */
            .form-control, .btn {
                min-height: 44px;
            }

            /* Better mobile form spacing */
            .form-group {
                margin-bottom: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .form-header h1 {
                font-size: 1.5rem;
            }

            .form-body {
                padding: 1rem;
            }

            .form-control {
                padding: 10px 15px;
                font-size: 16px; /* Prevents zoom on iOS */
            }

            .btn-primary {
                width: 100%;
                padding: 12px;
                min-height: 48px;
            }

            /* Safe area for notched devices */
            .container-fluid {
                padding-left: max(15px, env(safe-area-inset-left));
                padding-right: max(15px, env(safe-area-inset-right));
            }
        }

        /* Landscape mobile optimization */
        @media (max-height: 500px) and (orientation: landscape) {
            .container-fluid {
                align-items: flex-start;
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .form-header {
                padding: 1rem;
            }

            .form-body {
                padding: 1rem;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- HTTPS Helper -->
    <script src="{{ asset('js/https-helper.js') }}"></script>

    @yield('scripts')
</body>
</html>
