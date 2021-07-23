<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Exception;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class SiswaController extends Controller
{
    public function index(){

        $siswa = Siswa::orderBy('created_at','DESC')->get();

        $response = [
            'message' => ' list Siswa time order by desc',
            'data' => $siswa
        ];

        return response()->json($response,response::HTTP_OK);
    }

    public function store(request $request){

        $validator = validator::make($request->all(),[
            'nama' => 'required',
            'nisn' => 'required',
            'kelas' => 'required'
        ]);

        if($validator->fails()){

            return response()->json($validator->errors(),response::HTTP_UNPROCESSABLE_ENTITY);
        }


        try{

            $siswa = Siswa::create($request->all());

            $response = [
                'message' => 'Siswa Created',
                'data' => $siswa
            ];

            return response()->json($response,response::HTTP_CREATED);

        }catch(QueryException $e){
            return response()->json([
                'message' => 'failed'.$e->errorInfo
            ]);
        }
    }

    public function update(request $request,$id){

        $siswa = Siswa::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'nisn' => 'required',
            'kelas' => 'required'
        ]);


        if($validator->fails()){
            return response()->json($validator->errors(),response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $siswa->update($request->all());

            $response = [
                'message' => 'Siswa updated',
                'data' => $siswa
            ];

            return response()->json($response,response::HTTP_OK);

        }catch(QueryException $e){

            return  response()->json([
                'message' => 'failed'.$e->errorInfo
            ]);
        }
    }

    public function show($id){

        $siswa = Siswa::findOrFail($id);

        $response = [
            'message' => 'Detail of siswa resource',
            'data' => $siswa
        ];

        return response()->json($response,response::HTTP_OK);

    }


    public function destroy($id){

        $siswa = Siswa::findOrFail($id);

        try{

        $siswa->delete();

        $response = [
            'message' => 'Siswa Deleted',
            'data' => $siswa
        ];

        return response()->json($response,response::HTTP_OK);
        }catch(QueryException $e){

            return response()->json([
                'message' => 'failed'.$e->errorInfo
            ]);
        }

    }


}
