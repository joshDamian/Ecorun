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
                $table->string('vendor_type');
                $table->integer('vendor_id');
                $table->string('buyer_type');
                $table->integer('buyer_id');
                $table->foreignIdFor(\App\Models\PaymentRequest::class);
                $table->string('status');
                $table->string('purchaseable_id');
                $table->integer('purchaseable_type');
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