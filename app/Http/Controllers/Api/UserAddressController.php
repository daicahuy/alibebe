<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;


class UserAddressController extends Controller
{
    public function listAddress($id)
    {


        try {
            $listAddressByUser = UserAddress::query()->with('user')->where('user_id', $id)->orderBy('is_default', 'desc')->get();

            return response()->json(['status' => Response::HTTP_OK, 'dataAddress' => $listAddressByUser]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }


    }

    public function addAddressUser(Request $request)
    {
        try {
            $data = $request->all();
            $rules = [
                'fullname' => ['required', 'string', 'max:100'],
                'phone_number' => ['required', 'string', 'max:20', 'regex:/^0\d{9,10}$/'],
                'address' => ['required', 'string', 'max:255']

                // 'terms_and_privacy' => 'required|boolean',
            ];

            $messages = [
                'phone_number.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam.',
                'fullname.required' => 'Vui lòng nhập họ tên.',
                'address.required' => 'Vui lòng nhập địa chỉ',
                'phone_number.required' => 'Vui lòng nhập số điện thoại.',
                'fullname.string' => 'Họ tên phải là chuỗi ký tự.',
                'fullname.max' => 'Họ tên không được vượt quá 100 ký tự.',
                'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
                'phone_number.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            ];


            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            } else {
                DB::transaction(function () use ($data) {
                    if ($data["is_default"] == 1) {
                        UserAddress::query()->where("is_default", 1)->update(["is_default" => 0]);
                    }

                    UserAddress::query()->create($data);
                });
                // UserAddress::query()->create($data);

                return response()->json(['status' => Response::HTTP_OK, 'data' => $data]);
            }




        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function getDataAddress($id)
    {
        $dataAddress = UserAddress::query()->where("id", $id)->first();

        return response()->json(['status' => Response::HTTP_OK, 'dataEditAddress' => $dataAddress]);
    }

    public function getDataAddressOne($id)
    {
        $dataAddressOne = UserAddress::query()->where("user_id", $id)->where('is_default', 1)->first();

        return response()->json(['status' => Response::HTTP_OK, 'dataAddressOne' => $dataAddressOne]);
    }

    public function updateAddressUser(Request $request)
    {
        try {
            $data = $request->all();
            $rules = [
                'fullname' => ['required', 'string', 'max:100'],
                'phone_number' => ['required', 'string', 'max:20', 'regex:/^0\d{9,10}$/'],
                'address' => ['required', 'string', 'max:255']

                // 'terms_and_privacy' => 'required|boolean',
            ];

            $messages = [
                'phone_number.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam.',
                'fullname.required' => 'Vui lòng nhập họ tên.',
                'address.required' => 'Vui lòng nhập địa chỉ',
                'phone_number.required' => 'Vui lòng nhập số điện thoại.',
                'fullname.string' => 'Họ tên phải là chuỗi ký tự.',
                'fullname.max' => 'Họ tên không được vượt quá 100 ký tự.',
                'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
                'phone_number.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            ];


            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            } else {
                DB::transaction(function () use ($data) {
                    if ($data["is_default"] == 1) {
                        UserAddress::query()->where("is_default", 1)->update(["is_default" => 0]);
                    }

                    UserAddress::query()->where("id", $data["idAddress"])->update(["phone_number" => $data["phone_number"], "fullname" => $data["fullname"], "address" => $data["address"], "is_default" => $data["is_default"]]);
                });
                // UserAddress::query()->create($data);

                return response()->json(['status' => Response::HTTP_OK, 'data' => $data]);
            }




        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }


}
