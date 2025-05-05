<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Star Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/logo.png') }}">

    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-heading) !important;
        }

        h2,
        h3 {
            font-family: var(--font-subheading) !important;
        }

        body {
            font-family: var(--font-body) !important;
            background-color: #ebe8e8 !important;
        }

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

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    @include('layouts.topbar')
    <header class="hero-section">
        <div class="container text-center hero-content d-column">
            <h1>WELCOME TO DARREL & AYIEN'S <span class="highlight">FIVE STAR HOTEL</span></h1>
            <p>Where luxury meets tranquility. Your private paradise with stunning pool views and tropical gardens
                awaits.</p>
            <a href="{{ route('reservation') }}" class="btn btn-reserve btn-lg px-4 py-2 fs-6 fw-semibold text-white"
                style="background-color: #1A2D4A;">Reserve Now</a>
        </div>
    </header>

    <section class="hotel-offers py-5">
        <div class="container">
            <h2 class="text-center mb-4">Hotel Offers</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/images/1.jpg') }}" class="card-img-top" alt="Deluxe Room">
                        <div class="card-body">
                            <h5 class="card-title">The Serenity Pod</h5>
                            <p class="card-text">Room Type: Single</p>
                            <p class="card-text">A cozy room with modern amenities and a stunning view of the city.</p>
                            <a href="{{ route('reservation') }}" class="btn btn-reserve btn-lg px-4 py-2 fs-6 fw-semibold text-white" style="background-color: #1A2D4A;">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/images/2.jpg') }}" class="card-img-top" alt="Suite Room">
                        <div class="card-body">
                            <h5 class="card-title">The Velvet Eclipse Suite</h5>
                            <p class="card-text">Room Type: Double</p>
                            <p class="card-text">Experience luxury in our spacious suite with a private balcony.</p>
                            <a href="{{ route('reservation') }}" class="btn btn-reserve btn-lg px-4 py-2 fs-6 fw-semibold text-white" style="background-color: #1A2D4A;">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/images/3.png') }}" class="card-img-top" alt="Family Room">
                        <div class="card-body">
                            <h5 class="card-title">The Cloud Nine Den</h5>
                            <p class="card-text">Room Type: Family</p>
                            <p class="card-text">Perfect for families, this room offers ample space and comfort.</p>
                            <a href="{{ route('reservation') }}" class="btn btn-reserve btn-lg px-4 py-2 fs-6 fw-semibold text-white" style="background-color: #1A2D4A;">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>