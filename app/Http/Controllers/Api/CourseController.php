<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Auth;
use App\Course;
use App\Lesson;
use DB;
class CourseController extends Controller
{
    //
  public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['getAllCourse']]);
   }

    public function getAllCourse()
    {
        $courses = Course::get();
        $response["data"] = $courses;
        return response()->json($response);
    }

    public function catalogByUser(Request $request)
    {
        $userId = Auth::user()->email;
        $arrResponse = [];
        $courses = User::where('email', $userId)->first()->courses()->get();

        $allCoursesCollection = collect(Course::get());
        //var_dump($allCourses);
        //var_dump($courses);
        $arrCourses = $allCoursesCollection->diff($courses);
        foreach ($arrCourses as $course){
            array_push($arrResponse, $course);
        }
        $response["data"] =  $arrResponse ;

        return response()->json($response);
    }


    public function coursesByUser(Request $request)
    {
        $userId = Auth::user()->email;
        $user_id = Auth::user()->id;
        $arrCourses = [];
        $courses = User::where('email', $userId)->first()->courses()->get();
        foreach ($courses as $course) {
            $newCourse["id"] = $course["id"];
            $newCourse["title"] = $course["title"];
            $newCourse["description"] = $course["desc"];
            $newCourse["image"] = "http://ec2-54-254-137-23.ap-southeast-1.compute.amazonaws.com/backend/storage/app/public/".$course["course_logo"];
            $lessons = Lesson::where('course_id', $course["id"])->get();
            $completedCount = 0;
            foreach ($lessons as $lesson) {
                $completed = DB::table('lessons_users')->select('*')->where('lesson_id', '=', $lesson["id"])->where('user_id', '=', $user_id)->get();
                if(count($completed) > 0){
                    $completedCount++;
                }
            }
            $newCourse["completion"] = $completedCount/count($lessons);

            array_push($arrCourses, $newCourse);
        }
        $response["data"] = $arrCourses;

        return response()->json($response);
    }
   
   public function purchaseCourse(Request $request) {
        $userId = Auth::user()->email;
        $courseId = $request->input('course_id');
        $course = Course::find($courseId);
        $user = User::where('email', $userId)->first();
        $user->courses()->save($course);
        $response["status"] = "ok";
        return response()->json($response);

   }


}
