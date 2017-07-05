<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Photo;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar el token
                // Validar si la parada existe
                // etc
                $params = [
                        'spot' => $request->spot
                ];

                // Sube el photo
                $file = $request->photo;

                if (!$file->isValid()) {
                        $response = [ 'error' => "Archivo no valido" ];
                        return \Response::json($response, 400);
                        // Bad request?
                }

                // Guarda la photo en el sistema de archivos
                $params['path'] = $file->store('photos');

                // Termina de crear el audio en la base de datos
                $photo = Photo::store($params);

                $response = $photo->jsonSerialize();
                return \Response::json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function paradaShow($id)
    {
                // Verifica el token y si el usuario
                // puede descargar ese audio

                // Busca el photo en la base de datos, esto hay q cambiarlo
                $file = Photo::all()->where('parada_id',$id)->first();

                if (!$file) {
                        $response = [ 'error' => "no Se encontro Foto" ];
                        return \Response::json($response, 400);
                        // Bad request?
                }

                $path = $file->path;

                // descarga el photo...
                return \Response::json($path,200);
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
