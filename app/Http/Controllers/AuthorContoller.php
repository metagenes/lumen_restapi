<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthorController extends Controller
{

    /**
     *
     * Function to show list repository response as json
     *
     */

    public function githubRepo()
    {
        try {
            $client = new \GuzzleHttp\Client();
            // $response = $client->request('GET','https://api.mocki.io/v1/b043df5a');
            $response = $client->request('GET', 'https://api.github.com/users/metagenes/repos');
            // dd($response->message);
            $contents = json_decode($response->getBody()->getContents());
            $data = [];
            foreach($contents as $item => $value){
                $temp  = $this->item($value);
                $data[]= $temp;
            }
            if($response->getStatusCode() == 200)
            return response()->json(['message' => 'success', 'code' => $response->getStatusCode(), 'result' => $data]);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed', 'code' => 500]);
        }

    }

    /**
     *
     * function to get url repo, desccription and updated date
     *
     * @param object $value
     */
    public function item($value)
    {
        $temp                = new \stdClass();
        $temp->url_html      = $value->html_url;
        $temp->description   = $value->description;
        $temp->last_update   = date("d-m-Y h:i:s", strtotime($value->updated_at));
        return $temp;
    }

}
