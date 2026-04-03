<table>
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; font-size: 14px;">Laporan Keuangan Bulan {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Ringkasan</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td>Total Pemasukan</td>
            <td style="text-align: right;">{{ $totalIncome }}</td>
            <td></td>
            <td>Hutang Belum Lunas</td>
            <td style="text-align: right; color: #ff0000;">{{ $unpaidDebts }}</td>
        </tr>
        <tr>
            <td>Total Pengeluaran</td>
            <td style="text-align: right;">{{ $totalExpense }}</td>
            <td></td>
            <td>Piutang Belum Kembali</td>
            <td style="text-align: right; color: #008000;">{{ $unpaidReceivables }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Net Balance</td>
            <td style="font-weight: bold; text-align: right;">{{ $netBalance }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr></tr>
        <tr style="background-color: #f0f0f0; font-weight: bold;">
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
            <td style="color: #008000;">Pemasukan</td>
            <td>{{ optional($income->category)->name }}</td>
            <td>{{ $income->description }}</td>
            <td style="text-align: right;">{{ $income->amount }}</td>
        </tr>
        @endforeach
        @foreach($expenses as $expense)
        <tr>
            <td>{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
            <td style="color: #ff0000;">Pengeluaran</td>
            <td>{{ optional($expense->category)->name }}</td>
            <td>{{ $expense->description }}</td>
            <td style="text-align: right;">{{ $expense->amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
