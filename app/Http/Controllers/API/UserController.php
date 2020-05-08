<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Validator;

use App\User; 
use App\Http\Resources\Farmer as FarmerResource; 
use App\Http\Resources\User as UserResource; 
use App\Http\Resources\VegetableList as VegetableListResource; 

class UserController extends Controller 
{
    public $successStatus = 200;

    /**
     * Get All Users
     * 
     */
    public function index(){
        return UserResource::collection(User::paginate());
    }
    /**
     * Get All Users
     * 
     */
    public function store(Request $request){
      try{

        $request->validate([
          "name" => "required",
          "address" => "required",
          "lat" => "required",
          "long" => "required",
          "phoneNo" => "required",
          "whatsappNo" => "required",
        ]);
        $request['password'] = bcrypt($request->password); 
        $user = User::create($request->all());
        
        return response()->json(["message"=>"Successfully Create User"], 200); 
      }catch(\Exception $e){
          return response()->json(["message"=>$e->getMessage()], 200); 
      }
    }

    /**
     * 
     * 
     */
    public function show($id){
        $user = User::findOrFail($id);
        $vegeList = VegetableListResource::collection($user->vegetables);
        return response()->json(["user"=>$user, "vegeList"=>$vegeList], 200); 
    }


    /**
     * Get All Users
     * 
     */
    public function update(Request $request, $id){
      try{

        $request->validate([
          "name" => "required",
          "address" => "required",
          "lat" => "required",
          "long" => "required",
          "phoneNo" => "required",
          "whatsappNo" => "required",
        ]);
            
        $user = User::findOrFail($id);
        unset($request->password);
        $user->update($request->all());
        
        return response()->json(["message"=>"Successfully Update User"], 200); 
      }catch(\Exception $e){
          return response()->json(["message"=>$e->getMessage()], 200); 
      }
    }
    /**
     * Get All Users
     * 
     */
    public function destroy($id){
      try{
 
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json(["message"=>"Successfully Delete User"], 200); 
      }catch(\Exception $e){
          return response()->json(["message"=>$e->getMessage()], 200); 
      }
    }



    


    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['phoneNo' => request('phoneNo'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            // dd($user->createToken('MyApp'));
            $data = [
                'grant_type' => 'password',
                'client_id' => env('CLIENT_ID', ''),
                'client_secret' => env('CLIENT_SECRET', ''),
                'username' => request('phoneNo'),
                'password' => request('password'),
            ];
        
            $requests = Request::create('/oauth/token', 'POST', $data);
            $responses = app()->handle($requests);
            $rData = json_decode($responses->getContent());
            return response()->json([
                "status"=>0,
                "auth"=> $rData->access_token,
                "refresh"=> $rData->refresh_token,
            ], $this->successStatus); 
        } 
        else{ 
            return response()->json(['status'=>1], 401); 
        } 
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'address' => 'required', 
            'lat' => 'required', 
            'long' => 'required', 
            'phoneNo' => 'required|unique:users', 
            'whatsappNo' => 'required', 
            'role' => 'required', 
            'password' => 'required',
        ]);

        if ($validator->fails()) { 
            $errors = $validator->errors();
            if ($errors->has('phoneNo')) {
                return response()->json(['status'=>1,"message"=>"Phone no already exists"], 401); 
            }
            return response()->json(['status'=>1,'message'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 

        $user = User::create($input); 
        
        // $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        // $success['name'] =  $user->name;

    return response()->json(["status"=> 0, "message"=> "success"], 200); 

    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this->successStatus); 
    } 

    /** 
     * Get User in Given Phone Number
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getUser(Request $request) 
    { 
        $phoneNo = $request->phoneNo;

        $user = User::where('phoneNo',$phoneNo)->first(); 

        return response()->json(new FarmerResource($user), $this->successStatus); 
    } 

    /** 
     * Register Farmers
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function farmerRegister(Request $request)
    { 
        $request->validate([ 
            'name' => 'required', 
            'address' => 'required', 
            'lat' => 'required', 
            'long' => 'required', 
            'phoneNo' => 'required|unique:users', 
            'whatsappNo' => 'required',
        ]);

        $request['password'] = bcrypt('password'); 
        $request['role'] = 3; 
        $user = new FarmerResource(User::create($request->all()));

        return response()->json($user, $this->successStatus); 
    } 

     /**
   * Get all the Item with Pagination
   * @method GET
   */
  public function searchFarmer(Request $request)
  {
    try {
      $queryVal = $request->searchquery;
      $user = User::where('role',3)->where('name','like','%'.$queryVal.'%')->paginate();

      return UserResource::collection($user);
    } catch (\Exception $e) {
      return response()->json(["message" => $e->getMessage()], 200);
    }
  }

}