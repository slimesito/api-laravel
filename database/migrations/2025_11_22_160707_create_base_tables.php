<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTables extends Migration
{
    public function up()
    {
        // 1. Tabla Usuarios
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Tabla Autores
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('books_count')->default(0); // Campo para el Job
            $table->timestamps();
        });

        // 3. Tabla Libros
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('published_date');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();

            // Llave foránea
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    public function down()
    {
        // El orden es importante al borrar por las llaves foráneas
        Schema::dropIfExists('books');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('users');
    }
}
