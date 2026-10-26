<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('sifen_cdc', 44)->nullable()->index()->after('payment_condition');
            $table->string('sifen_numero_factura', 20)->nullable()->index()->after('sifen_cdc');
            $table->string('sifen_estado', 30)->default('ninguno')->after('sifen_numero_factura');
            $table->text('sifen_qr_url')->nullable()->after('sifen_estado');
            $table->longText('sifen_xml')->nullable()->after('sifen_qr_url');
            $table->text('sifen_respuesta')->nullable()->after('sifen_xml');
            $table->integer('sifen_tipo_documento')->default(1)->after('sifen_respuesta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'sifen_cdc',
                'sifen_numero_factura',
                'sifen_estado',
                'sifen_qr_url',
                'sifen_xml',
                'sifen_respuesta',
                'sifen_tipo_documento',
            ]);
        });
    }
};
