<?php

namespace App\Http\Controllers\Food;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreTokenUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdatePasswordUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Traits\FirebaseTrait;
use Brian2694\Toastr\Facades\Toastr;

class UserController extends Controller
{
    use FirebaseTrait;

    protected $userRepo;
    protected $roleRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        // $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        // dd($fb_users);
        $users = $this->userRepo->getAll();
        // $roles = $this->roleRepo->getAll();
        return view('user.index', compact('users'));
    }

    public function add($id)
    {
        try{
            $user = $this->userRepo->get($id);
            // $roles = $this->roleRepo->getAll();
            return view('user.edite',compact('user'));

        }catch(\Exception $e){
            Log::info($e);
            Toastr::error($e->getMessage());
            return back();
        }
    }
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try{
            $this->userRepo->store($request);
            DB::commit();
            return back();

        }catch(\Exception $e){
            Log::info($e);
            DB::rollback();
            Toastr::error($e->getMessage());
            return back();
        }
    }
    public function edite($id)
    {
        try{
            $user = $this->userRepo->get($id);
            $roles = $this->roleRepo->getAll();
            return view('user.edite',compact('user', 'roles'));

        }catch(\Exception $e){
            Log::info($e);
            Toastr::error($e->getMessage());
            return back();
        }
    }
    public function update(UpdateUserRequest $request, $id)
    {
        // dd($request);
        DB::beginTransaction();
        try{
            $this->userRepo->update($request, $id);
            DB::commit();
            Toastr::success(__("success update user"));
            return redirect()->route('users');

        }catch(\Exception $e){
            Log::info($e);
            DB::rollback();
            Toastr::error($e->getMessage());
            return back();
        }
    }
    public function updatePwd(UpdatePasswordUserRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $this->userRepo->updatePwd($request, $id);
            DB::commit();
            Toastr::success(__("success update password"));
            return redirect()->route('users');

        }catch(\Exception $e){
            Log::info($e);
            DB::rollback();
            Toastr::error($e->getMessage());
            return back();
        }
    }

    public function setOnline(Request $request)
    {

    }
    public function setOffline(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $this->userRepo->destroy($request->user_id);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => __('success delete user')]);

        }catch(\Exception $e){
            Log::info($e);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function storeToken(StoreTokenUserRequest $request)
    {
        DB::beginTransaction();
        try{
            $this->userRepo->storeToken($request);
            DB::commit();
            return response()->json(['status' => 'success']);

        }catch(\Exception $e){
            Log::info($e);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

        }
    }
}
