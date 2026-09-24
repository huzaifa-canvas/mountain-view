<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The admin lists bookings and feedback newest-first, but neither table had an
 * index on created_at, so MySQL sorted the whole table to return one page.
 * EXPLAIN reported "Using filesort" with key=NULL; with these indexes the same
 * queries read the index directly.
 */
return new class extends Migration
{
    /**
     * Tables and the index each one needs, keyed by the index name MySQL
     * would generate anyway, so re-running is a no-op.
     */
    private array $indexes = [
        'orders'    => 'orders_created_at_index',
        'feedbacks' => 'feedbacks_created_at_index',
    ];

    public function up(): void
    {
        foreach ($this->indexes as $table => $indexName) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'created_at')) {
                continue;
            }

            if (Schema::hasIndex($table, $indexName)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->index('created_at');
            });
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $table => $indexName) {
            if (!Schema::hasTable($table) || !Schema::hasIndex($table, $indexName)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                // Array form, so Laravel derives "<table>_created_at_index";
                // a bare string would be read as a literal index name.
                $blueprint->dropIndex(['created_at']);
            });
        }
    }
};
