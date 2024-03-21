<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuRoleMap;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('role');
    }

    public function getRoleData()
    {
        $roles = Role::get();
        return view('role.get_role', compact('roles'));
    }

    public function menu()
    {
        $menus = Menu::get();
        $parentMenus = Menu::with('children')
            ->where('parent_menu_id', 0)
            ->where('status', 1)
            ->get();
        return view('role.menu.menu', compact('menus', 'parentMenus'));
    }

    public function getMenus()
    {
        $menus = Menu::get();
        return view('role.menu.get_menu_list', compact('menus'));
    }

    public function storeMenus(Request $request): \Illuminate\Http\Response
    {

        $validAttribute = request()->validate([
            'menu_name' => 'string|required',
            'menu_link' => 'nullable|string',
            'menu_icon' => 'nullable|string',
            'parent_menu_id' => 'numeric',
            'display_order' => 'numeric|required',
            'status' => 'nullable|numeric',
        ]);

        if (!isset($request->status)) {
            $validAttribute['status'] = 0;
        }
        if ($request->id !== null) {
            $menu = Menu::find($request->id);
            $menu->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            Menu::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function storeRole(Request $request): \Illuminate\Http\Response
    {
        $validAttribute = request()->validate([
            'name' => 'required|string',
            'description' => 'nullable |string',
            'user_level' => 'required|numeric',
        ]);

        if ($request->id !== null) {
            $role = Role::find($request->id);
            $role->update($validAttribute);
            return response(['status' => 'success', 'msg' => 'Successfully updated.']);
        } else {
            Role::create($validAttribute);
            return response(['status' => 'success', 'msg' => 'Completed successfully.']);
        }
    }

    public function assignRole()
    {
        $roles = Role::all();
        return view('role.assign.assign', compact('roles'));
    }

    public function getMenuForRoleAssign(Request $request)
    {
        $role_id = $request->input('role_id');
        $menus = Menu::where('status', 1)->get();
        $parentMenus = Menu::where('parent_menu_id', 0)->where('status', 1)->with('children')->get();
        $roleMenuMap = MenuRoleMap::where('role_id', $role_id)->pluck('menu_id');

        return view('role.assign.get_menu_for_role_assign', compact('menus', 'roleMenuMap', 'parentMenus'));
    }

    public function assignMap(Request $request): \Illuminate\Http\JsonResponse
    {
        $assignedMenus = $request->input('menus') ?: [];
        $role_id = $request->input('role_id');
        $menus = Menu::whereIn('id', $assignedMenus)->get();
        $role = Role::find($role_id);

        if ($role->menus()->sync($menus))
            return response()->json(['msg' => '
            Menu provided.', 'status' => 'success'], 200);
        else
            return response()->json(['msg' => 'Error', 'status' => 'error'], 500);

    }
}
