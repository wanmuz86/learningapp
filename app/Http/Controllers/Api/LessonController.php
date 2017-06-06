<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Lesson;
class LessonController extends Controller
{
    //
  public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['getAllCourse']]);
   }

    public function getAllLesson()
    {
        $lessons = Lesson::get();
        $response["data"] = $lessons;
        return response()->json($response);
    }

    public function lessonByUser(Request $request)
    {
        $userEmail = Auth::user()->email;
        $userId = Auth::user()->id;
        $course_id = $request->input('course_id');
        $lessons = Lesson::where('course_id', $course_id)->get();
        $lessonCount = Lesson::where('course_id', $course_id)->count();
        $completedLessons = [];
        $completedCount = 0;
        foreach ($lessons as $lesson) {
            $completed = DB::table('lessons_users')->select('*')->where('lesson_id', '=', $lesson["id"])->where('user_id', '=', $userId)->get();
            if(count($completed) > 0){
                $lesson["completed"] = 1;
                $completedCount++;
            }
            else {
                $lesson["completed"] = 0;
            }
            array_push($completedLessons, $lesson);
        }

       $response["completedLesson"] = $completedLessons;
       $response["completion"] = $completedCount/count($lessons) ;
        return response()->json($response);
    }    
   
   public function updateLesson(Request $request) {
    
        $userId = Auth::user()->email;
        $user_id = Auth::user()->id;
        $lessonId = $request->input('lesson_id');
        $lesson = Lesson::find($lessonId);
        $user = User::where('email', $userId)->first();
        $user->lessons()->attach($lesson);

        $courseUpdate = DB::table('courses_users')->select('*')->where('course_id', '=', $lesson["course_id"])->where('user_id', '=', $user_id)->first();

        $counter = $courseUpdate->lessons_completed+1;
        DB::table('courses_users')->where('course_id','=',$lesson["course_id"])->where('user_id','=',$user_id)->update(['lessons_completed'=> $counter]);
        $response["status"] = "ok";
        return response()->json($response);
   }
}
