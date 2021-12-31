<?php

namespace App\Http\Controllers;

use App\Models\Available;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Schedule_exclude;
use App\Models\Schedule_settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Patient::select()
        ->join("schedules", "schedules.patient_id", "=", "patients.id")
        ->join("schedules_date", "schedules_date.schedule_id", "=", "schedules.id" )
        ->join("availables", "availables.id", "=", "schedules_date.available_id" )
        ->orderBy('schedules.schedules_date')
        ->orderBy('availables.available_hour')
        ->where('schedules.user_id', Auth::user()->id)
        ->get();

        if ($data->count() > 0){
            $consultas = json_decode($data, TRUE);

            foreach($consultas as $r => $consulta){
                $consult[$r]['patient_id'] = $consulta['patient_id'];
                $consult[$r]['patient_firstname'] = $consulta['patient_firstname'];
                $consult[$r]['patient_lastname'] = $consulta['patient_lastname'];
                $consult[$r]['patient_cpf'] = $consulta['patient_cpf'];
                $consult[$r]['schedules_date'] = $consulta['schedules_date'];
                $consult[$r]['available_hour'] = $consulta['available_hour'];
                $consult[$r]['schedule_id'] = $consulta['schedule_id'];
            }
            
            return view('schedule.schedule', compact('consult'));

        } else {
            return view('schedule.schedule');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $user = Auth::user()->id;

        $data = Schedule_settings::where('user_id', $user)->with('schedule_disponibility')->get();
        $disponibility = json_decode($data, TRUE);

        $data = Schedule_exclude::where('user_id', $user)->select('exclude_date')->get();
        $exclude = json_decode($data, TRUE);

        if($id){
            $data = Patient::where('id', $id)->get();
            $patient = json_decode($data, TRUE);
        } else {
            $patient = null;
        }

        $data = Available::where('schedule_settings_id', $disponibility[0]['schedule_disponibility'][0]['schedule_settings_id'])->get();
        $available = json_decode($data, TRUE);

        if ($disponibility == null){
            $disponibility = 'Não há regras de agendamento criadas, cadastre-as para agendar uma consulta';
        }

        return view('schedule.add-schedule', [
            'disponibility' => $disponibility,
            'exclude' => $exclude,
            'available' => $available,
            'patient' => $patient
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        //Convertendo data no padrão americano para salvar a mesma no banco de dados
        $x = implode('-', array_reverse(explode('/', $data['schedules_date'])));
        $date = strtotime($x);
        $date2 = date('Y-m-d', $date);

        $id = Schedule::create([
            'schedules_date' => $date2,
            'user_id' => Auth::user()->id,
            'patient_id' => $data['idPatient'],
        ]);

        $idAvailable = Available::where('available_hour', $data['schedule_hour'])->select('id')->get();

        DB::table('schedules_date')->insert([
            'schedule_id' => $id['id'],
            'available_id'=> $idAvailable[0]['id'],
        ]);

        return redirect()->route('schedules.index')->with('message', 'Consulta agendada com sucesso!');
    }


    // Esta função é responsável por criar um json para uma requisção ajax que irá exibir os horários que estão disponíveis para agendamento da consulta
    public function disponibility($date){
               
        //Busca de horários já agendados no banco de dados
        $x = Schedule::where('schedules_date', $date)->with('schedule_dates')->get();

        //Verifica se há registros, caso haja um array com os horários é criados, caso contrário o response retorna false
        if ($x->count() >= 1) {

            $response['success'] = true;
            $data = json_decode($x, TRUE);
            
            foreach($data as $d => $r){
                $indisponibility[$d]['time'] = $r['schedule_dates'][0]['available_hour'];
            }

            $response['data'] = $indisponibility;
            echo json_encode($response);
            return;

        } else {
            $response['success'] = false;
            echo json_encode($response);
            return;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Schedule::where('id', $id)->select('id', 'schedules_date','user_id', 'patient_id')->get();
        $schedule = json_decode($data, TRUE);

        $user = Auth::user()->id;

        $data = Schedule_settings::where('user_id', $user)->with('schedule_disponibility')->get();
        $disponibility = json_decode($data, TRUE);

        $data = DB::table('schedules_date')->where('schedule_id', $schedule[0]['id'])->select('available_id')->get();
        $time = json_decode($data, TRUE);

        $data = Available::where('id', $time[0]['available_id'])->select('available_hour')->get();
        $scheduleTime = json_decode($data, TRUE);

        $data = Schedule_exclude::where('user_id', $user)->select('exclude_date')->get();
        $exclude = json_decode($data, TRUE);

        $data = Patient::where('id', $schedule[0]['patient_id'])->get();
        $patient = json_decode($data, TRUE);

        $data = Available::where('schedule_settings_id', $disponibility[0]['schedule_disponibility'][0]['schedule_settings_id'])->get();
        $available = json_decode($data, TRUE);

        if ($disponibility == null){
            $disponibility = 'Não há regras de agendamento criadas, cadastre-as para agendar uma consulta';
        }

        return view('schedule.add-schedule', [
            'disponibility' => $disponibility,
            'exclude' => $exclude,
            'available' => $available,
            'patient' => $patient,
            'schedule' => $schedule,
            'time' => $scheduleTime
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        DB::table('schedules_date')->where('schedule_id', $data['schedule_id'])->delete();
        Schedule::where('id', $data['schedule_id'])->delete();

        //Convertendo data no padrão americano para salvar a mesma no banco de dados
        $x = implode('-', array_reverse(explode('/', $data['schedules_date'])));
        $date = strtotime($x);
        $date2 = date('Y-m-d', $date);

        $id = Schedule::create([
            'schedules_date' => $date2,
            'user_id' => Auth::user()->id,
            'patient_id' => $data['idPatient'],
        ]);

        $idAvailable = Available::where('available_hour', $data['schedule_hour'])->select('id')->get();

        DB::table('schedules_date')->insert([
            'schedule_id' => $id['id'],
            'available_id'=> $idAvailable[0]['id'],
        ]);

        return redirect()->route('schedules.index')->with('message', 'Consulta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        DB::table('schedules_date')->where('schedule_id', $id)->delete();

        Schedule::where('id', $id)->delete();

        return redirect()->route('schedules.index')->with('message', 'Consulta excluída com sucesso');
    }
}
