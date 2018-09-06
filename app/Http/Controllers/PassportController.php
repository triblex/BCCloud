<?php
 
namespace App\Http\Controllers;
 
use App\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
 
class PassportController extends Controller
{
    
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('Test')->accessToken;

        return response()->json(['token' => $token], 200);
    }
    */
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('name')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
    */
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /*
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
    */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
 
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
 
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
 
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
 
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], 200);
    }
 
 
    public function details()
    {
        $users = User::get();
        return response()->json(['success' => $users], 200);
    }
}

