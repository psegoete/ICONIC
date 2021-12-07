<?php

namespace CreatyDev\Http\api;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\UserDevice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('jwt.verify', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);


        // return response()->json(request('email'));
        if(request('role') == "admin"){
            if (!$token = auth('api')->attempt(['email' => request('email'), 'password' => request('password'), 'role' => 'admin', 'company_id' => 1])) {
    
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }else{
            
            if (!$token = auth('api')->attempt(['email' => request('email'), 'password' => request('password'), 'role' => 'customer', 'company_id' => 1])) {
    
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        $device = UserDevice::where([['company_id', '=', 1], ['device_id', '=', request('device_id')]])->first();

        $user = User::where([['company_id', '=', 1], ['email', '=', request('email')]])->first();

        if ($device) {
            if ($device->user_id == $user->id) {
            } else {
                $device->user_id = $user->id;
                $device->save();
            }
        } else {
            $device = new UserDevice([
                'device_id' => request('device_id'),
                'user_id' => $user->id,
                'company_id' => 1,
            ]);

            $device->save();
        }

        // $pushData['message'] = array
        //       (
        //     'body' => 'Hi',
        //     'title'=> 'Pushed Device',
        //     'icon'  => 'myicon',/*Default Icon*/
        //     'sound' => 'mySound'/*Default sound*/
        //       );

        // $fields = array(
        //     'to' => 'ciIMu0WYSKK6OkaVF8yVGl:APA91bF-RWAatlJ0twZpbGdo3Ebpb5RVJ9l923XOIVyOSA7KbOPham2RHqrw0XFzFKONxT8FX6iD3voVTMZhdoej4exQrXy1i71ONcBmMCbXGkMbNHITl-NX370Bg9cEBnlRW4JTjXRD',
        //     'notification' => array(
        //         'body' => 'Hi',
        //         'title' => 'Pushed Device',
        //         'icon'  => 'myicon',/*Default Icon*/
        //         'sound' => 'mySound'/*Default sound*/
        //     )
        // );


        // $headers = array(
        //     'Authorization: key=' . 'AAAAYmXd74U:APA91bEqPL0LXy2ida9tbYPg_WsDbkaBUZQ5hBsk_U5pbemFld7QmwBhxkSJuN34Th-D6z8Oq9Rr_rv6IYXREf3hogWeRURnW2zriPnwgaa3NRp7OYCrjjQdf2YK9uu3WPnjzV50M_cb',
        //     'Content-Type: application/json'
        // );

        // #Send Reponse To FireBase Server    
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // $result = curl_exec($ch);
        // curl_close($ch);
        // return $result;

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'ticket_display_name' => 'required',
        ]);

        if ($validate->errors()->count() > 0) {
            return response()->json(['errors' => $request]);
        }


        $user = User::findOrFail(auth('api')->user()->id);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->ticket_display_name = $request->input('ticket_display_name');

        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->file('profile_image')) {
            $name = $request->file('profile_image')->hashName();
            \Image::make($request->file('profile_image'))->save('img/' . $name);
            $user->profile_image = $name;

            $userPhoto = 'img/' . auth('api')->user()->profile_image();
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }

        $user->save();

        return response()->json(['success' => 'Successfully updated']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth('api')->factory()->getTTL() * 1440
        ]);
    }
}
