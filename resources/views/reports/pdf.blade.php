<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Premium</title>
    <style>
        @page { margin: 0cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #334155; 
            margin: 0; 
            padding: 0;
            line-height: 1.5;
            background-color: #ffffff;
        }
        .bg-indigo { background-color: #4f46e5; color: white; }
        .bg-slate { background-color: #f8fafc; }
        .text-indigo { color: #4f46e5; }
        .text-rose { color: #e11d48; }
        .text-emerald { color: #10b981; }
        .text-slate { color: #64748b; }
        
        /* Header Section */
        .page-header {
            padding: 40px 50px;
            background: linear-gradient(to right, #1e1b4b, #312e81);
            color: white;
        }
        .header-title { font-size: 24px; font-weight: 900; letter-spacing: -1px; margin-bottom: 5px; }
        .header-subtitle { font-size: 12px; font-weight: 500; opacity: 0.8; letter-spacing: 2px; text-transform: uppercase; }
        
        .content { padding: 40px 50px; }
        
        /* Summary Grid */
        .summary-container { margin-bottom: 40px; }
        .summary-card {
            width: 30%;
            display: inline-block;
            vertical-align: top;
            padding: 15px;
            border-radius: 15px;
            margin-right: 2%;
            background-color: #f1f5f9;
        }
        .card-label { font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .card-value { font-size: 16px; font-weight: 900; }
        
        /* Section Titles */
        .section-title {
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #f1f5f9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { 
            text-align: left; 
            padding: 12px 10px; 
            font-size: 9px; 
            font-weight: 800; 
            color: #64748b; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            border-bottom: 1px solid #e2e8f0;
        }
        td { padding: 12px 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .font-bold { font-weight: 700; }
        .font-black { font-weight: 900; }
        .text-right { text-align: right; }
        
        /* Debt Alert Box */
        .debt-summary {
            background-color: #fff1f2;
            border-left: 4px solid #e11d48;
            padding: 15px 20px;
            border-radius: 0 12px 12px 0;
            margin-bottom: 30px;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 20px 50px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="header-title">LAPORAN KEUANGAN</div>
        <div class="header-subtitle">{{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</div>
    </div>

    <div class="content">
        <!-- Summary Dashboard -->
        <div class="summary-container">
            <div class="summary-card">
                <div class="card-label">Total Pemasukan</div>
                <div class="card-value text-emerald">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="card-label">Total Pengeluaran</div>
                <div class="card-value text-rose">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card" style="margin-right: 0; background-color: #e0e7ff;">
                <div class="card-label" style="color: #4f46e5;">Saldo Bersih</div>
                <div class="card-value text-indigo">Rp {{ number_format($netBalance, 0, ',', '.') }}</div>
            </div>
        </div>

        @if($unpaidDebts > 0 || $unpaidReceivables > 0)
        <div class="debt-summary">
            <div style="font-weight: 900; color: #9f1239; margin-bottom: 5px; font-size: 12px;">RINGKASAN TANGGUNGAN</div>
            <table style="margin-bottom: 0; border: none;">
                <tr style="border: none;">
                    <td style="border: none; padding: 0; color: #e11d48; font-weight: 700;">Hutang Belum Lunas: Rp {{ number_format($unpaidDebts, 0, ',', '.') }}</td>
                    <td style="border: none; padding: 0; color: #059669; font-weight: 700; text-align: right;">Piutang Belum Kembali: Rp {{ number_format($unpaidReceivables, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        @endif

        <!-- Tables -->
        <div class="section-title">Rincian Pemasukan</div>
        <table>
            <thead>
                <tr>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Kategori</th>
                    <th width="45%">Deskripsi / Keterangan</th>
                    <th width="20%" class="text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incomes as $income)
                <tr>
                    <td class="text-slate font-bold">{{ \Carbon\Carbon::parse($income->date)->format('d M Y') }}</td>
                    <td><span class="text-indigo font-bold">{{ optional($income->category)->name }}</span></td>
                    <td class="text-slate">{{ $income->description ?: '-' }}</td>
                    <td class="text-right font-black text-emerald">Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-slate italic">Tidak ada data pemasukan di periode ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="section-title">Rincian Pengeluaran</div>
        <table>
            <thead>
                <tr>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Kategori</th>
                    <th width="45%">Deskripsi / Keterangan</th>
                    <th width="20%" class="text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                <tr>
                    <td class="text-slate font-bold">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                    <td><span class="text-rose font-bold">{{ optional($expense->category)->name }}</span></td>
                    <td class="text-slate">{{ $expense->description ?: '-' }}</td>
                    <td class="text-right font-black text-rose">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-slate italic">Tidak ada data pengeluaran di periode ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dicetak otomatis oleh <strong>MyFinance Application</strong> pada {{ date('d/m/Y H:i') }} • Halaman 1 dari 1
    </div>
</body>
</html>
