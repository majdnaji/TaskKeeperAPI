<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Project::paginate();
        if(count($items)>0){
            $paginateData = $this->formatPaginateData($items);
            return $this->apiResponse(ProjectResource::collection($items), self::STATUS_OK, __('site.get_successfully'),$paginateData);
        }
        return $this->apiResponse([], self::STATUS_OK, __('site.there_is_no_data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        if($item=Project::create($request->validated())){

            return $this->apiResponse($item);
        }else{
            return $this->apiResponse(null,ApiController::SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item=Project::find($id);
        if($item)
            return $this->apiResponse($item);
        return $this->apiResponse("",ApiController::STATUS_OK,"no data");
    }



    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $item=Project::find($id);
        if(!$item)
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);

        if($item->update($request->validated())){
            return $this->apiResponse($item);
        }
        return $this->apiResponse(null,ApiController::SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=Project::find($id);
        if(!$user)
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        if($user->delete())
            return $this->apiResponse();
        return $this->apiResponse(null,ApiController::SERVER_ERROR);
    }
}
