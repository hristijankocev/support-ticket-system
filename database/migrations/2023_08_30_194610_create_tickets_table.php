<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(User::class, 'agent_id')
                ->nullable()
                ->constrained('users');
            $table->string('title');
            $table->text('body');
            $table->enum('severity', [
                'low',
                'medium',
                'major',
                'critical'
            ]);
            $table->enum('status', [
                'open',
                'in-progress',
                'resolved',
                'closed'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
