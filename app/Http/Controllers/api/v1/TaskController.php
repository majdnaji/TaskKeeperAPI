<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends ApiController
{
    public function __construct() {
        $this->middleware('role:admin', ['only' => ["store","destroy"]]);
        $this->middleware('role:admin|sub-admin', ['only' => ["update","setDeadline","assignToDepartment","revokeFromDepartment"]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function tasksByProject($project_id){

        if(auth()->user()->hasRole('employee'))
            $items=Task::where("project_id","=",$project_id)
                ->with("department")
                ->where("department_id","=",auth()->user()->department_id)
                ->paginate();
        else{
            $items=Task::where("project_id","=",$project_id)
                ->with("department")
                ->paginate();
        }


        if(count($items)>0) {
            $paginate=$this->formatPaginateData($items);
            return $this->apiResponse(TaskResource::collection($items),ApiController::STATUS_OK,"success",$paginate);
        }
        return $this->apiResponse(null,ApiController::STATUS_OK,"no data");

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        if($item=Task::create($request->validated())){

            return $this->apiResponse(new TaskResource($item->load("department")));
        }else{
            return $this->apiResponse(null,ApiController::SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item=Task::find($id);
        if($item) return $this->apiResponse(new TaskResource($item));
        return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $item=Task::find($id);
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
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item=Task::find($id);
        if(!$item)
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        if($item->delete())
            return $this->apiResponse();
        return $this->apiResponse(null,ApiController::SERVER_ERROR);
    }

    public function changeStatus(Request $request,$id){

        $item=Task::find($id);
        if(auth()->user()->hasRole("employee") && auth()->user()->department_id != $item->department_id){
            return $this->apiResponse(null,ApiController::STATUS_UNAUTHORIZED,"unauthorized action");
        }
        if(!$item){
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        }
        $item->status=$request["status"];
        if($item->save()){
            return $this->apiResponse(new TaskResource($item),ApiController::STATUS_OK,"success");
        }
        return $this->apiResponse(null,ApiController::SERVER_ERROR,"server error");
    }
    public function setDeadline(Request $request,$id){
        $valid=$request->validate([
            "deadline"=>"required|date"
        ]);
        $item=Task::find($id);
        if(!$item){
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        }
        $item->deadline=$valid["deadline"];
        if($item->save()){
            return $this->apiResponse(new TaskResource($item),ApiController::STATUS_OK,"success");
        }
        return $this->apiResponse(null,ApiController::SERVER_ERROR,"server error");
    }
    public function assignToDepartment(Request $request,$id){
        $valid=$request->validate([
            "department_id"=>"required|exists:departments,id"
        ]);
        $item=Task::find($id);
        if(!$item){
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        }
        $item->department_id=$valid["department_id"];
        if($item->save()){
            return $this->apiResponse(new TaskResource($item),ApiController::STATUS_OK,"success");
        }
        return $this->apiResponse(null,ApiController::SERVER_ERROR,"server error");
    }
    public function revokeFromDepartment(Request $request,$id){
        $item=Task::find($id);
        if(!$item){
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        }
        $item->department_id=null;
        if($item->save()){
            return $this->apiResponse(new TaskResource($item),ApiController::STATUS_OK,"success");
        }
        return $this->apiResponse(null,ApiController::SERVER_ERROR,"server error");
    }
}
