<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        h1 { margin: 0 0 5px 0; font-size: 18px; }
        h2 { margin: 0; font-size: 14px; font-weight: normal; color: #666; }
        .summary { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 4px; }
        .summary p { margin: 5px 0; font-size: 14px; }
        .summary .positive { color: green; }
        .summary .negative { color: red; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-size: 11px; text-transform: uppercase; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan Pribadi</h1>
        <h2>Bulan: {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h2>
    </div>

    <div class="summary">
        <p><strong>Total Pemasukan:</strong> <span class="positive">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span></p>
        <p><strong>Total Pengeluaran:</strong> <span class="negative">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span></p>
        <p><strong>Net Balance:</strong> <span class="{{ $netBalance >= 0 ? 'positive' : 'negative' }}">Rp {{ number_format($netBalance, 0, ',', '.') }}</span></p>
    </div>

    <h3>Rincian Pemasukan</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incomes as $income)
            <tr>
                <td>{{ \Carbon\Carbon::parse($income->date)->format('d/m/Y') }}</td>
                <td>{{ optional($income->category)->name }}</td>
                <td>{{ $income->description }}</td>
                <td class="text-right">Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Rincian Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                <td>{{ optional($expense->category)->name }}</td>
                <td>{{ $expense->description }}</td>
                <td class="text-right">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
