<?php

namespace App\Http\Controllers;
//require 'vendor/autoload.php';

use Phpml\Tokenization\WhitespaceTokenizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\Subject;
use App\Models\Question;

class OpenAIController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

    public function index(Request $request): JsonResponse
    {
       // $data =json_decode(request()->all());
        // $search = "write a 5 question for api";
    //  $data=$req->all();

    $data = $request->json()->all();
    $search = $data['data'];

        $data = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
                  ])
                  ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-3.5-turbo",
                    'messages' => [
                        [
                           "role" => "user",
                           "content" => $search
                       ]
                    ],
                    'temperature' => 0.5,
                    "max_tokens" => 200,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,
                    "stop" => ["11."],
                  ])
                  ->json();
                  $responseMessage = $data['choices'][0]['message']['content'];
                 $questions = explode("\n", $responseMessage);
                  // Create a new subject
                 $subName=$this->subGet($search);
                 $subject = Subject::firstOrCreate([
                    'subject_name' => $subName,
                ]);

                  // Insert questions associated with the subject
                  foreach ($questions as $line) {
              if($line!='')
             {       Question::create([
                          'subID' => $subject->id,
                          'question' => $line,
                      ]);
             }
            }

// return response()->json($data['choices'][0]['message'], 200, array(), JSON_PRETTY_PRINT);
return response()->json($data['choices'][0]['message']);
}



function subGet($var) {
    // Given string
    $string = $var;

    // Tokenize the string into individual words
    $tokens = explode(" ", $string);

    // Define a list of common subject words
    $subjectWords = ['english', 'history', 'science', 'math', 'geography']; // Add more subject words as needed

    // Find the first subject word that appears in the string
    $subjectName = '';
    foreach ($tokens as $token) {
        if (in_array(strtolower($token), $subjectWords)) {
            $subjectName = $token;
            break;
        }
    }

    // If no subject name is found, set a default value
    if (empty($subjectName)) {
        $subjectName = "Subject not found";
    }
    return $subjectName;
}


// public function subGet($var)
// {


//     // Given string
//     $string =$var;

//     // Create a whitespace tokenizer
//     $tokenizer = new WhitespaceTokenizer();

//     // Tokenize the string into individual words
//     $tokens = $tokenizer->tokenize($string);

//     // Define a list of common subject words
//     $subjectWords = ['english', 'history', 'science', 'math', 'geography']; // Add more subject words as needed

//     // Find the first subject word that appears in the string
//     $subjectName = '';
//     foreach ($tokens as $token) {
//         if (in_array(strtolower($token), $subjectWords)) {
//             $subjectName = $token;
//             break;
//         }
//     }

//     // If no subject name is found, set a default value
//     if (empty($subjectName)) {
//         $subjectName = "Subject not found";
//     }
//     return $subjectName;
// }
public function my()
{
    $search ='3 questions for math';

        $data = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
                  ])
                  ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-3.5-turbo",
                    'messages' => [
                        [
                           "role" => "user",
                           "content" => $search
                       ]
                    ],
                    'temperature' => 0.5,
                    "max_tokens" => 200,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,
                    "stop" => ["11."],
                  ])
                  ->json();
                  $subName=$this->subGet($search);
                  $responseMessage = $data['choices'][0]['message']['content'];
    $questions = explode("\n", $responseMessage);
                //   $responseMessage = $data['choices'][0]['message'];
                //   $questions = explode(PHP_EOL, $responseMessage);

     var_dump($subName);
    //  var_dump($questions );
    // var_dump($data);
    exit;
}
}
