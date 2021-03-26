<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

			$table->foreignIdFor(App\Models\User::class)->nullable(false);
			$table->foreignIdFor(App\Models\TransactionType::class)->nullable(false);
			
			// 'income' or 'expense'
			$table->string('type')->nullable(false);
			$table->date('date')->nullable(false);
			$table->text('description')->nullable(false);
			$table->decimal('value')->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
