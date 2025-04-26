<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hotel Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/logo.png') }}">

    <style>
        .content-section {
            background-color: #fafafa;
            border: 2px solid #E0E0E0;
        }

        .content-section h2 {
            margin-bottom: 1rem;
            font-size: 2rem;
            font-weight: bold;
        }

        .content-section p,
        .content-section ul {
            font-size: 1.3rem;
            line-height: 1.8;
        }

        .content-section ul {
            list-style-type: disc;
            margin-left: 2rem;
        }
    </style>
</head>

<body>
    @include('layouts.topbar') {{-- Include the reusable topbar --}}
    <div class="container mt-5">
        <div class="content-section p-4 mb-5 rounded shadow">
            <h2 style="color: #334D99;">Our Mission</h2>
            <p>Our mission is to provide exceptional hospitality services that exceed guest expectations, creating
                memorable experiences through personalized care, innovation, and a commitment to excellence.</p>
        </div>
        <div class="content-section p-4 mb-5 rounded shadow">
            <h2 style="color: #334D99;">Our Vision</h2>
            <p>Our vision is to be the leading hotel in the industry, recognized for our outstanding service,
                sustainable practices, and dedication to creating a welcoming environment for all our guests.</p>
        </div>
        <div class="content-section p-4 rounded shadow">
            <h2 style="color: #334D99;">Our Objectives</h2>
            <ul>
                <li>To deliver unparalleled guest satisfaction through exceptional service.</li>
                <li>To foster a culture of innovation and continuous improvement.</li>
                <li>To operate sustainably and responsibly, minimizing our environmental impact.</li>
                <li>To create a positive and inclusive workplace for our team members.</li>
                <li>To build lasting relationships with our guests and the community.</li>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>