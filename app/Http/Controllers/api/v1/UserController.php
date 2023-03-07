<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use function Nette\Utils\save;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=User::paginate();
        if(count($items)>0){
            $paginateData = $this->formatPaginateData($items);
            return $this->apiResponse(UserResource::collection($items), self::STATUS_OK, __('site.get_successfully'),$paginateData);
        }
        return $this->apiResponse([], self::STATUS_OK, "no data");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if($user=User::create($request->validated())){
            $user->assignRole($request['role']);
            return $this->apiResponse(["user"=>new UserResource($user->load("department"))]);
        }else{
            return $this->apiResponse(null,ApiController::SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item=User::find($id);
        if($item) return $this->apiResponse(new UserResource($item));
        return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, int $id)
    {
        $item=User::find($id);
        if(!$item)
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);

        if($item->update($request->validated())){
            $item->syncroles($request['role']);
            return $this->apiResponse($item);
        }
        return $this->apiResponse(null,ApiController::SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        if(!$user)
            return $this->apiResponse(null,ApiController::STATUS_NOT_FOUND);
        if($user->delete())
            return $this->apiResponse();
        return $this->apiResponse(null,ApiController::SERVER_ERROR);
    }
}
