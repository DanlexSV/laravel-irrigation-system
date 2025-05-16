<?php

namespace App\Http\Controllers\Floors;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
	public function list()
    {
        $floors = Floor::orderBy('name')->paginate(10);
        return response()->json($floors);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $floors = Floor::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return response()->json($floors);
    }
}
