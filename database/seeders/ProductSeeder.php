<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\ShopReview;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private function seedCategory() {
        $categories = ['coffee', 'non-coffee', 'cake', 'snack', 'meal'];
        $image_paths = [
            'assets/images/coffee.png',
            'assets/images/juice.png',
            'assets/images/cake.png',
            'assets/images/snack.png',
            'assets/images/meal.png'
        ];
        $description = 'Lorem ipsum dolor';

        Category::whereIn('name', $categories)->delete();

        for ($i = 0; $i < count($categories); $i++) {
            Category::create([
                'name' => $categories[$i],
                'image_path' => $image_paths[$i],
                'description' => $description
            ]);
        }
    }

    private function seedProduct() {
        $products = [
            'pandan coffee', 'milk tea', 'red velvet cake', 'chips', 'spaghetti'
        ];
        $category = Category::orderBy('id', 'asc')->pluck('id')->toArray();
        $description = 'Lorem ipsum dolor';
        $stock = 10;
        $price = 20000;

        Product::whereIn('name', $products)->delete();

        foreach ($products as $i => $name) {
            Product::create([
                'name' => $name,
                'category_id' => $category[$i],
                'stock' => $stock,
                'price' => $price,
                'description' => $description,
                'image_path' => 'assets/images/' . $name . '.jpg'
            ]);
            
            $stock += 4;
            $price += 3000;
        }
    }

    private function seedInvoice() {
        $codes = ['a0000', 'a0001', 'a0002', 'a0003', 'a0004'];
        $delivery_cost = 10000;
        $user_id = User::pluck('id')->toArray();

        Invoice::whereIn('code', $codes)->delete();

        foreach ($codes as $i => $code) {
            $user = $user_id[$i%count($user_id)];
            Invoice::create([
                'code' => $code,
                'delivery_cost' => $delivery_cost,
                'user_id' => $user
            ]);

            $delivery_cost += 2500;
        }
    }

    private function seedInvoiceProduct() {
        $product_id = Product::pluck('id')->toArray();
        $invoice_code = Invoice::pluck('code')->toArray();

        if(count($product_id) > 0 && count($invoice_code) > 0) {
            InvoiceProduct::whereIn('invoice_code', $invoice_code)->delete();
    
            foreach ($invoice_code as $code) {
                $quantity = 3;
    
                foreach ($product_id as $products) {
                    InvoiceProduct::create([
                        'invoice_code' => $code,
                        'product_id' => $products,
                        'quantity' => $quantity
                    ]);
        
                    $quantity++;
                }
            }
        }
    }

    private function seedShopReview() {
        $user_id = User::pluck('id')->toArray();

        if(count($user_id) > 0) {
            ShopReview::whereIn('user_id', $user_id)->delete();
            
            for ($i = 0; $i <= 5; $i++) {
                ShopReview::create([
                    'user_id' => $user_id[$i % count($user_id)],
                    'rate' => $i,
                    'review' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
                ]);
            }
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedCategory();
        $this->seedProduct();
        $this->seedInvoice();
        $this->seedInvoiceProduct();
        $this->seedShopReview();
    }
}
