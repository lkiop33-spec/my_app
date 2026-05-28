<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateEncryption extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:migrate-encryption 
            {--table= : The table name to migrate (all if omitted)} 
            {--chunk=1000 : Chunk size for processing} 
            {--dry-run : Only show what would be done} 
            {--only-missing : Only process records where _enc column is null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate plain text columns to encrypted columns';

    protected $encryptionMap = [
        'work_lists' => ['partList'],
        'pcb_tables' => ['Name_Type', 'Image_File'],
        'part_tables' => ['Name', 'Process_Detail', 'Image_File'],
        'pcb_image_tables' => ['Image', 'BoundBox', 'Other'],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tableParam = $this->option('table');
        $chunkSize = (int) $this->option('chunk');
        $isDryRun = $this->option('dry-run');
        $onlyMissing = $this->option('only-missing');

        $tablesToProcess = $tableParam 
            ? (isset($this->encryptionMap[$tableParam]) ? [$tableParam => $this->encryptionMap[$tableParam]] : [])
            : $this->encryptionMap;

        if (empty($tablesToProcess)) {
            $this->error("No tables found to process. Please check the table name.");
            return;
        }

        foreach ($tablesToProcess as $table => $columns) {
            $this->info("Processing table: {$table}");
            
            $query = \Illuminate\Support\Facades\DB::table($table);
            
            // Assume primary key is 'idx' based on schema, fall back to 'id' if not standard
            $pk = 'idx';
            if ($table === 'system_logs') $pk = 'id'; // Exception

            if ($onlyMissing) {
                $query->where(function ($q) use ($columns) {
                    foreach ($columns as $index => $col) {
                        if ($index === 0) {
                            $q->whereNull($col . '_enc');
                        } else {
                            $q->orWhereNull($col . '_enc');
                        }
                    }
                });
            }

            $total = $query->count();
            $this->info("Total records to process: {$total}");

            if ($total === 0) continue;

            $bar = $this->output->createProgressBar($total);
            
            $successCount = 0;
            $failCount = 0;
            $failedIds = [];

            // Reset query for chunking
            $query = \Illuminate\Support\Facades\DB::table($table)
                ->orderBy($pk);

            if ($onlyMissing) {
                $query->where(function ($q) use ($columns) {
                    foreach ($columns as $index => $col) {
                        if ($index === 0) {
                            $q->whereNull($col . '_enc');
                        } else {
                            $q->orWhereNull($col . '_enc');
                        }
                    }
                });
            }

            $query->chunk($chunkSize, function ($records) use ($table, $columns, $pk, $isDryRun, &$bar, &$successCount, &$failCount, &$failedIds) {
                foreach ($records as $record) {
                    $updateData = [];
                    $hasError = false;

                    foreach ($columns as $column) {
                        $encColumn = $column . '_enc';
                        
                        // If only-missing is true, and it already has a value, skip this column
                        if ($this->option('only-missing') && !is_null($record->{$encColumn})) {
                            continue;
                        }

                        if (!empty($record->{$column})) {
                            try {
                                $updateData[$encColumn] = \Illuminate\Support\Facades\Crypt::encryptString($record->{$column});
                            } catch (\Exception $e) {
                                $hasError = true;
                                \Illuminate\Support\Facades\Log::error("Encryption failed for table {$table}, PK {$record->{$pk}}: " . $e->getMessage());
                            }
                        }
                    }

                    if (!empty($updateData) && !$hasError) {
                        if (!$isDryRun) {
                            \Illuminate\Support\Facades\DB::table($table)->where($pk, $record->{$pk})->update($updateData);
                        }
                        $successCount++;
                    } elseif ($hasError) {
                        $failCount++;
                        $failedIds[] = $record->{$pk};
                    }

                    $bar->advance();
                }
            });

            $bar->finish();
            $this->newLine(2);
            $this->info("Summary for {$table}:");
            $this->info("  Total: {$total} / Success: {$successCount} / Failed: {$failCount}");
            if (!empty($failedIds)) {
                $this->error("  Failed IDs: " . implode(', ', array_slice($failedIds, 0, 100)) . (count($failedIds) > 100 ? '...' : ''));
            }
            $this->newLine();
        }
    }
}
