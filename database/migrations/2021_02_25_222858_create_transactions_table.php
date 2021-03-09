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
                $table->string('status')->default('pending');
                $table->foreignIdFor(\App\Models\PaymentRequest::class)->nullable();
                $table->integer('purchaseable_id');
                $table->string('purchaseable_type');
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
