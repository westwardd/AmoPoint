<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jokes', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->nullable()->index();
            $table->string('type')->nullable();
            $table->text('setup')->nullable();
            $table->text('punchline')->nullable();
            $table->json('raw')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jokes');
    }
};
