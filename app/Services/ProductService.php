<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getAll()
    {
        return Product::with(['brand', 'category', 'creator'])->orderBy('created_at', 'desc');
    }

    public function store(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->fileService->upload($data['image'], 'uploads/products');
        }

        $data['created_by'] = Auth::id();

        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->fileService->upload($data['image'], 'uploads/products', $product->image);
        }

        return $product->update($data);
    }

    public function delete(Product $product)
    {
        if ($product->image) {
            $this->fileService->delete($product->image);
        }
        return $product->delete();
    }
}
