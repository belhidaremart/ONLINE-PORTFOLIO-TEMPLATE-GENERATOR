<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add a column only if it does not exist yet.
        if (! Schema::hasColumn('portfolios', 'address')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('address', 255)->nullable();
            });
        }

        if (! Schema::hasColumn('portfolios', 'about')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->text('about')->nullable();
            });
        }

        $education = (new \App\Models\Education)->getTable();

        if (! Schema::hasColumn($education, 'level')) {
            Schema::table($education, function (Blueprint $table) {
                $table->string('level', 50)->nullable();
            });
        }
    }

    public function down(): void
    {
        // "address" is not dropped here, because it existed before this migration.
        if (Schema::hasColumn('portfolios', 'about')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('about');
            });
        }

        $education = (new \App\Models\Education)->getTable();

        if (Schema::hasColumn($education, 'level')) {
            Schema::table($education, function (Blueprint $table) {
                $table->dropColumn('level');
            });
        }
    }
};