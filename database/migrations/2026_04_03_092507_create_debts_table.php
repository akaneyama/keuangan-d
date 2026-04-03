<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('debts', function (Blueprint $user) {
            $user->id();
            $user->foreignId('user_id')->constrained()->onDelete('cascade');
            $user->string('name'); // Nama peminjam/pemberi pinjaman
            $user->decimal('amount', 15, 2);
            $user->enum('type', ['debt', 'receivable']); // debt = kita hutang, receivable = kita piutang
            $user->date('due_date')->nullable();
            $user->text('note')->nullable();
            $user->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $user->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debts');
    }
};
