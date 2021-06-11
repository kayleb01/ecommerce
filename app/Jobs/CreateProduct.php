<?php

namespace App\Jobs;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {

        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $product = Product::create($this->product);

        //store media files if attached
        if (!empty($this->product['product_image'])) {
            Media::find($this->product['product_image'])->each->update([
                'model_id' => $product->id,
                'model_type' => Product::class
            ]);
        }
            return $product;
    }
}
