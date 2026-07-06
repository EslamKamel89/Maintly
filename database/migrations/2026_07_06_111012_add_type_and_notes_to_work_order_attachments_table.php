<?php

use App\Enums\WorkOrderAttachmentType;
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
        Schema::table('work_order_attachments', function (Blueprint $table) {
            $table->string('type')
                ->default(WorkOrderAttachmentType::General->value)
                ->after('uploaded_by');

            $table->text('notes')
                ->nullable()
                ->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_attachments', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'notes',
            ]);
        });
    }
};
