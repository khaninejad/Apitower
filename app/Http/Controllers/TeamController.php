<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Redirect;
use Validator;
use Hash;
class TeamController extends Controller {

        public function __construct()
		{
			$this->middleware('auth');
		}
        public function index()
        {
              $users = User::all();
		// print_r($domains);
		 //die("err");
		return view('team.index',['title'=>'Team','team'=>$users]);   
        }


        public function edit($id)
        {
         	$user = User::find($id);
		return view('team.edit',['title'=>'Edit User','user'=>$user]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @return Response
         */
        public function update($id,Request $request)
        {
			  $validator = Validator::make($request->all(), [
           			'name' => 'required|max:255',
					'email' => 'required|email|max:255|unique:users,email,'.$id.'',
					'password' => 'confirmed|min:6'
			]);
	
			if ($validator->fails()) {
				return redirect('team/edit/'.$id)
							->withErrors($validator)
							->withInput();
			}else{
				$user = User::find($id);
				 $user->name = $request->input('name');	
				 $user->email = $request->input('email');
				if(strlen($request->input('password'))>0){
					 $user->password = Hash::make($request->input('password'));	
				 }
				 $user->save();
				 return Redirect::to('team')->with('message', 'User Updated!');  
			}
	
				  
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function destroy($id)
        {
               if(Auth::user()->id==$id){
				    return Redirect::to('team')->with('error','Sorry, you can\'t delete yourself');
			   }else{
					$user = User::find($id);

					$user->delete();
					return Redirect::to('team')->with('message', 'User Deleted!');  
			   }
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
}