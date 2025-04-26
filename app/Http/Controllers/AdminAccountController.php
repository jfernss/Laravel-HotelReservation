<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function index()
    {
        $adminAccounts = AdminAccount::all();
        return response()->json($adminAccounts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:admin_accounts',
            'password' => 'required|string|min:6',
        ]);

        $adminAccount = AdminAccount::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($adminAccount, 201);
    }

    public function show($id)
    {
        $adminAccount = AdminAccount::findOrFail($id);
        return response()->json($adminAccount);
    }

    public function update(Request $request, $id)
    {
        $adminAccount = AdminAccount::findOrFail($id);

        $request->validate([
            'username' => 'sometimes|required|string|max:50|unique:admin_accounts,username,' . $adminAccount->id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        if ($request->has('username')) {
            $adminAccount->username = $request->username;
        }

        if ($request->has('password')) {
            $adminAccount->password = bcrypt($request->password);
        }

        $adminAccount->save();

        return response()->json($adminAccount);
    }

    public function destroy($id)
    {
        $adminAccount = AdminAccount::findOrFail($id);
        $adminAccount->delete();

        return response()->json(null, 204);
    }
}