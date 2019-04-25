namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Helpers\FaceDetector;
use App\Traits\ImageTrait;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Client;

class PilpresController extends Controller
{

    public function index()
    {   
        
            return view('welcome');
        
    }
    public function api(Request $request)
    {   
        $client = new Client(['verify' => false]); //GuzzleHttp\Client
        try {
            // $key = '5c99ce41e70a1e6ff09fca83580020a0';
            $headers = [
                'Accept' => 'application/json',
            ];
            $result = $client->request('GET','https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json' ,[
                'headers' => $headers
            ]);
            $final = json_decode($result->getBody()->getContents(),true);
            for($i=0; $i<count($final['chart']);$i++) {
                $prabowo = $final['chart']['22'];
                $jokowi = $final['chart']['21'];
                return response()->json([
                    'jokowi' => $jokowi,
                    'prabowo' => $prabowo
                ],200);
            } 
        } catch(BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = $response->getBody();
            return response()->json(json_decode($jsonBody),$response->getStatusCode());
        }
    }
    public function proggress(Request $request)
    {    
        $client = new Client(['verify' => false]); //GuzzleHttp\Client
        try {
            // $key = '5c99ce41e70a1e6ff09fca83580020a0';
            $headers = [
                'Accept' => 'application/json',
            ];
            $result = $client->request('GET','https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json' ,[
                'headers' => $headers
            ]);
            $final = json_decode($result->getBody()->getContents(),true);
            for($i=0; $i<count($final['progress']);$i++) {
                $total = $final['progress']['total'];
                $proses = $final['progress']['proses'];
        
                return response()->json([
                    'total' => $total,
                    'prosses' => $proses
                ],200);
            }
        } catch(BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = $response->getBody();
            return response()->json(json_decode($jsonBody),$response->getStatusCode());
        }
    }
    public function uploadImage(Request $request)
    {
        $data = User::where('id',3)->first();
        if($data){
            $image = $this->singleUpload($request,'photo','photo');
            $detector = new FaceDetector;
            $detector->faceDetect($request->file('photo'));
            $data->update([
                'photo' => $image
            ]);

            // return $detector->toJson();
            return response()->json([
                'message' => $detector->toJpeg()
            ],200);
        }
        return response()->json(['message' => 'error'],500);
    }
    public function runPython(Request $request)
    {
        $process = new Process(public_path('live2.py'));
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        echo $process->getOutput();
    }
}