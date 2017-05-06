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

    public function authenticateToken()
    {
        return \JWTAuth::parseToken()->authenticate() != false;
    }

    public function getUserFromToken()
    {
        return \JWTAuth::parseToken()->authenticate();
    }

    public function index(Request $request)
    {
        if(\JWTAuth::getToken() && $this->getUserFromToken()->user_types_id != 3){
    
            $statusCode = 200;
            $response = [
                'users'  => []
            ];

            if(empty($request->referer_id))
            {
                if($this->getUserFromToken()->user_types_id == 1){
                    $users = \App\User::with('page')->with('user_type')->get();
                    foreach($users as $user){

                        $response['users'][] = [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'dolares' => $user->dolares,
                            'user_type' => $user->user_type->type,
                            'page' => $user->page->name,
                            'referer_id' => $user->referer_id
                        ];
                    }
                }
                else{
                    $statusCode = 403;
                    $response = [
                        'error'  => "Sin autorizacion"
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
                        'dolares' => $user->dolares,
                        'user_types_id' => $user->user_types_id,
                        'pages_id' => $user->pages_id
                    ];
                }
            }
        }
        else{
            $statusCode = 403;
            $response = [
                'error'  => "Sin autorizacion"
            ];
        }

        return \Response::json($response, $statusCode);
    }

    public function bloggerStore(Request $request){
        $user = new \App\User;

        if(
            \JWTAuth::getToken() && 
            $this->getUserFromToken()->user_types_id == 1 &&
            !empty($request->password) && 
            !empty($request->name) && 
            !empty($request->email))
        {
            $statusCode = 201;
            $response = [
                'respuesta'  =>  "Creado usuario con exito"
            ];

            $users = \App\User::all()
                ->where('email',$request->email)
                ->where('pages_id','1');

            if(empty($users->first())){
                $user->email = filter_var($request->email, FILTER_VALIDATE_EMAIL);
                if($user->email != false)
                {
                  $user->name = $request->name;
                  if(!empty($request->referer_id)){$user->referer_id = $request->referer_id;}
                  $user->password = \Hash::make($request->password);
                  $user->dolares = 0;
                  $user->user_types_id = 2;
                  $user->pages_id = 1;
                  $user->save();
                }
                else{
                  $statusCode = 400;
                $response = [
                    'error'  =>  "Correo invalido"
                ];
                }
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
                'error'  =>  "Faltaron Datos o privilegios"
            ];
        }

        return \Response::json($response, $statusCode);
    }

    public function adminStore(Request $request){
        $user = new \App\User;

        if(
            \JWTAuth::getToken() && 
            $this->getUserFromToken()->user_types_id == 1 &&
            !empty($request->password) && 
            !empty($request->name) && 
            !empty($request->email) &&
            !empty($request->user_types_id) &&
            !empty($request->dolares)
            )
        {
            $statusCode = 201;
            $response = [
                'respuesta'  =>  "Creado usuario con exito"
            ];

            $users = \App\User::all()
                ->where('email',$request->email)
                ->where('pages_id','1');

            if(empty($users->first())){
                $user->email = filter_var($request->email, FILTER_VALIDATE_EMAIL);
                if($user->email != false)
                {
                  $user->name = $request->name;
                  if(!empty($request->referer_id)){$user->referer_id = $request->referer_id;}
                  $user->password = \Hash::make($request->password);
                  $user->dolares = $request->dolares;
                  $user->user_types_id = $request->user_types_id;
                  $user->pages_id = 1;
                  $user->save();
                }
                else{
                  $statusCode = 400;
                $response = [
                    'error'  =>  "Correo invalido"
                ];
                }
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
                'error'  =>  "Faltaron Datos o privilegios"
            ];
        }

        return \Response::json($response, $statusCode);
    }

    public function facebookStore(Request $request)
    {
        $user = new \App\User;

        if(
            !empty($request->name) && 
            !empty($request->email))
        {
            $statusCode = 201;
            $response = [
                'respuesta'  =>  "Creado usuario con exito"
            ];

            $users = \App\User::all()
                ->where('email',$request->email)
                ->where('pages_id','2');

            if(empty($users->first())){
                $user->email = filter_var($request->email, FILTER_VALIDATE_EMAIL);
                if($user->email != false)
                {
                  $user->name = $request->name;
                  if(!empty($request->referer_id)){$user->referer_id = $request->referer_id;}
                  $user->dolares = 0;
                  $user->user_types_id = 3;
                  $user->pages_id = 2;
                  $user->save();
                }
                else{
                  $statusCode = 400;
                $response = [
                    'error'  =>  "Correo invalido"
                ];
                }
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


    public function gmailStore(Request $request)
    {
        $user = new \App\User;

        if(
            !empty($request->name) && 
            !empty($request->email))
        {
            $statusCode = 201;
            $response = [
                'respuesta'  =>  "Creado usuario con exito"
            ];

            $users = \App\User::all()
                ->where('email',$request->email)
                ->where('pages_id','3');

            if(empty($users->first())){
                $user->email = filter_var($request->email, FILTER_VALIDATE_EMAIL);
                if($user->email != false)
                {
                  $user->name = $request->name;
                  if(!empty($request->referer_id)){$user->referer_id = $request->referer_id;}
                  $user->dolares = 0;
                  $user->user_types_id = 3;
                  $user->pages_id = 3;
                  $user->save();
                }
                else{
                  $statusCode = 400;
                $response = [
                    'error'  =>  "Correo invalido"
                ];
                }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new \App\User;

        if(
            !empty($request->password) && 
            !empty($request->name) && 
            !empty($request->email))
        {
            $statusCode = 201;
            $response = [
                'respuesta'  =>  "Creado usuario con exito"
            ];

            $users = \App\User::all()
                ->where('email',$request->email)
                ->where('pages_id','1');

            if(empty($users->first())){
                $user->email = filter_var($request->email, FILTER_VALIDATE_EMAIL);
                if($user->email != false)
                {
                  $user->name = $request->name;
                  if(!empty($request->referer_id)){$user->referer_id = $request->referer_id;}
                  $user->password = \Hash::make($request->password);
                  $user->dolares = 0;
                  $user->user_types_id = 3;
                  $user->pages_id = 1;
                  $user->save();
                }
                else{
                  $statusCode = 400;
                $response = [
                    'error'  =>  "Correo invalido"
                ];
                }
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
        if(\JWTAuth::getToken() && $this->authenticateToken()){
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
                    'dolares' => $user->dolares,
                    'user_types_id' => $user->user_types_id,
                    'pages_id' => $user->pages_id,
                    'referer_id' => $user->referer_id
                ];
            }
        }
        else{
            $response = [
                "error" => "Sin Autorizacion"
            ];
            $statusCode = 403;

        }
        return \Response::json($response, $statusCode);
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
        if(\JWTAuth::getToken() && 
            $this->getUserFromToken()->user_types_id == 1 &&
            !empty($request->id)){
            $response = [
                "respuesta" => "Actualizado con exito"
            ];
            $statusCode = 200;
            $user = App\User::find($request->id);

            if(!empty($request->name)){$user->name = $request->name;}
            if(!empty($request->email)){$user->email = $request->email;}
            if(!empty($request->dolares)){$user->dolares = $request->dolares;}
            if(!empty($request->user_types_id)){$user->user_types_id = $request->user_types_id;}
            if(!empty($request->password)){$user->password = $request->password;}
            $user->save();
        }
        else{
            $response = [
                "error" => "Sin Autorizacion"
            ];
            $statusCode = 403;
        }
        return \Response::json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\JWTAuth::getToken() && $this->getUserFromToken()->user_types_id == 1){
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
        else{
            $response = [
                "error" => "Sin Autorizacion"
            ];
            $statusCode = 403;
        }

        return \Response::json($response, $statusCode);
        
    }
}
