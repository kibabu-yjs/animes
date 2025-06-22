<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Author;
return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Author::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('synopsis');
            $table->integer('episodes');
            $table->date('date_of_publication');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
