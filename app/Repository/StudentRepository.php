<?php

namespace App\Repository;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\my_Parent;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Type_Blood;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements StudentRepositoryInterface{
    public function Get_Student(){
        $students = Student::all();

        return view('Pages.Students.index',compact('students'));
    }

    public function Edit_Student($id){
        $data['Grades'] = Grade::all();
        $data['parents'] = my_Parent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_Blood::all();

        $Students = Student::findOrFail($id);

        return view('Pages.Students.edit',$data,compact('Students'));
    }

    public function Update_Student($request){
        try {
            $Edit_Students = Student::findOrfail($request->id);
            $Edit_Students->name =['en'=>$request->name_en,'ar'=>$request->name_ar];
            $Edit_Students->email = $request->email;
            $Edit_Students->password = Hash::make($request->password);
            $Edit_Students->gender_id = $request->gender_id;
            $Edit_Students->nationalitie_id = $request->nationalitie_id;
            $Edit_Students->blood_id = $request->blood_id;
            $Edit_Students->Date_Birth = $request->Date_Birth;
            $Edit_Students->Grade_id = $request->Grade_id;
            $Edit_Students->Classroom_id = $request->Classroom_id;
            $Edit_Students->section_id = $request->section_id;
            $Edit_Students->parent_id = $request->parent_id;
            $Edit_Students->academic_year = $request->academic_year;
            $Edit_Students->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('Students.index');


        }catch (\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function Create_Student()
    {
        $data['my_classes'] = Grade::all();
        $data['parents'] = my_Parent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_Blood::all();

        return view('Pages.Students.add',$data);
    }

    public function Get_classrooms($id)
    {
        $list_classes = Classroom::where('Grade_id',$id)->pluck('Name_Class','id');

        return $list_classes;
    }

    public function Get_Sections($id)
    {
        $list_sections = Section::where('Class_id',$id)->pluck('Name_Section','id');
        return $list_sections;
    }

    public function Store_Student($request){

        try {
            $students = new Student();
            $students->name =['en'=>$request->name_en,'ar'=>$request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();

            toastr()->success(trans('messages.Success'));
            return redirect()->route('Students.create');


        }catch (\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function Delete_Student($request){

//        Student::findOrFail($request->id)->delete();
//        toastr()->success(trans('messages.Delete'));
//        return redirect()->route('Students.index');

        Student::destroy($request->id);
        toastr()->success(trans('messages.Delete'));
        return redirect()->route('Students.index');

    }

}