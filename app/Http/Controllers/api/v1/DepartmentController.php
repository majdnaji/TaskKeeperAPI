<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Department::paginate();
        if(count($items)>0){
            $paginateData = $this->formatPaginateData($items);
            return $this->apiResponse(DepartmentResource::collection($items), self::STATUS_OK, __('site.get_successfully'),$paginateData);
        }
        return $this->apiResponse([], self::STATUS_OK, __('site.there_is_no_data'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item=Department::find($id);
        if(!$item)
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        if($item->delete())
            return $this->apiResponse();
        return $this->apiResponse(null,ApiController::SERVER_ERROR);
    }
}
