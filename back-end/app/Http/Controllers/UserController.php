<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        return User:: latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateUser(Request $request)
    {
        $request->validate([
            'username' =>  'required|max:50|regex:/^[a-zA-Z]/',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            // 'profile'=>'nullable|image|mimes:jpg,jpeg,png|max:1999',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('myToken')->plainTextToken; 

        return response()->json([
            'message' => "created successfully!",
            'user' => $user,
            'token' => $token
            ],201);
       
    }

    public function Login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        $token = $user->createToken('myToken')->plainTextToken; 
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json([
            'message' => "Login seccessfully",
            'user' => $user,
            'token' => $token
            ]);
    }
    public function Logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User logout success']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' =>  'required|max:50|regex:/^[a-zA-Z]/',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            // 'profile'=>'nullable|image|mimes:jpg,jpeg,png|max:1999',
        ]);
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return response()->json(['message' => "updated successfully!" , "user" => $user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $isDeleted = User::destroy($id);

        if($isDeleted == 1) {
            return response()->json(['message' => 'Deleted successfully'], 200);
        }else{
            return response()->json(['message' => 'ID NOT FOUND'], 404);
        }
    }


     // ==================Search book==================
     public function search($username)
     {   
         return User::where('username','like','%'.$username. '%')->get();
     }

}
