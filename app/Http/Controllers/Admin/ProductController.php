<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query();

        if ($keyword = request('search')) {
            $products->where('title', 'LIKE', "%{$keyword}%")->orWhere('id', $keyword);
        }

        $products = $products->latest()->paginate(20);

        return view('admin.products.all', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'categories' => 'required',
            'attributes' => 'array',
        ]);

        $product = auth()->user()->products()->create($data);
        $product->categories()->sync($data['categories']);

        $this->attachAttributesToProduct($data['attributes'], $product);

        alert('', 'محصول مورد نظر با موفقیت ثبت شد', 'success');
        return to_route('admin.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return $product->attributes[0]->pivot;
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'categories' => 'required',
            'attributes' => 'array'
        ]);

        $product->update($data);
        $product->categories()->sync($data['categories']);

        // delete all previos attributes
        $product->attributes()->detach();

        $this->attachAttributesToProduct($data['attributes'], $product);

        alert('', 'محصول مورد نظر با موفقیت ویرایش شد', 'success');
        return to_route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        alert('', 'محصول مورد نظر با موفقیت حذف شد', 'success');
        return back();
    }

    /**
     * @param $attributes1
     * @param Product $product
     * @return void
     */
    protected function attachAttributesToProduct($attr, Product $product): void
    {
        $attributes = collect($attr);
        $attributes->each(function ($item) use ($product) {
            if (is_null($item['name']) || is_null($item['value'])) return;

            $attr = Attribute::firstOrCreate([
                'name' => $item['name'],
            ]);

            $attr_value = $attr->values()->firstOrCreate([
                'value' => $item['value'],
            ]);

            $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        });
    }
}
