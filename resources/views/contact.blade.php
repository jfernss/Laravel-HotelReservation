<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/logo.png') }}">
    <style>
        body {
            background-color: #F8F9FA;
        }

        .contact-container {
            display: flex;
            height: 100vh;
            background-color: #F8F9FA;
        }

        .image-container {
            position: relative;
            width: 50%;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50%;
        }

        .contact-card {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        .contact-card h2 {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .contact-card .form-control {
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 1.1rem;
            padding: 12px;
        }

        .contact-card .social-icons {
            margin-top: 15px;
        }

        .contact-card .social-icons a {
            margin: 0 10px;
            font-size: 25px;
            color: #0D1426;
            transition: 0.3s;
        }

        .contact-card .social-icons a:hover {
            color: #345B98;
        }

        .btn-send {
            background-color: #0D1426;
            color: #fafafa;
            border-radius: 10px;
            width: 100%;
            padding: 12px;
            font-size: 1.2rem;
            border: none;
            transition: 0.3s;
        }

        .btn-send:hover {
            background-color: #345B98;
            color: #fafafa;
        }
    </style>
</head>

<body>
    @include('layouts.topbar') {{-- Include the reusable topbar --}}
    <div class="contact-container">
        <div class="image-container">
            <img src="{{ asset('storage/images/contact.jpg') }}" alt="Resort Image">
            <div class="image-overlay"></div>
        </div>
        <div class="form-container">
            <div class="contact-card">
                <h2>Contact Us</h2>
                <form>
                    <input type="text" class="form-control" placeholder="Name">
                    <input type="text" class="form-control" placeholder="Phone Number">
                    <input type="email" class="form-control" placeholder="Email">
                    <textarea class="form-control" rows="4" placeholder="Message"></textarea>
                    <div class="d-flex justify-content-center mt-3 social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                    <button type="submit" class="btn btn-send mt-4">Send</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>