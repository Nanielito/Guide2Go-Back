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
                $users = \App\User::all()->where('referer_id',$request->referer_id);
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
        $user = new \App\User;

        if(
            !empty($request->user_types_id) && 
            !empty($request->pages_id) && 
            !empty($request->name) && 
            !empty($request->email))
        {
            $statusCode = 201;
            $response = [
                'respuesta'  =>  "Creado usuario con exito"
            ];

            $users = \App\User::all()
                ->where('email',$request->email)
                ->where('pages_id',$request->pages_id);

            if(empty($users->first())){
                $user->user_types_id = $request->user_types_id;
                $user->pages_id = $request->pages_id;
                $user->name = $request->name;
                $user->email = $request->email;
                if(!empty($request->referer_id)){$user->referer_id = $request->referer_id;}
                if(!empty($request->password)){$user->password = \Hash::make($request->password);}
                $user->dolares = 0;
                $user->save();
            }
            else{
                $statusCode = 400;
                $response = [
                    'error'  =>  "Ese Correo ya existe con la misma pagina"
                ];
            }
        }
        else{
            $statusCode = 400;
            $response = [
                'error'  =>  "Faltaron Datos"
            ];
        }

        return \Response::json($response, $statusCode);
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
