<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountPasswordRequest;
use App\Models\User;
use App\Services\Web\Admin\AccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    protected $accountService;
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }
    public function index(){
        $user = Auth::user();
        return view('admin.pages.user_Account.detail',compact('user'));
    }

    public function updatePassword(UpdateAccountPasswordRequest $request)
    {
        $request->validated();
        
        $user = User::find(Auth::id());
    
        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }
    
        // Kiểm tra thủ công mật khẩu mới và mật khẩu xác nhận
        if ($request->new_password !== $request->password_confirmation) {
            return back()->withErrors(['password_confirmation' => 'Xác nhận mật khẩu không khớp.']);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return back()->with('success', 'Mật khẩu đã được cập nhật thành công!');
    }
    
    
}
