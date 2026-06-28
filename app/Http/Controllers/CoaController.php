<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coa;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CoaController extends Controller
{       
    public function index(Request $request)
    {
        $query = Coa::with('category');

        if ($request->search) {

            $search = $request->search;

            $query->where(function($q) use ($search){

                $q->where(
                    'code',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'name',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $coas = $query
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view(
            'coas.index',
            compact('coas')
        );
    }
    public function create()
    {
        $categories = Category::all();
        return view('coas.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'code' => 'required|max:20|unique:coas',
            'name' => 'required'
        ]);
        Coa::create($request->all());
        return redirect()
            ->route('coas.index')
            ->with('success', 'COA created successfully');
    }
    public function edit(Coa $coa)
    {
        $categories = Category::all();

        return view('coas.edit', compact(
            'coa',
            'categories'
        ));
    }
    public function update(Request $request, Coa $coa)
    {
        $request->validate([
            'category_id' => 'required',
            'code' => 'required|max:20|unique:coas,code,' . $coa->id,
            'name' => 'required',
        ]);

        $coa->update($request->all());

        return redirect()
            ->route('coas.index')
            ->with('success', 'COA updated successfully');
    }
    public function destroy(Coa $coa)
    {
        if ($coa->transactions()->exists()) {
            return redirect()
                ->route('coas.index')
                ->with('error', 'COA already used in transaction');
        }
        $coa->delete();
        return redirect()
            ->route('coas.index')
            ->with('success', 'COA deleted successfully');
    }
}
