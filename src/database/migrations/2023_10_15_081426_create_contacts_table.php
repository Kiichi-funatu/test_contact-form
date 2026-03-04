<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');                 // bigint unsigned, PK
    $table->unsignedBigInteger('category_id');   // bigint unsigned
    $table->string('first_name', 255);           // varchar(255)
    $table->string('last_name', 255);            // varchar(255)
    $table->tinyInteger('gender');               // tinyint
    $table->string('email', 255);                // varchar(255)
    $table->string('tel', 255);                  // varchar(255)
    $table->string('address', 255);              // varchar(255)
    $table->string('building', 255)->nullable(); // varchar(255) NULL 許可
    $table->text('detail');                      // text
    $table->timestamps();                        // created_at / updated_at

    // 外部キー
    $table->foreign('category_id')
          ->references('id')
          ->on('categories')
          ->cascadeOnDelete();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
