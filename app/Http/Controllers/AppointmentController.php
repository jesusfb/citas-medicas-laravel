<?php

namespace App\Http\Controllers;
use App\Interfaces\ScheduleServiceInterface;
use Illuminate\Http\Request;
use App\Specialty;
use App\Appointment;
use App\User;
use Carbon\Carbon;
class AppointmentController extends Controller
{
   
    function create(ScheduleServiceInterface $scheduleService){
        $specialties= Specialty::all();
         $specialtyId= old('specialty_id');
         if($specialtyId){
             $specialty=Specialty::find($specialtyId);
             $doctors=$specialty->users; // los usuarios vinculados con la especialidad son medicos (Verificar en el modelo Specialty ).
         }else{
             $doctors= collect();
         }
         $date= old('scheduled_date');
         $doctorId=old('doctor_id');
         if($date && $doctorId){
            $intervals= $scheduleService->getAvailableIntervals($date,$doctorId);
         }else{
             $intervals= null;
         }
        return view('appointments.create',compact('specialties','doctors' ,'intervals'));
    }
    function store(Request $request){
        // vamos a crear una nueva Cita
        //dd($request->all());
        $rules= [
            'description' =>'required',
            'specialty_id'=> 'exists:specialties,id',
            'doctor_id'=>'exists:users,id',
            'scheduled_time'=>'required',
            'scheduled_date' => 'required',
        ];
        $messages=[
            'scheduled_time.required' => 'Por favor seleccione una hora válida para su cita.' ,
            'scheduled_date.required' => 'Por favor seleccione una fecha válida para su cita.'
        ];
        $this->validate($request,$rules,$messages);
        $data= $request->only([
            'description',
            'scheduled_date',
            'scheduled_time',
            'type',
            'doctor_id',
            'specialty_id',
        ]);
        $data['patient_id']= \Auth::user()->id;;
        $scheduled_time=$request->scheduled_time;
        // dd($scheduled_time);
        $scheduled_time=new Carbon($scheduled_time);
         // dd($scheduled_time);
        $data['scheduled_time']=$scheduled_time->format('H:i:s');
        // dd($data);
        Appointment::Create($data);
        $notification='La cita se ha registrado Correctamente!';
        return back()->with(compact('notification'));
    }
    function getUsers(Request $request){
        if($request->isJson()){
            $users=User::where('role','patient')->get(['id','name', 'email' , 'role']);
            return response()->json([
                'header' => $request->name,
                'Usuarios' => $users
            ],200);
        }else{
            return response()->json([
                'errors' => 'No Autorizado',
                 'data' => $request
            ],401);
        }

    }
}
