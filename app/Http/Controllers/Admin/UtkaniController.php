<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utkani;

class UtkaniController extends Controller
{
    public function index(Request $request)
    {
        $query = Utkani::orderBy('start_time', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('home_team', 'LIKE', "%{$search}%")
                ->orWhere('away_team', 'LIKE', "%{$search}%");
        }

        $score = $query->paginate(20);

        return view('admin.score.index', compact('score'));
    }


    public function edit($id)
    {
        $match = Utkani::findOrFail($id);
        return view('admin.score.edit', compact('match'));
    }

    public function update(Request $request, $id)
    {
        $match = Utkani::findOrFail($id);
        $match->update($request->all());
        return redirect('admin/score')->with('success', 'Zápas byl úspěšně upraven.');
    }

    public function delete($id)
    {
        Utkani::findOrFail($id)->delete();
        return redirect('admin/score')->with('success', 'Zápas byl smazán.');
    }

}
