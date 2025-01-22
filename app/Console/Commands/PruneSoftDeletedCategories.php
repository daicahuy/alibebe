<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Carbon\Carbon;

class PruneSoftDeletedCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-soft-deleted-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete soft deleted categories older than 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = 7;
        $categoriesToDelete = Category::onlyTrashed()
            ->where('deleted_at', '<=', Carbon::now()->subDays($days))
            ->get();

        $count = $categoriesToDelete->count();

        foreach ($categoriesToDelete as $category) {
            $category->forceDelete();
        }
        $this->info("Đã xóa vĩnh viễn {{$count}} sản phẩm");
    }
}
