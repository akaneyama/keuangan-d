<x-app-layout>
    <x-slot name="header">
        {{ isset($savingsTarget) ? 'Edit Target Tabungan' : 'Buat Target Tabungan Baru' }}
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
        <form action="{{ isset($savingsTarget) ? route('savings-targets.update', $savingsTarget) : route('savings-targets.store') }}" method="POST">
            @csrf
            @if(isset($savingsTarget)) @method('PUT') @endif

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Target</label>
                <input type="text" name="name" value="{{ old('name', $savingsTarget->name ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Beli Laptop Baru">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Target (Rp)</label>
                <input type="number" step="0.01" name="target_amount" value="{{ old('target_amount', isset($savingsTarget) ? (float)$savingsTarget->target_amount : '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('target_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tenggat Waktu (Opsional)</label>
                <input type="date" name="deadline" value="{{ old('deadline', isset($savingsTarget) && $savingsTarget->deadline ? $savingsTarget->deadline->format('Y-m-d') : '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('deadline') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('savings-targets.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
