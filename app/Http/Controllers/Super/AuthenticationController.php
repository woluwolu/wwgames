<?php
namespace App\Http\Controllers\Super;

use App\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator};
use App\Models\{Superadmin, TokenSuperadmin};

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Username' => 'required|string',
            'Password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::send(422, $validator->errors());
        }

        $admin = Superadmin::where('Username', $request->Username)->first();

        if (null === $admin) {
            return ApiResponse::message(ApiResponse::INVALID_USERNAME);
        }

        if (md5($request->Password) !== $admin->Password) {
            return ApiResponse::message(ApiResponse::INVALID_PASSWORD);
        }

        $checkToken = TokenSuperadmin::where('SuperadminUsername', $admin->Username)->first();

        if (null !== $checkToken) {
            $checkToken->forceDelete();
        }

        $token = new TokenSuperadmin();

        $token->ID = sha1(md5(time().$admin->Username));
        $token->SuperadminUsername = $admin->Username;

        $token->save();

        return ApiResponse::send(200, [
            'Token' => $token->ID,
            'Superadmin' => $admin,
        ]);
    }
}