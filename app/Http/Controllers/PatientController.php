<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Patient::select(
            'id',
            'patient_firstname',
            'patient_lastname',
            'patient_cpf'
        )
        ->orderBy('id')
        ->get();

        if ( isset($data) == true  ) {
            $patients = json_decode($data, TRUE);
            return view('patients.patients', compact('patients'));
        } else {
            return view('patients.patients');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.add-patients');
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
        
        //Formatação do CPF e CEP para conversão para integer
        $cpf = str_replace(array(".", "-"), "", $data['patient_cpf']);
        $cep = str_replace("-", "", $data['address_zipcode']);

        //Validação e conversão do campo gender para integer
        if ( $data['patient_gender'] == 'Masculino' ) {
            $gender = 0;
        } elseif ( $data['patient_gender'] == 'Feminino' ) {
            $gender = 2;
        } else {
            $gender = 3;
        }

        $patients = Patient::create([
            'patient_firstname'  => $data['patient_firstname'],
            'patient_lastname'   => $data['patient_lastname'],
            'patient_cpf'        => $cpf,
            'patient_phone'      => $data['patient_phone'],
            'patient_email'      => $data['patient_email'],
            'patient_gender'     => $gender,
            'patient_birth_date' => $data['patient_birth_date']
        ]);

        $addresses = Address::create([
            'adress_name'        => $data['adress_name'],
            'address_number'     => $data['address_number'],
            'address_zipcode'    => $cep,
            'address_complement' => $data['address_complement'],
            'address_district'    => $data['address_district'],
            'address_city'       => $data['address_city'],
            'address_uf'         => $data['address_uf']
        ]);

        // Recuperando os ids dos pacientes e endereços para salvar no banco
        $idPatients = json_decode($patients, TRUE);
        $idAddresses = json_decode($addresses, TRUE);

        DB::table('address_patients')->insert([
            'patients_id' => $idPatients['id'],
            'addresses_id' => $idAddresses['id']
        ]);

        return redirect()->route('patients.index')->with('message', 'Paciente cadastrado com successo!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Patient::select()
        ->join("address_patients", "address_patients.patients_id", "=", "patients.id")
        ->join("addresses", "addresses.id", "=", "address_patients.id")
        ->where("patients.id", $id)
        ->get();

        if ( isset($data) == true  ) {
            $data = json_decode($data, TRUE);
            $patient = $data[0];
            return view('patients.add-patients', compact('patient'));
        } else {
            return redirect()-back()->with('error', 'Não foi possível localizar os dados do paciente!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        
        //Formatação do CPF e CEP para conversão para integer
        $cpf = str_replace(array(".", "-"), "", $data['patient_cpf']);
        $cep = str_replace("-", "", $data['address_zipcode']);

        //Validação e conversão do campo gender para integer
        if ( $data['patient_gender'] == 'Masculino' ) {
            $gender = 0;
        } elseif ( $data['patient_gender'] == 'Feminino' ) {
            $gender = 2;
        } else {
            $gender = 3;
        }

        // Os dados gerais do paciente são atualizados
        Patient::where('id', $data['id'])
            ->update([
            'patient_firstname'  => $data['patient_firstname'],
            'patient_lastname'   => $data['patient_lastname'],
            'patient_cpf'        => $cpf,
            'patient_phone'      => $data['patient_phone'],
            'patient_email'      => $data['patient_email'],
            'patient_gender'     => $gender,
            'patient_birth_date' => $data['patient_birth_date']
        ]);

        //Esta variável coleta o id do endereço vinculado ao paciente
        $idAddress = DB::table('address_patients')->where('patients_id', $data['id'])->select('addresses_id')->get();

        //Esta função atualiza os dados de endereço do paciente
        Address::where('id', $idAddress[0]->addresses_id)
            ->update([
            'adress_name'        => $data['adress_name'],
            'address_number'     => $data['address_number'],
            'address_zipcode'    => $cep,
            'address_complement' => $data['address_complement'],
            'address_district'   => $data['address_district'],
            'address_city'       => $data['address_city'],
            'address_uf'         => $data['address_uf']
        ]);

        return redirect()->route('patients.index')->with('message', 'Paciente atualizado com successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idAddress = DB::table('address_patients')->where('patients_id', $id)->select('addresses_id')->get();

        DB::table('address_patients')->where('patients_id', $id)->delete();

        Patient::where('id', $id)->delete();
        Address::where('id', $idAddress[0]->addresses_id)->delete();
        
        return redirect()->route('patients.index')->with('message', 'Paciente excluído com sucesso!');
    }
}
