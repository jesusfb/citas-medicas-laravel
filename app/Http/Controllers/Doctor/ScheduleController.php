<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\WorkDay; 
use Carbon\Carbon;



class ScheduleController extends Controller
{
    private $days=[
        'Lunes', 'Martes', 'Miercoles', 'Jueves', 
        'Viernes', 'Sabado', 'Domingo'
    ];

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

        $errors = [];
        //ELOQUENT NOS BRINDA LA OPCION CREAR O ACTUALIZAR 
        for ($i = 0; $i<7 ; $i++){
            if($morning_start[$i] > $morning_end[$i]){
                $errors []= 'Las horas del turno mañana son incosistentes para el día: '. $this->days[$i] .'.';
            }
            if($afternoon_start[$i] > $afternoon_end[$i]){
                $errors []= 'Las horas del turno tarde son incosistentes para el día: '. $this->days[$i] .'.';
            }
            WorkDay::updateOrCreate(
                // este acepta 2 parametros (2 array), el primer parametro realiza la busqueda
                // y el segundo los que va actualizar
                [
                    // si queremos actualizar el dia lunes del usuario 1 entonces vamos a buscar por estos 2 campos
                    'day' => $i,
                    'user_id' => Auth()->user()->id
                ], [
                    'active' => in_array($i, $active),  
                    // hay que buscar el elemento i en el array active, ya que active nos contiene el dia que esta activo 
                    'morning_start' => $morning_start[$i],
                    'morning_end' =>$morning_end[$i] ,
                    'afternoon_start' =>  $afternoon_start[$i], 
                    'afternoon_end' => $afternoon_end[$i]
                ]
        
            );
        }
        if(count($errors) > 0)
             return back()->with(compact('errors'));
        $notification="Los cambios se han guardado correctamente";
        return back()->with(compact('notification'));
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
        $workDays=WorkDay::where('user_id',auth()->user()->id)->get();

        if(count($workDays)>0){
            $workDays->map(function($data){
                // esto me va permitir mapear los campos en formato hora minutos y am/pm
                    $data->morning_start=(new Carbon($data->morning_start))->format('g:i A');
                    $data->morning_end=(new Carbon($data->morning_end))->format('g:i A');
                    $data->afternoon_start=(new Carbon($data->afternoon_start))->format('g:i A');
                    $data->afternoon_end=(new Carbon($data->afternoon_end))->format('g:i A');
                    return $data;
            });
    
        }else{
            // caundo el medico no haya definido su horario
             // ASI NO SE muestra VACIA LA TABLA DE HORARIOS EN LA VISTA DE HORARIOS
            $workDays= collect(); // necesitamos crear una collection para que en la vista se puede iterar sobre él
            for ($i=0; $i <7 ; $i++) {  // entonces creo un object por cada dia y lo agrego a la collection
                $workDays->push(new WorkDay());
            }
            // con todo esto va mostrar la tabla de horarios vacios para que el medico pueda definir su horario
        }
        $days=$this->days; 
        return view('schedule',compact('days','workDays'));
      
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
