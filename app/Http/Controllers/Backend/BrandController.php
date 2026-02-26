<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::orderBy('created_at', 'desc');

            return DataTables::of($brands)
                ->editColumn('status', function ($brand) {
                    $badge = $brand->status === 'active' ? 'bg-success' : 'bg-danger';
                    return '<span class="badge ' . $badge . '">' . ucfirst($brand->status) . '</span>';
                })
                ->addColumn('action', function ($brand) {
                    return view('partials.action-buttons', [
                        'id' => $brand->id,
                        'edit_route' => route('brand.edit', $brand->id),
                        'delete_route' => route('brand.destroy', $brand->id),
                        'edit_in_drawer' => true
                    ])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('Backend.Brand.Index');
    }

    public function create()
    {
        return view('Backend.Brand.Create');
    }

    public function store(BrandRequest $request)
    {
        Brand::create($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Brand created successfully!']);
        }

        return redirect()->route('brand.index')->with('success', 'Brand created successfully!');
    }

    public function edit(Brand $brand)
    {
        return view('Backend.Brand.Edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Brand updated successfully!']);
        }

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Brand deleted successfully!']);
        }

        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully!');
    }
}
