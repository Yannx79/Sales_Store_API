<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        // return Product::all();
        return Product::where('state', 1)->get();
    }
    public function getById($id)
    {
        return Product::findOrFail($id);
    }
    public function store(array $data)
    {
        return Product::create($data);
    }
    public function update(array $data, $id)
    {
        return Product::findOrFail($id)->update($data);
    }
    public function delete($id)
    {
        // return Product::destroy($id);
        // return Product::delete($id);
        return Product::findOrFail($id)->update(['state' => 3]);
    }
}
