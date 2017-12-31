<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Helpers\JWTHelper;
use \App\Guia;
use \App\User;

class GuideController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		// Retorna un usuario del token
		// si existe
		$fromUser = JWTHelper::authenticate();
		if (!$fromUser) {
			$response = [ 'error' => "No se encontro token" ];
			return \Response::json($response, 403);
		}

		// Obtiene un usuario del request
		$userId = $request->self;

		if (empty($userId)) {
			$response = [
				'guides'  => []
			]; 
			$guias = Guia::all();
			foreach($guias as $guide){
				$zonaNombre= \App\Zona::find($guide->zonas_id)->name;				
				$idioma = \App\Idioma::find($guide->idiomas_id)->name;
				$response['guides'][] = [
					'id' => $guide->id,
					'name' => $zonaNombre,
					'costo' => $guide->costo,
					'idioma' => $idioma,
					'zonas_id' => $guide->zonas_id,
					'idiomas_id' => $guide->idiomas_id
				];
			}

			return $response;
		}

		// Verifica que el usuario que hace el 
		// request puede ver las guias 
		/*if ($fromUser->id != $userId && 
			$fromUser->user_types_id != 1 ) { // Admin 

			$response = [ 'error' => "No autorizado" ];
			return \Response::json($response, 403);
		}*/

		// Trae las guias del usuario

		$userGuides = User::where('id',$fromUser->id)->getRelation('guias')->where('user_id',$fromUser->id)->with('zona')->get();

		return $userGuides;
	}

	/**
	 * Shows the form for creating a new "Guia" resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Stores a newly created "Guia" resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
     *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$parameters = [
			'zone'        => $request->zone,
			'lang'        => $request->lang,
            'name'        => $request->name,
            'description' => $request->description,
			'cost'        => $request->cost,
		];

		$guide = Guia::createGuia($parameters);

		if (isset($guide)) {
            $response = $guide->jsonSerialize();
            $statusCode = 200;
        }
        else {
		    $response = [
		        "error" => "Ha ocurrido un error al crear la guia"
            ];
		    $statusCode = 500;
        }

		return \Response::json($response, $statusCode);
	}

	/**
	 * Displays the specified "Guia" resource.
	 *
	 * @param int $id
     *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

    /**
     * Gets all "Guia" resources.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getGuides(Request $request) {
        $response = [];
        $language = $request->input("language");
        $zone = $request->input("zone");

        try {
            $fromUser = JWTHelper::authenticate();

            if (isset($fromUser)) {
            	if (isset($language) && !isset($zone)) {
            		$guides = \App\Guia::where("idiomas_id", $language)->get();
				}
				elseif (!isset($language) && isset($zone)) {
                    $guides = \App\Guia::where("zonas_id", $zone)->get();
				}
				elseif (isset($language) && isset($zone)) {
                    $guides = \App\Guia::whereRaw("idiomas_id = $language AND zonas_id = $zone")->get();
				}
				else {
                    $guides = \App\Guia::all();
				}

                foreach ($guides as $guide) {
                    $zone = \App\Zona::find($guide->zonas_id);
                    $language = \App\Idioma::find($guide->idiomas_id);

                    $response[] = [
                        "id" => $guide->id,
                        "nombre" => $guide->nombre,
                        "descripcion" => $guide->descripcion,
                        "costo" => $guide->costo,
                        "idioma" => [
                        	"id" => $language->id,
                        	"name" => $language->name
						],
                        "zona" => [
                        	"id" => $zone->id,
							"name" => $zone->name
						]
                    ];
                }

                $statusCode = 200;
            }
            else {
                $response = [
                    "error" => "Not Authorized"
                ];
                $statusCode = 401;
            }
        }
        catch (\Exception $ex) {
            $response = [
                "error" => $ex->getMessage()
            ];
            $statusCode = 500;
        }

        return \Response::json($response, $statusCode);
    }

    /**
     * Gets "Guia" resources by position.
     *
     * @param \Illuminate\Http\Request $request
     * @param float $latitude
     * @param float $longitude
     * @param float $radius
     *
     * @return \Illuminate\Http\Response
     */
    public function getGuidesByPosition(Request $request, $latitude, $longitude, $radius) {
		$response = [];
        $language = $request->input("language");

        try {
            $fromUser = JWTHelper::authenticate();

            if (isset($fromUser)) {
                $zones = \App\Zona::all()->filter(function ($zone) use ($latitude, $longitude, $radius) {
                    $region = $zone["poligono"];
                	return \App\Helpers\Geometry::isLocationNear($region, \App\Helpers\Geometry::createPoint($latitude, $longitude), $radius);
				});

                $zoneIds = $zones->reduce(function ($accumulator, $zone) {
                	$accumulator[] = $zone->id;
                	return $accumulator;
				}, []);

                if (count($zoneIds) > 0) {
                    $stringIds = implode(",", $zoneIds);

                    if (isset($language)) {
                        $guides = \App\Guia::whereRaw("idiomas_id = $language AND zonas_id IN ($stringIds)")->get();
                    }
                    else {
                        $guides = \App\Guia::whereRaw("zonas_id IN ($stringIds)")->get();
                    }

                    foreach ($guides as $guide) {
                        $zone = $zones->find($guide->zonas_id);
                        $language = \App\Idioma::find($guide->idiomas_id);

                        $response[] = [
                            "id" => $guide->id,
                            "nombre" => $guide->nombre,
                            "descripcion" => $guide->descripcion,
                            "costo" => $guide->costo,
                            "idioma" => [
                                "id" => $language->id,
                                "name" => $language->name
                            ],
                            "zona" => [
                                "id" => $zone->id,
                                "name" => $zone->name
                            ]
                        ];
                    }
                }

                $statusCode = 200;
            }
            else {
                $response = [
                    "error" => "Not Authorized"
                ];
                $statusCode = 401;
            }
        }
        catch (\Exception $ex) {
            $response = [
                "error" => $ex->getMessage()
            ];
            $statusCode = 500;
        }

		return \Response::json($response, $statusCode);
    }

    /**
     * Gets the specified "Guia" resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getGuide(Request $request, $id) {
        $response = [];

        try {
            $fromUser = JWTHelper::authenticate();

            if (isset($fromUser)) {
                $guide = \App\Guia::find($id);
                $zone = \App\Zona::find($guide->zonas_id);
                $language = \App\Idioma::find($guide->idiomas_id);

				$response = [
					"id" => $guide->id,
					"nombre" => $guide->nombre,
					"descripcion" => $guide->descripcion,
					"costo" => $guide->costo,
					"idioma" => [
						"id" => $language->id,
						"name" => $language->name
					],
					"zona" => [
						"id" => $zone->id,
						"name" => $zone->name
					]
				];

                $statusCode = 200;
            }
            else {
                $response = [
                    "error" => "Not Authorized"
                ];
                $statusCode = 401;
            }
        }
        catch (\Exception $ex) {
            $response = [
                "error" => $ex->getMessage()
            ];
            $statusCode = 500;
        }

    	return \Response::json($response, $statusCode);
    }

	/**
	 * Shows the form for editing the specified "Guia" resource.
	 *
	 * @param int $id
     *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Updates the specified "Guia" resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int  $id
     *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		if (\JWTAuth::getToken()) {
			$parameters = [
                'zone'        => $request->zone,
                'lang'        => $request->lang,
                'name'        => $request->name,
                'description' => $request->description,
                'cost'        => $request->cost,
            ];

			$guide = Guia::updateGuia($id, $parameters);

			if (isset($guide)) {
                $response = $guide->jsonSerialize();
                $statusCode = 200;
            }
            else {
                $response = [
                    "respuesta" => "Recurso no encontrado"
                ];
                $statusCode = 404;
            }
		}
		else {
			$response = [
				"error" => "Sin Autorizacion"
			];
			$statusCode = 401;
		}

		return \Response::json($response, $statusCode);
	}

	/**
	 * Removes the specified "Guia" resource from storage.
	 *
	 * @param int $id
     *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}

?>
