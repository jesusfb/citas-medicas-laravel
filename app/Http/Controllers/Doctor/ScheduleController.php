<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\WorkDay; 



class ScheduleController extends Controller
{
    public function __construc(){
        $this->middleware('auth');
        $this->middleware('doctor');
    }
    
    public function index()
    {
     
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
        //dd($request->all());
        $active= $request->input('active') ?  : []; // si no existe active devuelve un array vacio
        $morning_start= $request->morning_start;  // CADA REQUEST ES UN ARRAY DE INPUTS
        $morning_end= $request->morning_end;
        $afternoon_start= $request->afternoon_start;
        $afternoon_end= $request->afternoon_end;


        //ELOQUENT NOS BRINDA LA OPCION CREAR O ACTUALIZAR 
        for ($i = 0; $i<7 ; $i++){
            WorkDay::updateOrCreate(
                // este acepta 2 parametros (2 array), el primer parametro realiza la busqueda
                // y el segundo los que va actualizar
                [
                    // si queremos actualizar el dia lunes del usuario 1 entonces vamos a buscar por estos 2 campos
                    'day' => $i,
                    'user_id' => Auth()->user()->id,
                  
               
                ],
                [
                    'active' => in_array($i, $active),  
                    // hay que buscar el elemento i en el array active, ya que active nos contiene el dia que esta activo 
                    'morning_start' => $morning_start[$i],
                    'morning_end' =>$morning_end[$i] ,
                    'afternoon_start' =>  $afternoon_start[$i], 
                    'afternoon_end' => $afternoon_end[$i] ,
                 
                ]
        
            );
        }
        return back();
       
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $days=[
            'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'
        ];
        return view('schedule',compact('days'));
      
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
