<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apprentices', function (Blueprint $table) {
            $table->string('cell')->nullable()->change();
            $table->string('surname')->nullable()->after('name');
            $table->string('document')->nullable()->after('surname');
            $table->string('address')->nullable()->after('document');
            $table->tinyInteger('estrato')->unsigned()->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('apprentices', function (Blueprint $table) {
            $table->dropColumn(['surname', 'document', 'address', 'estrato']);
        });
    }
};
