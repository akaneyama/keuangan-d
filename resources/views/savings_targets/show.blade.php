<x-app-layout>
    <x-slot name="header">
        Detail Target: {{ $savingsTarget->name }}
    </x-slot>

    @php
        $percentage = $savingsTarget->target_amount > 0 ? min(100, ($savingsTarget->current_amount / $savingsTarget->target_amount) * 100) : 0;
        $statusColor = $savingsTarget->status == 'completed' ? 'green' : 'indigo';
        $pProgressColor = $percentage >= 80 ? 'green' : 'indigo';
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Target Info -->
        <div class="md:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Target</h3>
                    <a href="{{ route('savings-targets.edit', $savingsTarget) }}" class="text-sm text-indigo-600 hover:text-indigo-900 border border-indigo-200 px-3 py-1 rounded">Edit</a>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="font-semibold text-{{ $statusColor }}-600">{{ ucfirst($savingsTarget->status) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Target Nominal</div>
                        <div class="font-bold text-xl text-gray-800">Rp {{ number_format($savingsTarget->target_amount, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Sudah Terkumpul</div>
                        <div class="font-bold text-xl text-{{ $pProgressColor }}-600">Rp {{ number_format($savingsTarget->current_amount, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Kekurangan</div>
                        <div class="font-semibold text-gray-700">Rp {{ number_format(max(0, $savingsTarget->target_amount - $savingsTarget->current_amount), 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Tenggat Waktu</div>
                        <div class="font-medium text-gray-800">{{ $savingsTarget->deadline ? $savingsTarget->deadline->format('d M Y') : 'Tanpa batas waktu' }}</div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div class="bg-{{ $pProgressColor }}-600 h-3 rounded-full transition-all duration-500 relative" style="width: {{ $percentage }}%">
                                @if($percentage >= 80 && $percentage < 100)
                                    <span class="absolute -top-6 right-0 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded whitespace-nowrap">Hampir tercapai!</span>
                                @endif
                                @if($percentage >= 100)
                                    <span class="absolute -top-6 right-0 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded whitespace-nowrap">Target Tercapai 🎉</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right text-sm text-gray-600 font-bold">{{ number_format($percentage, 1) }}%</div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <form action="{{ route('savings-targets.destroy', $savingsTarget) }}" method="POST" onsubmit="return confirm('Menghapus target ini juga akan menghapus semua riwayat setorannya. Lanjutkan?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full text-red-600 border border-red-200 hover:bg-red-50 font-medium py-2 rounded-md transition text-sm">Hapus Target</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Transactions -->
        <div class="md:col-span-2 space-y-6">
            <!-- Add Transaction -->
            @if($savingsTarget->status != 'completed')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Setor Tabungan</h3>
                <form action="{{ route('savings-transactions.store') }}" method="POST" class="flex flex-wrap items-end gap-4">
                    @csrf
                    <input type="hidden" name="savings_target_id" value="{{ $savingsTarget->id }}">
                    
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                        <input type="number" step="0.01" name="amount" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="w-40">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <input type="text" name="note" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Opsional">
                    </div>
                    
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 h-10 rounded-md font-medium transition">Setorkan</button>
                </form>
            </div>
            @endif

            <!-- List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Setoran</h3>
                <div class="overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs text-gray-500 uppercase tracking-wider">
                                <th class="pb-3 font-medium">Tanggal</th>
                                <th class="pb-3 font-medium">Nominal</th>
                                <th class="pb-3 font-medium">Catatan</th>
                                <th class="pb-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($savingsTarget->transactions as $trx)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 text-sm text-gray-700">{{ $trx->date->format('d M Y') }}</td>
                                <td class="py-3 text-sm font-bold text-green-600">+ Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="py-3 text-sm text-gray-500">{{ $trx->note ?: '-' }}</td>
                                <td class="py-3 text-sm text-right">
                                    <form action="{{ route('savings-transactions.destroy', $trx) }}" method="POST" onsubmit="return confirm('Batal setoran ini? Saldo target akan berkurang.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Batal</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-500 text-sm">Belum ada riwayat setoran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
