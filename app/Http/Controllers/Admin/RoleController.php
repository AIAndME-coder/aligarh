<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Services\PermissionDependencyService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class RoleController extends Controller
{
	protected $depService;

	public function __construct(PermissionDependencyService $depService)
	{
		$this->depService = $depService;
	}

	public function index(Request $request)
	{
		$data = [];
		if ($request->ajax()) {
			return DataTables::eloquent(
				Role::select('id', 'name', 'created_at')->notDeveloper()
			)
				->editColumn('created_at', function ($role) {
					return $role->created_at->format('Y-m-d');
				})
				->make(true);
		}
		$data['content'] = null;
		$data['permissions'] = $this->getPermissions();
		return view('admin.roles', $data);
	}


	public function create(Request $request)
	{

		$request->validate([
			'name' => 'required|unique:roles,name',
			'permissions.*' => 'exists:permissions,name',
		], [
			'permissions.*.exists' => 'The selected permission is invalid.',
		]);

		DB::beginTransaction();
		try {
			$Role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);
			$permissions = $request->input('permissions', []);
			
			// Option 2: Auto-grant dependent permissions
			$allPermissions = [];
			foreach ($permissions as $perm) {
				$allPermissions[] = $perm;
				$allPermissions = array_merge($allPermissions, $this->depService->getAllDependencies($perm));
			}
			$allPermissions = array_unique($allPermissions);
			
			$Role->syncPermissions($allPermissions);
			
			// Option 4: Validate completeness and warn if incomplete
			$validation = $this->depService->validatePermissionCompleteness($Role);
			
			// Audit log
			$this->depService->auditPermissionChange($Role, 'create', $allPermissions, [
				'auto_granted_count' => count($allPermissions) - count($permissions)
			]);
			
			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
			return redirect('roles')->with([
				'toastrmsg' => [
					'type' => 'error', 
					'title'  =>  'Roles',
					'msg' =>  __('modules.roles_update_error')
				]
			]);
		}
		
		return redirect('roles')->with([
	        'toastrmsg' => [
	          'type' 	=> 'success', 
	          'title'  	=>  'Role Registration',
	          'msg' 	=>  __('modules.common_register_success')
	          ]
	      	]);
	}

	public function edit($id)
	{
		$role = Role::notDeveloper()->findOrFail($id); 
		$rolePermissions = $role->permissions->pluck('name')->toArray();
		$permissions = $this->getPermissions();


      	return view('admin.edit_role', compact('role', 'rolePermissions', 'permissions'));
	}

	public function update(Request $request, $id)
	{

		$submitted = $request->permissions ?? [];

$valid = \DB::table('permissions')
            ->whereIn('name', $submitted)
            ->pluck('name')
            ->toArray();

$invalid = array_diff($submitted, $valid);

if (!empty($invalid)) {

    // Log invalid permissions
    \Log::warning('Invalid permissions submitted', [
        'invalid_permissions' => $invalid,
        'user_id' => auth()->id(), // optional
        'submitted_permissions' => $submitted,
    ]);

    return back()->withErrors([
        'permissions' => 'These permissions do not exist: ' . implode(', ', $invalid),
    ])->withInput();
}

		$request->validate([
			'permissions.*' => 'exists:permissions,name',
		], [
			'permissions.*.exists' => 'The selected permission is invalid.',
		]);

		DB::beginTransaction();
		try {
			$Role = Role::NotDeveloper()->findOrFail($id);
			$permissions = $request->input('permissions', []);
			
			// Option 2: Auto-grant dependent permissions
			$allPermissions = [];
			foreach ($permissions as $perm) {
				$allPermissions[] = $perm;
				$allPermissions = array_merge($allPermissions, $this->depService->getAllDependencies($perm));
			}
			$allPermissions = array_unique($allPermissions);
			
			$Role->syncPermissions($allPermissions);

			if (filled($request->sync_permissions)) {
				$rolesToSync = Role::NotDeveloper()
					// ->where('id', '!=', $Role->id)
					->get();
				foreach ($rolesToSync as $role) {
					// Apply same dependency logic to all roles
					$role->syncPermissions($allPermissions);
				}
			}
			
			// Option 4: Validate completeness and warn if incomplete
			$validation = $this->depService->validatePermissionCompleteness($Role);
			
			// Audit log
			$this->depService->auditPermissionChange($Role, 'update', $allPermissions, [
				'auto_granted_count' => count($allPermissions) - count($permissions)
			]);

			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
			return redirect('roles')->with([
				'toastrmsg' => [
					'type' => 'error', 
					'title'  =>  'Roles',
					'msg' =>  'There was an issue while Updating Role'
				]
			]);
		}
		
		return redirect('roles')->with([
	        'toastrmsg' => [
	          'type' 	=> 'success', 
	          'title'  	=>  'Role Updated',
	          'msg' 	=>  __('modules.roles_update_success')
	          ]
	      	]);
	}	// public function delete(Request $request, $id)
	// {
	// 	$Role = Role::NotDeveloper()->findOrFail($id);

	// 	if ($Role->users()->count('id')) {
	// 		return response()->json(['message' => "Sorry users have this Role " . $Role->name], 422);
	// 	}

	// 	$Role->syncPermissions([]);
	// 	$Role->delete();
	// 	return response()->json(['success' => 'Role Deleted successfully']);
	// }

	/**
	 * Get permissions from centralized config
	 * 
	 * Returns permission structure with labels and dependencies
	 * from config/permission.php for role management UI
	 */
	private function getPermissions()
	{
		return config('permission.permissions', []);
	}

}
