<?php

namespace App\Http\Controllers;
use App\Http\Requests\GTSRequest;
use Illuminate\Http\Request;
use App\GraduateTracerStudy;
use Auth;
use App\Models\User;

class GTSController extends Controller
{
    public function alumnusForm()
    {
        $form = new GraduateTracerStudy;
        $data = compact('form');
        return view('user.alumnus.form', array_merge(ApplicationConstantController::getGTSConstants(), $data)); 
    }

    public function edit ($id) {

        $form = GraduateTracerStudy::find($id);

        $advancestudies_fm = json_decode($form->advance_studies,true);
        $reasonsYes_fm = json_decode($form->reasonsYes, true);
        $reasonsNo_fm = json_decode($form->reasonsNo, true);
        $jobRolesExperienced_fm = json_decode($form->jobRolesExperienced, true);
        $conceptsLearned_fm = json_decode($form->conceptsLearned, true);
        $reasonsUndergraduateCourse_fm = json_decode($form->reasonsUndergraduateCourse, true);
        $reasonUnemployedNow_fm = json_decode($form->reasonUnemployedNow, true);
        $reasonUnemployedNever_fm = json_decode($form->reasonUnemployedNever, true);
        $data = compact('form','advancestudies_fm','reasonsYes_fm','reasonsNo_fm','jobRolesExperienced_fm','conceptsLearned_fm','reasonsUndergraduateCourse_fm','reasonUnemployedNow_fm','reasonUnemployedNever_fm');
		return view('user.alumnus.form', array_merge(ApplicationConstantController::getGTSConstants(), $data)); 
        
    }
    public function update (GTSRequest $request, $id) {
        $request = $this->checkText($request);
        $request = $this->dataToJson($request);
        $validated = $request->validated();
        $validated = $this->removeData($validated);
        $this->employementStatus($validated);
        GraduateTracerStudy::where('id', $id)->update($validated);
        return redirect()->back();
    }
    
    public function store (GTSRequest $request) {
        $request['user_id'] = Auth::user()->id;
        $request = $this->checkText($request);
        $request = $this->dataToJson($request);
        $validated = $request->validated();
        $validated = $this->removeData($validated);
        $this->employementStatus($validated);
        GraduateTracerStudy::create($validated);

        return redirect()->back()->with('success','Thank you for answering!');
    }
    public function employementStatus($request){
        $validated = $request;
        if($validated['is_presently_employed'] == 'Yes'){
            User::where('id',Auth::user()->id)->update([
                'employmentStatus' => 'Employeed',
                'updateStatus' => 'Recent'
            ]);
        }

        if($validated['is_presently_employed'] == 'No, I\'m not employed now'){
            User::where('id',Auth::user()->id)->update([
                'employmentStatus' => 'Unemployed(Now)',
                'updateStatus' => 'Recent'
            ]);
        }

        if($validated['is_presently_employed'] == 'No, I was never employed'){
            User::where('id',Auth::user()->id)->update([
                'employmentStatus' => 'Unemployed(Never)',
                'updateStatus' => 'Recent'
            ]);
        }
        return ;
    }
    public function removeData($request)
    {
        $validated = $request;
        if($validated['highest_educational_attainment'] == 'College Graduate'){
            $validated['program_pursued'] = null;
            $validated['name_of_graduate_school'] = null;
            $validated['address_of_graduate_school'] = null;
            $validated['advance_studies'] = null;
            $validated['advance_studies_text'] = null;
            //.....
        }

        if($validated['is_presently_employed'] == 'Yes'){
            $validated['reasonUnemployedNow'] = null;
            $validated['reasonUnemployedNow_text'] = null;
            $validated['reasonUnemployedNever'] = null;
            $validated['reasonUnemployedNever_text'] = null;
            if($validated['is_first_job'] == 'Yes'){
                $validated['reasonsNo'] = null;
                $validated['reasonsNo_text'] = null;
                $validated['isFirstJobRelated'] = null;
                $validated['isJobpositionFirstworkAfterCollege'] = null;
                $validated['firstCompanyworked'] = null;
                //.....
            }else{
                $validated['reasonsYes'] = null;
                $validated['reasonsYes_text'] = null;
            }
        }
        else if($validated['is_presently_employed'] == 'No, I\'m not employed now'){
            $validated['industry_currently_working'] = null;
            $validated['job_level'] = null;
            $validated['present_job_position'] = null;
            $validated['job_not_related_to_degree'] = null;
            $validated['months_employed'] = null;
            $validated['name_of_company'] = null;
            $validated['address_of_company'] = null;
            $validated['is_first_job'] = null;
            $validated['reasonsYes'] = null;
            $validated['reasonsNo'] = null;
            $validated['reasonUnemployedNever'] = null;
            //.....
        }
        else if ($validated['is_presently_employed'] == 'No, I was never employed'){
            $validated['industry_currently_working'] = null;
            $validated['job_level'] = null;
            $validated['present_job_position'] = null;
            $validated['job_not_related_to_degree'] = null;
            $validated['months_employed'] = null;
            $validated['name_of_company'] = null;
            $validated['address_of_company'] = null;
            $validated['is_first_job'] = null;
            $validated['reasonsYes'] = null;
            $validated['reasonsNo'] = null;
            $validated['isFirstJobRelated'] = null;
            $validated['isJobpositionFirstworkAfterCollege'] = null;
            $validated['firstCompanyworked'] = null;
            $validated['monthsEmployedfirstjobAfterGraduate'] = null;
            $validated['jobRolesExperienced'] = null;
            $validated['jobRolesExperienced_text'] = null;
            $validated['conceptsLearned'] = null;
            $validated['conceptsLearned_text'] = null;
            $validated['programmingLanguages'] = null;
            $validated['reasonUnemployedNow'] = null;

        }

        return $validated;
       
    }

    public function dataToJson($request){
        $request->advance_studies ? $request['advance_studies'] = json_encode($request->advance_studies) : '';
        $request->reasonsYes ? $request['reasonsYes'] = json_encode($request->reasonsYes)  : '';
        $request->reasonsNo ? $request['reasonsNo'] = json_encode($request->reasonsNo) : '';
        $request->jobRolesExperienced ? $request['jobRolesExperienced'] = json_encode($request->jobRolesExperienced) : '';
        $request->conceptsLearned ? $request['conceptsLearned'] = json_encode($request->conceptsLearned): '';
        $request->reasonsUndergraduateCourse ? $request['reasonsUndergraduateCourse'] = json_encode($request->reasonsUndergraduateCourse) : '';
        $request->reasonUnemployedNow ? $request['reasonUnemployedNow'] = json_encode($request->reasonUnemployedNow) : ''; 
        $request->reasonUnemployedNever ? $request['reasonUnemployedNever'] = json_encode($request->reasonUnemployedNever) : '';
        return $request;
    }
    public function checkText($request){

        $request->advance_studies && !in_array('If other, please specifiy', $request->advance_studies) ? $request['advance_studies_text'] = null : ''; 
        $request->reasonsYes && !in_array('If other, please specifiy', $request->reasonsYes) ? $request['reasonsYes_text'] = null : ''; 
        $request->reasonsNo && !in_array('If other, please specifiy', $request->reasonsNo) ? $request['reasonsNo_text'] = null : ''; 
        $request->jobRolesExperienced && !in_array('If other, please specifiy', $request->jobRolesExperienced) ? $request['jobRolesExperienced_text'] = null : ''; 
        $request->conceptsLearned && !in_array('If other, please specifiy', $request->conceptsLearned) ? $request['conceptsLearned_text'] = null : ''; 
        $request->reasonUnemployedNow && !in_array('If other, please specifiy', $request->reasonUnemployedNow) ? $request['reasonUnemployedNow_text'] = null : ''; 
        $request->reasonUnemployedNever && !in_array('If other, please specifiy', $request->reasonUnemployedNever) ? $request['reasonUnemployedNever_text'] = null : ''; 
        $request->reasonsUndergraduateCourse && !in_array('If other, please specifiy', $request->reasonsUndergraduateCourse) ? $request['reasonsUndergraduateCourse_text'] = null : ''; 
        return $request;
    }

}
