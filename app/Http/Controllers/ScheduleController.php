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
        return view('schedule.schedule');
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

        // echo "<pre>";
        // print_r($disponibility);
        // echo "</pre>";
        // die;
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

        $date = strtotime($data['schedules_date']);
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

    public function disponibility($date){
                
        $x = Schedule::where('schedules_date', $date)->with('schedule_dates')->get();

        if ($x->count() >= 1){
            $response['success'] = true;
            $data = json_decode($x, TRUE);
        
            foreach($data as $d => $r){
                $indisponibility[$d]['time'] = $r['schedule_dates'][0]['available_hour'];
            }

            $response['data'] = $indisponibility;
            echo json_encode($response);
        } else{
            $response['success'] = false;
            echo json_encode($response);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
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
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
