<?php
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class MainController extends Controller{
        /**
         * @Route("/", name="index")
         */
        public function index(){
            return $this->render('main\index.html.twig');
        }

        /**
         * @Route("/weatherapi", name="weatherapi")
         * @Method({"POST"})
         */
        public function weatherapi(Request $request){
            #get post data
            #TO-DO verify data
            $apikey = $request->request->get('apikey');
            $city = $request->request->get('city'); 
            
            #api url
            $apiurl = 'http://api.openweathermap.org/data/2.5/weather?q=%s&APPID=%s&units=metric';
            $request = sprintf($apiurl, $city, $apikey);
            
            #make API call and get data
            #TO-DO make exceptions for HTTP/1.1 401 Unauthorized           
            $response  = file_get_contents($request);
            $jsondata  = json_decode($response);
            
            #TO-DO instead of json, return html. easier to append
            return new JsonResponse($jsondata);
        }
    }