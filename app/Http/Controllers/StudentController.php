<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function index(){

        $student = Student::orderBy('created_at','DESC')->get();

        $response = [
            'message' => 'List student order by time desc',
            'data' => $student
        ];

        return response()->json($response,response::HTTP_OK);
    }

    public function store(request $request){

        $rules = [
            'nama' => 'required',
            'nisn' => 'required',
            'kelas' => 'required'
        ];

        $message = [
            'nama.required' => 'nama wajib di isi',
            'kelas.required' => 'kelas wajib di isi',
            'nisn.required'=> 'nisn wajib di isi'
        ];

        $validator = Validator::make($request->all(),$rules,$message);

        if($validator->fails()){
            return response()->json($validator->errors(),response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $student = Student::create($request->all());

            $response = [
                'message' => 'Student Created',
                'data' => $student
            ];

            return response()->json($response,response::HTTP_CREATED);

        }catch(QueryException $e){

            return response()->json([
                'message' => 'failed'.$e->errorInfo
            ]);
        }
    }


    public function update(request $request,$id){

        $student = Student::findOrFail($id);

        $rules = [
            'nama' => 'required',
            'kelas' => 'required',
            'nisn' => 'required'
        ];

        $message = [
            'nama.required' => 'nama wajib di isi',
            'nisn.required' => 'nisn wajib di isi',
            'kelas.required' => 'kelas wajib di isi'
        ];

        $validator = Validator::make($request->all(),$rules,$message);

        if($validator->fails()){
            return response()->json($validator->errors(),response::HTTP_UNPROCESSABLE_ENTITY);
        }


        try{

            $student->update($request->all());

            $response = [
                'message' => 'Update Student',
                'data' => $student
            ];

            return response()->json($response,response::HTTP_OK);

        }catch(QueryException $e){

            return response()->json([
                'message' => 'failed'.$e->errorInfo
            ]);
        }
    }

    public function show($id){

        $student = Student::findOrFail($id);

        $response = [
            'message' => 'show student',
            'data' => $student
        ];

        return response()->json($response,response::HTTP_OK);
    }



    public function destroy($id){

        $student = Student::findOrFail($id);

        $student->delete();

        $response = [
            'message' => 'delete student',
            'data' => $student
        ];

        return response()->json($response,response::HTTP_OK);
    }

    public function search(request $request){

        $student = Student::where('nisn','like','%'.$request->nisn.'%')->get();

        $response = [
            'message' => 'search student',
            'data' => $student
        ];

        return response()->json($response,response::HTTP_OK);
    }
}
