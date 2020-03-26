<?php

namespace App\Http\Controllers;
use App\Interfaces\ScheduleServiceInterface;
use Illuminate\Http\Request;
use App\Specialty;
use App\Appointment;
use App\User;
use Carbon\Carbon;
use Validator;
use App\CancelledAppointment;
use Auth;                   
class AppointmentController extends Controller
{
    // admin -> all 
    // doctor 
    // patient
    function index(){
        //$confirmAuth::user()edAppointments=Appointment::paginate(10);
        $role= auth()->user()->role;
        // rol actual de la persona logeada
        // 4 Status: Confirmada, Atendida, Cancelada , Confirmada
        if($role=='admin'){
            $confirmedAppointments=Appointment::where('status', 'Confirmada')
            ->paginate(10);
            $pendingAppointments=Appointment::where('status', 'Reservada')
            ->paginate(10);
            $oldAppointments=Appointment::whereIn('status',['Atendida','Cancelada'])
            ->paginate(10);
        } elseif($role=='doctor'){
            $confirmedAppointments=Appointment::where('status', 'Confirmada')
            ->where('doctor_id',Auth::user()->id)
            ->paginate(10);
            $pendingAppointments=Appointment::where('status', 'Reservada')
            ->where('doctor_ id',Auth::user()->id)
            ->paginate(10);
            $oldAppointments=Appointment::whereIn('status',['Atendida','Cancelada'])
            ->paginate(10);
    
        }else if($role=='patient'){

            $confirmedAppointments=Appointment::where('status', 'Confirmada')
            ->where('patient_id',Auth::user()->id)
            ->paginate(10);
            $pendingAppointments=Appointment::where('status', 'Reservada')
            ->where('patient_id',Auth::user()->id)
            ->paginate(10);
            $oldAppointments=Appointment::whereIn('status',['Atendida','Cancelada'])
            ->paginate(10);
        }

        // PATIENT
        
        return view('appointments.index',compact('confirmedAppointments', 'pendingAppointments','oldAppointments','role'));
    }
   
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
    function store(Request $request, ScheduleServiceInterface $scheduleService){
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
        //$this->validate($request,$rules,$messages);
        $validator = Validator::make(
            $request->all(), 
            $rules, 
            $messages
        );
         // hay que ponerlas en use porque esta funcion anonima no tiene acceso a las otras variables.
        $validator->after(function($validator) use ($request,$scheduleService){
            $date= $request->scheduled_date;
            $doctorId= $request->doctor_id;
            $scheduled_time= $request->scheduled_time;
            if($date && $doctorId && $scheduled_time){
                $start= new Carbon($scheduled_time);
            }else{
                return ;
            }
            // verifico si esta disponible pasando la fecha, doctor id, y la hora a consultar en un object carbon
            if (!$scheduleService->isAvailableInterval($date,$doctorId,$start)){
                $validator->errors()->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro paciente.');
            }
        });
        if ($validator->fails()){
            // The given data did not pass validation
            return back()
            ->withErrors($validator)
            ->withInput();
        }
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
    function showFormCancel(Appointment $appointment){
        if($appointment->status== 'Confirmada'){
            return view('appointments.form-cancel',compact('appointment'));
        }
        return redirect()->route('appointments.index');
    }
    function postCancel(Appointment $appointment, Request $request){
        $appointment->status='Cancelada';
        if($request->has('justification')){
            $cancelledAppointment = new CancelledAppointment();
            $cancelledAppointment->justification= $request->justification;
            $cancelledAppointment->appointment_id=$appointment->id;
            $cancelledAppointment->cancelled_by_id=Auth::user()->id;
            $cancelledAppointment->save();
        }
        $appointment->update();
        $notification='Su cita ha sido cancelada Exitosamente';
        return \Redirect::route('appointments.index')->with(compact('notification'));
    }
    function show(Appointment $appointment){
       // dd((CancelledAppointment::get())->all());
        return view('appointments.show',compact('appointment'));
    }
    function confirmAppointment(Appointment $appointment){
      // 4 Status: Reservada, Atendida, Cancelada , Confirmada
        if($appointment->status == 'Reservada'){
            $appointment->status='Confirmada';
            $appointment->update();
            $notification='Su cita ha sido confirmada Exitosamente';
            return \Redirect::route('appointments.index')->with(compact('notification'));
        }
        return \Redirect::route('appointments.index');
     }
 

    
    // prueba de WBS
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
