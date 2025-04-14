<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Zobrazí seznam všech uživatelů.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Zobrazí formulář pro úpravu uživatele.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Uživatel nebyl nalezen.');
        }

        return view('admin.users.edit', compact('user'));
    }


    /**
     * Aktualizuje informace o uživatelském účtu.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->money = $request->money;
        $user->usertype = $request->usertype;


        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        session()->flash('success', 'Uživatel byl úspěšně upraven!');
        session()->flash('fail');
        return redirect()->route('admin.users.index');
    }

    /**
     * Smaže uživatele.
     */
    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('success', 'Uživatel byl úspěšně smazán!');
        return redirect()->route('admin.users.index');
    }

    /**
     * Zobrazí formulář pro vytvoření nového uživatele.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Uloží nového uživatele.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'usertype' => 'required|in:admin,editor,user',
            'password' => 'required|string|confirmed|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'usertype' => $validated['usertype'],
            'password' => bcrypt($validated['password']),
        ]);

        session()->flash('success', 'Uživatel byl úspěšně vytvořen!');
        return redirect()->route('admin.users.index');
    }


}
