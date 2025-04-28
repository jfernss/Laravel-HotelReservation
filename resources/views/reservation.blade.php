{{-- filepath: c:\Xampp\htdocs\HotelReservation-Laravel\resources\views\reservation.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/logo.png') }}">

    <style>
        .reservation-form {
            max-width: 100% !important;
            margin: 2rem 2rem !important;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: relative;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .radio-group {
            display: flex;
            gap: 2rem;
            margin: 1rem 0;
        }

        .btn-submit {
            font-size: 1.3rem;
            background-color: #1A2D4A !important;
            color: #fafafa !important;
            padding: 0.75rem 2rem;
        }

        .btn-clear {
            font-size: 1.3rem;
            padding: 0.75rem 2rem;
        }

        .current-time-display {
            background-color: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border-left: 4px solid #334D99;
            position: absolute;
            top: 0;
            right: 2rem;
            margin-top: 1rem;
            white-space: nowrap;
        }

        .error {
            color: red;
        }

        /* Move the close button (x mark) to the top-right corner of the modals */
        .modal-content {
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }
    </style>
</head>

<body>
    @include('layouts.topbar') {{-- Include the topbar here --}}
    <div class="container-fluid">
        <form class="reservation-form" action="{{ route('reservation.details') }}" method="POST" id="reservationForm">
            @csrf {{-- Add CSRF token for security --}}
            <div class="current-time-display">
                <span class="fw-bold">Current Date & Time:</span>
                <span id="currentDateTime" class="fw-bold"></span>
                <input type="hidden" name="submissionTime" id="submissionTime">
            </div>
            <h1 class="mb-4">Make a Reservation</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customerName">Customer Name:</label>
                        <input type="text" class="form-control" id="customerName" name="customerName" required>
                    </div>
                    <div class="form-group">
                        <label for="contactNumber">Contact Number:</label>
                        <input type="text" class="form-control" id="contactNumber" name="contactNumber" required>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Room Type:</label>
                        <div class="radio-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="roomType" id="suite" value="Suite">
                                <label class="form-check-label" for="suite">Suite</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="roomType" id="deluxe" value="Deluxe">
                                <label class="form-check-label" for="deluxe">Deluxe</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="roomType" id="regular"
                                    value="Regular">
                                <label class="form-check-label" for="regular">Regular</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Room Capacity:</label>
                        <div class="radio-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="roomCapacity" id="family"
                                    value="Family">
                                <label class="form-check-label" for="family">Family</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="roomCapacity" id="double"
                                    value="Double">
                                <label class="form-check-label" for="double">Double</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="roomCapacity" id="single"
                                    value="Single">
                                <label class="form-check-label" for="single">Single</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Payment Type:</label>
                        <div class="radio-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentType" id="cash" value="Cash">
                                <label class="form-check-label" for="cash">Cash</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentType" id="cheque"
                                    value="Cheque">
                                <label class="form-check-label" for="cheque">Cheque</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentType" id="credit"
                                    value="Credit">
                                <label class="form-check-label" for="credit">Credit</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="fw-bold">From Date:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="fromDate" name="fromDate"
                                placeholder="Select check-in date" required readonly>
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">To Date:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="toDate" name="toDate"
                                placeholder="Select check-out date" required readonly>
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-3">
                <button type="submit" class="btn btn-submit mt-4">Submit Reservation</button>
                <button type="button" class="btn btn-secondary btn-clear mt-4" id="clearForm">Clear Entry</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const currentDateTime = new Date().toLocaleString();
            document.getElementById("currentDateTime").textContent = currentDateTime;
            document.getElementById("submissionTime").value = currentDateTime;
        });

        $(document).ready(function () {
            $('#fromDate').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                autoclose: true,
                startDate: new Date(),
                orientation: "bottom auto"
            }).on('changeDate', function () {
                const minDate = new Date($('#fromDate').val());
                $('#toDate').datepicker('setStartDate', minDate);

                const toDate = new Date($('#toDate').val());
                if (toDate <= minDate) {
                    $('#toDate').val('');
                }
            });

            $('#toDate').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                autoclose: true,
                startDate: new Date(),
                orientation: "bottom auto"
            });

            $('#clearForm').click(function () {
                $('#reservationForm')[0].reset();
                $('#fromDate').datepicker('clearDates');
                $('#toDate').datepicker('clearDates');
                $('#toDate').datepicker('setStartDate', new Date());
            });

            $('#reservationForm').on('submit', function (e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Add Reservation',
                    text: 'Are you sure you want to add this reservation?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, add it!',
                    customClass: {
                        popup: 'swal2-smaller-popup' // Custom class for smaller size
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Reservation added successfully',
                            showConfirmButton: false,
                            timer: 1200,
                            customClass: {
                                popup: 'swal2-smaller-popup' // Custom class for smaller size
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>