<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Tweet;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $job = Job::where('type', $type)->get()->last();
        switch ($type) {
            case 1:
                if (empty($job)) {
                    $job = new Job();
                    $job->max_id = '0';
                    $job->since_id = '0';
                    $job->type = 1;
                    $job->save();
                }
                return response(json_encode($job));
                break;
            case 2: // Spider type 2 starts from since_id(id in unispider system) and get tweets' html_content
                $jobs = Tweet::where('html_content', null)
                    ->orderBy('origin_created_at', 'desc')
                    ->take(20)
                    ->get()
                    ->pluck('origin_id');
                return response(json_encode($jobs));
                break;
            default:
                return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($type, Request $request)
    {
        $job = new Job();
        $job->max_id = $request->input('max_id');
        $job->since_id = $request->input('since_id');
        $job->type = $type;
        $job->save();
        return response('Job updated.\n' . json_encode($job));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
