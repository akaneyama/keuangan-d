<table>
    <thead>
        <tr>
            <th colspan="4">Laporan Keuangan Bulan {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="2">Total Pemasukan</th>
            <th colspan="2">{{ $totalIncome }}</th>
        </tr>
        <tr>
            <th colspan="2">Total Pengeluaran</th>
            <th colspan="2">{{ $totalExpense }}</th>
        </tr>
        <tr>
            <th colspan="2">Net Balance</th>
            <th colspan="2">{{ $netBalance }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($incomes as $income)
        <tr>
            <td>{{ \Carbon\Carbon::parse($income->date)->format('Y-m-d') }}</td>
            <td>Pemasukan</td>
            <td>{{ optional($income->category)->name }}</td>
            <td>{{ $income->description }}</td>
            <td>{{ $income->amount }}</td>
        </tr>
        @endforeach
        @foreach($expenses as $expense)
        <tr>
            <td>{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
            <td>Pengeluaran</td>
            <td>{{ optional($expense->category)->name }}</td>
            <td>{{ $expense->description }}</td>
            <td>{{ $expense->amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
