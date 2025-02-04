<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Carbon\Carbon;
use Log;
use Storage;

class PruneSoftDeletedCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:prune';

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

            // 1. Xóa ảnh 
            $imageOld = $category->icon;

            if (!empty($imageOld) && Storage::exists($imageOld)) {
                Storage::delete($imageOld);
                Log::info(__METHOD__ . ': Đã xóa ảnh ' . $imageOld);
            } else {
                Log::error(__METHOD__ . ': Lỗi xóa ảnh ' . $imageOld);
            }

        }
        $this->info("Đã xóa vĩnh viễn {{$count}} sản phẩm");
    }
}
