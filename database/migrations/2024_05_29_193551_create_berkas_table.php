<?php

use App\Models\Status;
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
        Schema::create('status', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->timestamps();
        });
        $data = [
            ['name' => 'Terkirim'],
            ['name' => 'Diterima'],
            ['name' => 'Revisi'],
            ['name' => 'Ditolak'],
        ];
        foreach ($data as $key => $value) {
            Status::create($value);
        }
        Schema::create('berkas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignid('status_id')->references('id')->on('status');
            $table->string('file')->nullable();
            $table->string('filename')->nullable();
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('berkas');
        Schema::dropIfExists('status');
    }
};
