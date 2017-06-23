<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as VoyagerBreadController;
use TCG\Voyager\Facades\Voyager;
class LessonController extends VoyagerBreadController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     //   $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function createWithId(Request $request, $id)
    {
        $slug = 'lessons';
        $dataType = Voyager::model('DataType')->where('slug', '=', 'lessons')->first();
        // Check permission
        Voyager::canOrFail('add_'.$dataType->name);

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;

        // Check if BREAD is Translatable
        $isModelTranslatable = false;

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return view('lessons/create_lesson', compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'id'));
      
    }
 


 /* Api related controller */


 public function getLesson($id)
    {
        $lesson = Lesson::find($id);
        return response()->json($lesson);
    }

     public function getLessonold($id)
    {
        $lesson = Lesson::find($id);
        
        return response()->json($lesson);
    }
  
}
