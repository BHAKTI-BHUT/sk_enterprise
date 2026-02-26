<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::orderBy('created_at', 'desc');

            return DataTables::of($categories)
                ->editColumn('status', function ($category) {
                    $badge = $category->status === 'active' ? 'bg-success' : 'bg-danger';
                    return '<span class="badge ' . $badge . '">' . ucfirst($category->status) . '</span>';
                })
                ->addColumn('action', function ($category) {
                    return view('partials.action-buttons', [
                        'id' => $category->id,
                        'edit_route' => route('category.edit', $category->id),
                        'delete_route' => route('category.destroy', $category->id),
                        'edit_in_drawer' => true
                    ])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('Backend.Category.Index');
    }

    public function create()
    {
        return view('Backend.Category.Create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Category created successfully!']);
        }

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('Backend.Category.Edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Category updated successfully!']);
        }

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Category deleted successfully!']);
        }

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}
