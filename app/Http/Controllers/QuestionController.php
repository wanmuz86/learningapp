<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as VoyagerBreadController;
use TCG\Voyager\Facades\Voyager;
class QuestionController extends VoyagerBreadController
{

	 public function update(Request $request, $id)
    {
        Voyager::canOrFail('edit_questions');

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
        
        foreach ($request->input('answers',[]) as $answer ){
            $answer = $data->answeroptions()->create([
                'title' => $answer,
                'question_id' => $data->id,
                ]);
        }
    
//        $data->tags()->sync($request->input('tags', []));

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => "Successfully Updated {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }

    // POST BRE(A)D
    public function store(Request $request)
    {
        Voyager::canOrFail('add_questions');

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $data = new $dataType->model_name();
        $this->insertUpdateData($request, $slug, $dataType->addRows, $data);
        $answers = $request->input('answers',[]) ;
        $correct_answer = $request->input('correct_answer');
      
        for ($i=0; $i< count($answers); $i++ ){
            if ($i== $correct_answer){
            $answer = $data->answeroptions()->create([
                'text' => $answers[$i],
                'question_id' => $data->id,
                'iscorrect' => 1,
                ]);
        }
        else  {
            $answer = $data->answeroptions()->create([
                'text' => $answers[$i],
                'question_id' => $data->id,
                'iscorrect' => 0,
                ]);
        }
        }

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message'    => "Successfully Added New {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
   
}
