<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->text('description');
            $table->text('answer')->nullable()->comment("admin's response to users tickets");
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('seen')->default(0)->comment('0 => unseen and not seen with admins, 1 => seened with admin');
            $table->tinyInteger('seen_user')->default(0)->comment('0 => unseen and not seen with user, 1 => seened with user');
            $table->foreignId('reference_id')->comment('admin id of responder as reference_id ')->constrained('ticket_admins')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('ticket_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('priority_id')->constrained('ticket_priorities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('answer_status')->nullable();
            $table->timestamp('answer_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
