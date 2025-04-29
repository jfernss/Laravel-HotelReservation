<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Star Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/logo.png') }}">

    <style>
        .hero-section::before {
            content: "";
            position: absolute;
            top: 10;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-section {
            background: url('{{ asset('storage/images/hero-section.jpg') }}') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .highlight {
            font-weight: bold;
            color: white;
        }

        .btn-reserve:hover {
            background-color: #345B98 !important;
            color: #fafafa;
        }
    </style>
</head>

<body>
    @include('layouts.topbar') {{-- Include the topbar here --}}
    <header class="hero-section">
        <div class="container text-center hero-content d-column">
            <h1>WELCOME TO DARREL & AYIEN'S <span class="highlight">FIVE STAR HOTEL</span></h1>
            <p>Where luxury meets tranquility. Your private paradise with stunning pool views and tropical gardens
                awaits.</p>
            <a href="{{ route('reservation') }}" class="btn btn-reserve btn-lg px-5 py-3 fs-5 fw-semibold text-white"
                style="background-color: #1A2D4A;">Reserve Now</a>
        </div>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>