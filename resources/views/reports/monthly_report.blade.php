<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Monthly Report - {{ now()->format('F Y') }}</h2>
    <p>User: {{ $user->name }} ({{ $user->email }})</p>
    <p>Total Income: ${{ number_format($totalIncome, 2) }}</p>

    <h3>Profiles Summary</h3>
    <table>
        <tr>
            <th>Profile</th>
            <th>Income</th>
            <th>Total Expenses</th>
        </tr>
        @foreach($profiles as $profile)
        <tr>
            <td>{{ $profile->username }}</td>
            <td>${{ number_format($profile->income, 2) }}</td>
            <td>${{ number_format($profile->transactions->whereBetween('created_at',[$lastPeriodStart,$lastPeriodEnd])->sum('amount'), 2) }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Transactions</h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Profile</th>
            <th>Amount</th>
            <th>Category</th>
        </tr>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->created_at->format('d M Y') }}</td>
            <td>{{ $transaction->profile->username }}</td>
            <td>${{ number_format($transaction->amount, 2) }}</td>
            <td>{{ $transaction->category ? $transaction->category->name : 'N/A' }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Goal Progress</h3>
    @if($goal)
        <p>Goal: ${{ number_format($goal->amount, 2) }}</p>
        <p>Progress: ${{ number_format($goal->progress, 2) }} ({{ round(($goal->progress / $goal->amount) * 100, 2) }}%)</p>
    @else
        <p>No active goal.</p>
    @endif

    <h3>Summary</h3>
    <p>Total Saved: ${{ number_format($savedAmount, 2) }}</p>
</body>
</html>
