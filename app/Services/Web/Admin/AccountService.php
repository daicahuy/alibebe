<?php

namespace App\Services\Web\Admin;

use App\Http\Requests\UpdateAccountProviderRequest;
use App\Models\User;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AccountService
{
    protected $accountRepository;
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }
    public function updateProvider(UpdateAccountProviderRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::find(Auth::id());
            // dd($old_avatar);

            if(!empty($data['avatar'])){
                $data['avatar'] = Storage::put('users',$data['avatar']);
            }
            if(!empty($user->avatar) && !empty($data['avatar']) && Storage::exists($user->avatar)){
                Storage::delete($user->avatar);
            }
            else {
                // Nếu không có ảnh mới, giữ nguyên ảnh cũ
                $data['avatar'] = $user->avatar;
            }
            $this->accountRepository->update(Auth::id(),$data);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
        }
    }
}   
