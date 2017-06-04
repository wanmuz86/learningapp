<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Question;
use App\Answeroption;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as VoyagerBreadController;
use TCG\Voyager\Facades\Voyager;
class QuizController extends VoyagerBreadController
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

    public function getQuiz($id)
    {
        $questions = Question::where('quiz_id',1)->get();
        $arrQuestions = [];
        foreach ($questions as $question){
            $quiz["question"] = $question["title"];
            $quiz["options"] = $question->answeroptions()->get();
            array_push($arrQuestions, $quiz);
        }
        $response["data"] = $arrQuestions;
        return response()->json($response);
    }
}
