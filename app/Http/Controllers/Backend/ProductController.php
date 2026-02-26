<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = $this->productService->getAll();

            return DataTables::of($products)
                ->addColumn('image', function ($product) {
                    $url = $product->image ? asset($product->image) : asset('assets/images/no-image.png');
                    return '<img src="' . $url . '" alt="' . $product->name . '" class="rounded-circle" width="40" height="40">';
                })
                ->editColumn('status', function ($product) {
                    $badge = $product->status === 'active' ? 'bg-success' : 'bg-danger';
                    return '<span class="badge ' . $badge . '">' . ucfirst($product->status) . '</span>';
                })
                ->addColumn('action', function ($product) {
                    return view('partials.action-buttons', [
                        'id' => $product->id,
                        'edit_route' => route('product.edit', $product->id),
                        'delete_route' => route('product.destroy', $product->id),
                        'view_route' => route('product.show', $product->id),
                        'edit_in_drawer' => false,
                        'view_in_drawer' => false
                    ])->render();
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('Backend.Product.Index');
    }

    public function create()
    {
        $brands = Brand::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->get();
        return view('Backend.Product.Create', compact('brands', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        $this->productService->store($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Product created successfully!']);
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load(['brand', 'category', 'creator']);
        return view('Backend.Product.Show', compact('product'));
    }

    public function edit(Product $product)
    {
        $brands = Brand::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->get();
        return view('Backend.Product.Edit', compact('product', 'brands', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Product updated successfully!']);
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        if (request()->ajax()) {
            return response()->json(['message' => 'Product deleted successfully!']);
        }

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }

    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        return response()->json(['message' => 'Product status updated!', 'status' => $product->status]);
    }
}
