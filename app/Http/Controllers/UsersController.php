<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use adLDAP\adLDAP;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function displayLogin(){
		// $adLDAP = new adLDAP();
		// $authUser = $adLDAP->authenticate('rhitgdjb','Louro345');

		// if($authUser){
		// 	echo "User is auth";
		// } else {
		// 	echo "User is not auth";
		// }

		return view('users.login');
	}

	public function loginAction(){
		$ad = \Config::get('app.ActiveDirectory');
		$adLDAP = new adLDAP($ad);
		$authUser = $adLDAP->authenticate(\Request::get('username'),\Request::get('password'));


		if($authUser){
			//Creds are good. See if they're in the right group
			if($result = $adLDAP->user()->ingroup(\Request::get('username'),'XSnapAdmins')){
				\Session::put('adauth',TRUE);
				return redirect('/');
			} else {
				return redirect('/login')->with('error','Your credentials were valid, but you are not in the XSnapAdmins group');
			}
			
		} else {
			return redirect('/login')->with('error','Your credentials are not valid. Please try again');
		}
	}


	public function logoutAction(){
		\Session::flush();
		return redirect('/login');
	}

}
