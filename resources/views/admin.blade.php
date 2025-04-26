<?php
session_start();
try {
    $conn = new PDO("mysql:host=localhost;dbname=hotelreservation_laravel", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Delete reservation
if (isset($_POST['delete'])) {
    $id = $_POST['reservation_id'];
    $deleteQuery = "DELETE FROM reservations WHERE id = :id";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Add new reservation
if (isset($_POST['add_reservation'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $stmt = $conn->prepare("INSERT INTO reservations (customer_name, contact_number, room_type, room_capacity, payment_type, from_date, to_date, num_days, sub_total, additional_charge, discount_amount, total_bill, reservation_time) VALUES (:customerName, :contactNumber, :roomType, :roomCapacity, :paymentType, :fromDate, :toDate, :numDays, :subTotal, :additionalCharge, :discountAmount, :totalBill, :reservationTime)");

        // Calculate number of days
        $fromDate = new DateTime($_POST['from_date']);
        $toDate = new DateTime($_POST['to_date']);
        $numDays = $fromDate->diff($toDate)->days;
        if ($numDays <= 0) {
            throw new Exception("End date must be after start date");
        }

        // Calculate rates based on room type and capacity
        $rates = [
            'Single' => ['Regular' => 1000, 'Deluxe' => 3000, 'Suite' => 5000],
            'Double' => ['Regular' => 2000, 'Deluxe' => 5000, 'Suite' => 8000],
            'Family' => ['Regular' => 5000, 'Deluxe' => 7500, 'Suite' => 10000]
        ];

        $dailyRate = $rates[$_POST['room_capacity']][$_POST['room_type']];
        $subTotal = $dailyRate * $numDays;

        // Calculate discount
        $discount = ($numDays >= 6) ? 0.15 : 0.10;
        $discountAmount = $subTotal * $discount;

        // Calculate additional charges
        $additionalCharge = 0;
        if ($_POST['payment_type'] === 'Cheque') {
            $additionalCharge = $subTotal * 0.05;
        } elseif ($_POST['payment_type'] === 'Credit') {
            $additionalCharge = $subTotal * 0.10;
        }

        // Calculate total bill with proper decimal handling
        $totalBill = number_format($subTotal + $additionalCharge - $discountAmount, 2, '.', '');
        $subTotal = number_format($subTotal, 2, '.', '');
        $additionalCharge = number_format($additionalCharge, 2, '.', '');
        $discountAmount = number_format($discountAmount, 2, '.', '');

        $stmt->execute([
            ':customerName' => $_POST['customer_name'],
            ':contactNumber' => $_POST['contact_number'],
            ':roomType' => $_POST['room_type'],
            ':roomCapacity' => $_POST['room_capacity'],
            ':paymentType' => $_POST['payment_type'],
            ':fromDate' => $fromDate->format('Y-m-d'),
            ':toDate' => $toDate->format('Y-m-d'),
            ':numDays' => $numDays,
            ':subTotal' => $subTotal,
            ':additionalCharge' => $additionalCharge,
            ':discountAmount' => $discountAmount,
            ':totalBill' => $totalBill,
            ':reservationTime' => date('Y-m-d H:i:s')
        ]);

        $_SESSION['success_message'] = "Reservation added successfully!";
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
}

// Update reservation
if (isset($_POST['update_reservation'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $stmt = $conn->prepare("UPDATE reservations SET 
            customer_name = :customerName,
            contact_number = :contactNumber,
            room_type = :roomType,
            room_capacity = :roomCapacity,
            payment_type = :paymentType,
            from_date = :fromDate,
            to_date = :toDate,
            num_days = :numDays,
            sub_total = :subTotal,
            additional_charge = :additionalCharge,
            discount_amount = :discountAmount,
            total_bill = :totalBill
            WHERE id = :id");

        $fromDate = new DateTime($_POST['from_date']);
        $toDate = new DateTime($_POST['to_date']);
        $numDays = $fromDate->diff($toDate)->days;
        if ($numDays <= 0) {
            throw new Exception("End date must be after start date");
        }

        $rates = [
            'Single' => ['Regular' => 1000, 'Deluxe' => 3000, 'Suite' => 5000],
            'Double' => ['Regular' => 2000, 'Deluxe' => 5000, 'Suite' => 8000],
            'Family' => ['Regular' => 5000, 'Deluxe' => 7500, 'Suite' => 10000]
        ];

        $dailyRate = $rates[$_POST['room_capacity']][$_POST['room_type']];
        $subTotal = $dailyRate * $numDays;

        $discount = ($numDays >= 6) ? 0.15 : 0.10;
        $discountAmount = $subTotal * $discount;

        $additionalCharge = 0;
        if ($_POST['payment_type'] === 'Cheque') {
            $additionalCharge = $subTotal * 0.05;
        } elseif ($_POST['payment_type'] === 'Credit') {
            $additionalCharge = $subTotal * 0.10;
        }

        $totalBill = number_format($subTotal + $additionalCharge - $discountAmount, 2, '.', '');
        $subTotal = number_format($subTotal, 2, '.', '');
        $additionalCharge = number_format($additionalCharge, 2, '.', '');
        $discountAmount = number_format($discountAmount, 2, '.', '');

        $stmt->execute([
            ':id' => $_POST['reservation_id'],
            ':customerName' => $_POST['customer_name'],
            ':contactNumber' => $_POST['contact_number'],
            ':roomType' => $_POST['room_type'],
            ':roomCapacity' => $_POST['room_capacity'],
            ':paymentType' => $_POST['payment_type'],
            ':fromDate' => $fromDate->format('Y-m-d'),
            ':toDate' => $toDate->format('Y-m-d'),
            ':numDays' => $numDays,
            ':subTotal' => $subTotal,
            ':additionalCharge' => $additionalCharge,
            ':discountAmount' => $discountAmount,
            ':totalBill' => $totalBill
        ]);

        $_SESSION['success_message'] = "Reservation updated successfully!";
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
}

// Fetch dashboard data
$stmt = $conn->prepare("SELECT COUNT(*) FROM reservations");
$stmt->execute();
$totalReservations = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT SUM(total_bill) FROM reservations");
$stmt->execute();
$totalRevenue = $stmt->fetchColumn();

// Fetch reservations
$query = "SELECT * FROM reservations ORDER BY reservation_time DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/logo.png') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #1e396b;
            margin-bottom: 30px;
        }

        .dashboard-container {
            margin-bottom: 40px;
        }

        .dashboard-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e396b;
            margin-bottom: 20px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 32px;
            color: #4c8bc2;
            font-weight: bold;
        }

        .stat-card p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #dcdcdc;
        }

        th {
            background-color: #4c8bc2;
            color: #ffffff;
            text-align: left;
            padding: 10px;
        }

        td {
            padding: 10px;
            color: #333333;
        }

        tr:nth-child(even) {
            background-color: #eaf4fc;
        }

        tr:hover {
            background-color: #cce7f6;
        }

        button {
            background-color: #6cb2e4;
            color: #ffffff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #4c8bc2;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message" id="successMessage">
        <?php    echo $_SESSION['success_message'];
    unset($_SESSION['success_message']); ?>
    </div>
    <script>
        setTimeout(() => {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 2000); 
    </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
    <div class="error-message"><?php    echo $_SESSION['error_message'];
    unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <div class="dashboard-container">
        <h2 class="dashboard-title">Dashboard Overview</h2>
        <div class="stats-container">
            <div class="stat-card">
                <h3><?php echo $totalReservations; ?></h3>
                <p>Total Reservations</p>

            </div>
            <div class="stat-card">
                <h3>₱<?php echo number_format($totalRevenue, 2); ?></h3>
                <p>Total Revenue</p>

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reservation Details</h1>
        <div>
            <button class="btn btn-primary"
                onclick="document.getElementById('addReservationModal').style.display='block'">Add New
                Reservation</button>
            <a href="{{ route('admin.login') }}" class="btn btn-secondary">Logout</a>
        </div>
    </div>

    <!-- Reservation Modal -->
    <div id="addReservationModal" class="modal">
        <div class="modal-content">
            <span class="close"
                onclick="document.getElementById('addReservationModal').style.display='none'">&times;</span>
            <h2>Add New Reservation</h2>
            <form method="POST" action="{{ route('reservations.store') }}">
                @csrf
                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                </div>
                <div class="form-group">
                    <label for="from_date">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                </div>
                <div class="form-group">
                    <label for="to_date">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                </div>
                <div class="form-group">
                    <label for="room_type">Room Type</label>
                    <select class="form-control" id="room_type" name="room_type" required>
                        <option value="">Select Room Type</option>
                        <option value="Regular">Regular</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="room_capacity">Room Capacity</label>
                    <select class="form-control" id="room_capacity" name="room_capacity" required>
                        <option value="">Select Room Capacity</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Family">Family</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_type">Payment Type</label>
                    <select class="form-control" id="payment_type" name="payment_type" required>
                        <option value="">Select Payment Type</option>
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Credit">Credit</option>
                    </select>
                </div>
                <button type="submit" name="add_reservation" class="btn btn-primary">Add Reservation</button>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Contact Number</th>
                <th>Room Type</th>
                <th>Room Capacity</th>
                <th>Payment Type</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Num Days</th>
                <th>Sub Total</th>
                <th>Additional Charge</th>
                <th>Discount Amount</th>
                <th>Total Bill</th>
                <th>Reservation Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
            <tr>
                <td><?php    echo htmlspecialchars($row['id']); ?></td>
                <td><?php    echo htmlspecialchars($row['customer_name']); ?></td>
                <td><?php    echo htmlspecialchars($row['contact_number']); ?></td>
                <td><?php    echo htmlspecialchars($row['room_type']); ?></td>
                <td><?php    echo htmlspecialchars($row['room_capacity']); ?></td>
                <td><?php    echo htmlspecialchars($row['payment_type']); ?></td>
                <td><?php    echo htmlspecialchars($row['from_date']); ?></td>
                <td><?php    echo htmlspecialchars($row['to_date']); ?></td>
                <td><?php    echo htmlspecialchars($row['num_days']); ?></td>
                <td><?php    echo htmlspecialchars($row['sub_total']); ?></td>
                <td><?php    echo htmlspecialchars($row['additional_charge']); ?></td>
                <td><?php    echo htmlspecialchars($row['discount_amount']); ?></td>
                <td><?php    echo htmlspecialchars($row['total_bill']); ?></td>
                <td><?php    echo htmlspecialchars($row['reservation_time']); ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm"
                        onclick="editReservation(<?php    echo htmlspecialchars(json_encode($row)); ?>)">
                        Edit
                    </button>
                    <form method="POST" action="{{ route('reservations.destroy', $row['id']) }}"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Edit Reservation Modal -->
    <div id="editReservationModal" class="modal">
        <div class="modal-content">
            <span class="close"
                onclick="document.getElementById('editReservationModal').style.display='none'">&times;</span>
            <h2>Edit Reservation</h2>
            <form method="POST" id="editReservationForm" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_reservation_id" name="reservation_id">
                <div class="form-group">
                    <label for="edit_customer_name">Customer Name</label>
                    <input type="text" class="form-control" id="edit_customer_name" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label for="edit_contact_number">Contact Number</label>
                    <input type="text" class="form-control" id="edit_contact_number" name="contact_number" required>
                </div>
                <div class="form-group">
                    <label for="edit_from_date">From Date</label>
                    <input type="date" class="form-control" id="edit_from_date" name="from_date" required>
                </div>
                <div class="form-group">
                    <label for="edit_to_date">To Date</label>
                    <input type="date" class="form-control" id="edit_to_date" name="to_date" required>
                </div>
                <div class="form-group">
                    <label for="edit_room_type">Room Type</label>
                    <select class="form-control" id="edit_room_type" name="room_type" required>
                        <option value="">Select Room Type</option>
                        <option value="Regular">Regular</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_room_capacity">Room Capacity</label>
                    <select class="form-control" id="edit_room_capacity" name="room_capacity" required>
                        <option value="">Select Room Capacity</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Family">Family</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_payment_type">Payment Type</label>
                    <select class="form-control" id="edit_payment_type" name="payment_type" required>
                        <option value="">Select Payment Type</option>
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Credit">Credit</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Reservation</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
        function editReservation(reservation) {
            document.getElementById('edit_reservation_id').value = reservation.id;
            document.getElementById('edit_customer_name').value = reservation.customer_name;
            document.getElementById('edit_contact_number').value = reservation.contact_number;
            document.getElementById('edit_room_type').value = reservation.room_type;
            document.getElementById('edit_room_capacity').value = reservation.room_capacity;
            document.getElementById('edit_payment_type').value = reservation.payment_type;
            document.getElementById('edit_from_date').value = reservation.from_date;
            document.getElementById('edit_to_date').value = reservation.to_date;

            // Set the form action dynamically
            document.getElementById('editReservationForm').action = `/admin/reservations/${reservation.id}`;
            document.getElementById('editReservationModal').style.display = 'block';
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById('addReservationModal')) {
                document.getElementById('addReservationModal').style.display = "none";
            }
            if (event.target == document.getElementById('editReservationModal')) {
                document.getElementById('editReservationModal').style.display = "none";
            }
        }

        // Set minimum date for date inputs
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('from_date').min = today;
            document.getElementById('to_date').min = today;

            document.getElementById('from_date').addEventListener('change', function () {
                document.getElementById('to_date').min = this.value;
            });
        });
    </script>
</body>

</html>

<?php
$conn = null;
?>