<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div style="text-align: center;">
    <h1>National Cancer Health Fund</h1>
    <!-- <h2>Billing Invoice</h2> -->
    <h3>{{ $hospitalName }}</h3>
    <p>{{ $hospitalAddress ?? '' }}</p>
</div>


    <h2>Billing Invoice</h2>
    <p><strong>Invoice Date:</strong> {{ $invoiceDate }}</p>
    <p><strong>Invoice Number:</strong> {{ $invoiceNumber }}</p>
    <p><strong>Billed To:</strong> National Institute for Cancer Research and Treatment (NICRAT)</p>

    <h3>Patient Billing Details:</h3>
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Transaction Date</th>
                <th>Patient ID</th>
                <th>Date of Admission</th>
                <th>Date of Discharge</th>
                <th>Total Bill (₦)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($billings as $index => $billing)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($billing->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $billing->patientId }}</td>
                    <td>{{ \Carbon\Carbon::parse($billing->admission_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($billing->discharge_date)->format('d/m/Y') }}</td>
                    <td>N{{ number_format($billing->total_cost, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Amount Payable: N{{ number_format($totalAmount, 2) }}</h3>

    <footer>
        <p>Authorized By: [Hospital Admin Name] | Date: {{\Carbon\Carbon::now()->format('d/m/Y')}}</p>
    </footer>

</body>
</html>
