<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    // Añadir token para impedir bielorusos

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $statusCode = 200;
            $response = [
              'users'  => []
            ];

            if(empty($request->referer_id))
            {
                $users = \App\User::all();
                foreach($users as $user){

                    $response['users'][] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'monedas' => $user->monedas,
                        'user_types_id' => $user->user_types_id,
                        'pages_id' => $user->pages_id,
                        'referer_id' => $user->referer_id
                    ];
                }
            }
            else
            {
                $users = \App\User::where('referer_id',$request->referer_id);
                foreach($users as $user){

                    $response['users'][] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'monedas' => $user->monedas,
                        'user_types_id' => $user->user_types_id,
                        'pages_id' => $user->pages_id,
                        'referer_id' => $user->referer_id
                    ];
                }
            }
        }
        catch (Exception $e){
            $statusCode = 400;
            $response = [
              'error'  => "Algo paso"
            ];
        }
        finally{
            return \Response::json($response, $statusCode);
        }
       
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         try {
            $statusCode = 200;
            $response = [
              'users'  => []
            ];

            $user = \App\User::find($id);

            if(empty($user))
            {
                 $response = [
                    "error" => "Usuario no existe"
                ];
                $statusCode = 404;
            }
            else{
                $response['users'][] = [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'monedas' => $user->monedas,
                            'user_types_id' => $user->user_types_id,
                            'pages_id' => $user->pages_id,
                            'referer_id' => $user->referer_id
                        ];
            }

        }
        catch(Exception $e) {
            $statusCode = 400;
            $response = [
              'error'  => "Algo paso"
            ];
        }
        finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $statusCode = 200;
            $response = [
              'users'  => "deleted"
            ];

            $user = \App\User::find($id);

            if(empty($user))
            {
                 $response = [
                    "error" => "Usuario no existe"
                ];
                $statusCode = 404;
            }
            else{
                \App\User::destroy($id);
            }

        }
        catch(Exception $e) {
            $statusCode = 400;
            $response = [
              'error'  => "no se pudo borrar"
            ];
        }
        finally {
            return \Response::json($response, $statusCode);
        }
    }
}
