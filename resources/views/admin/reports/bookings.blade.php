<!DOCTYPE html>
<html>
<head>
    <title>Bookings Report #{{ $report->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { text-align: center; color: #1e40af; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f3f4f6; }
        .header { text-align: center; margin-bottom: 30px; }
        .summary { background-color: #f9fafb; padding: 15px; border-radius: 8px; margin: 20px 0; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SriTravel - Bookings Report</h1>
        <p>Period: {{ $report->start_date }} - {{ $report->end_date }}</p>
        <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
    </div>

    <div class="summary">
        <h2>Bookings Summary</h2>
        <p><strong>Total Bookings:</strong> {{ $reportData['summary']['total_bookings'] ?? 0 }}</p>
        <p><strong>Confirmed:</strong> {{ $reportData['summary']['confirmed_bookings'] ?? 0 }}</p>
        <p><strong>Pending:</strong> {{ $reportData['summary']['pending_bookings'] ?? 0 }}</p>
        <p><strong>Cancelled:</strong> {{ $reportData['summary']['cancelled_bookings'] ?? 0 }}</p>
        <p><strong>Completed:</strong> {{ $reportData['summary']['completed_bookings'] ?? 0 }}</p>
    </div>

    <h2>Booking Details</h2>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer</th>
                <th>Vehicle</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['bookings'] ?? [] as $item)
            <tr>
                <td>Bk{{ $item['id'] }}</td>
                <td>{{ $item['customer_name'] }}</td>
                <td>{{ $item['vehicle'] }}</td>
                <td>{{ $item['status'] }}</td>
                <td>{{ $item['start_date'] }}</td>
                <td>{{ $item['end_date'] }}</td>
                <td>Rs. {{ $item['total_amount'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>