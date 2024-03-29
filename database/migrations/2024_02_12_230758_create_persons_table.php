<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['customers', 'suppliers']);
            $table->string('identity_document_type_id');
            $table->string('number');
            $table->string('name');
            $table->string('trade_name')->nullable();
            $table->char('country_id', 2);
            $table->char('department_id', 2)->nullable();
            $table->char('province_id', 4)->nullable();
            $table->char('district_id', 6)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->timestamps();

            $table->foreign('identity_document_type_id')->references('id')->on('cat_identity_document_types');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
        });

        DB::table('persons')->insert([
            [
                "id" => 1,
                "type" => "customers",
                "identity_document_type_id" => "1",
                "number" => "76610984",
                "name" => "Quispe Mamani Jose",
                "trade_name" => "Quispe Mamani Jose",
                "country_id" => "PE",
                "department_id" => "23",
                "province_id" => "2301",
                "district_id" => "230101",
                "birthdate" => "1994-07-18",
                "address" => "tacna",
                "email" => "joseft@gmail.com",
                "telephone" => "931134948",
                "created_at" => "2024-02-15 16:38:16",
                "updated_at" => "2024-02-15 16:38:17"
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
};
