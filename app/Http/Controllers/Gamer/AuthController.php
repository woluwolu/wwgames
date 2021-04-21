<?php

namespace App\Http\Controllers\Gamer;

use App\Http\Controllers\Controller;
use App\Models\Gamer;
use App\Models\TokenGamer;
use App\Models\TokenGamerDeleted;
use App\Responses\ApiResponse;
use App\Utilities\TokenUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;

class AuthController extends Controller {


    public function register(Request $request) {
        $rules = [
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
            'Email' => 'required|email|unique:gamer,Email',
            'Username' => 'required|string',
            'Password' => 'required:PasswordConfirmation|string|confirmed|min:8'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return ApiResponse::send(422, $validator->errors());
        }

        $tokenVerify = TokenUtil::unique('gamer', 'EmailVerificationCode', 64);

        $gamer = new Gamer();
        $gamer->FirstName = $request->FirstName;
        $gamer->LastName = $request->LastName;
        $gamer->Email = $request->Email;
        $gamer->Username = $request->Username;
        $gamer->Password = Hash::make($request->Password);
        $gamer->save();

        $response = new stdClass;
        $response->ID = $gamer->ID;
        $response->Token = $tokenVerify;

        return ApiResponse::send(200, $response);
    }

    public function login(Request $request) {
        $rules = [
            'Email' => 'required|email',
            'Password' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ApiResponse::send(422, $validator->errors());
        }

        $gamer = Gamer::where('Email', $request->Email)->first();

        if ($gamer == null) {
            return ApiResponse::message(ApiResponse::UNKNOWN_RESOURCE);
        }

        if ($gamer->HasVerifiedEmail == null) {
            return ApiResponse::message(ApiResponse::EMAIL_UNVERIFIED);
        }

        if (!Hash::check($request->Password, $gamer->Password)) {
            return ApiResponse::send(401, null, ApiResponse::UNAUTHORIZED);
        }

        $tokenCheck = TokenGamer::where('GamerID', $gamer->ID)->first();
        $token = TokenUtil::unique('token_gamer', 'ID', 64);

        $detailToken = [
            'Token' => $token,
            'TokenType' => 'bearer'
        ];

        if (null !== $tokenCheck) {
            $tokenDeleted = new TokenGamerDeleted();
            $tokenDeleted->DeletedTimestamp = time();
            $tokenDeleted->TokenID = $tokenCheck->ID;
            $tokenDeleted->GamerID = $tokenCheck->GamerID;
            $tokenDeleted->DeviceType = $tokenCheck->DeviceType;
            $tokenDeleted->CreatedAt = $tokenCheck->CreatedAt;
            $tokenDeleted->save();

            $tokenCheck->forceDelete();
        }

        $tokenGamer = new TokenGamer();
        $tokenGamer->ID = $token;
        $tokenGamer->GamerID = $gamer->ID;
        $tokenGamer->DeviceType = $request->header('devicetype');
        $tokenGamer->CreatedAt = time();
        $tokenGamer->save();

        return ApiResponse::send(200, $detailToken);
    }

    public function logout(Request $request)
    {
        TokenGamer::where('GamerID', auth()->user()->ID)->forceDelete();

        return ApiResponse::send(200);
    }
}