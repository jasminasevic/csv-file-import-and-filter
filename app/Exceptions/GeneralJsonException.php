<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralJsonException extends Exception
{
    //
    /*
     * Report the exception
     *
     * @return void
     */

    public function report(){

    }

    //
    /*
     * Render the exception as an HTTP response
     *
     * @param \Illuminate\Http\Request $request
     */

    public function render($request){
        return new JsonResource([
           'errors' => [
               'message' => $this->getMessage()
           ]
        ], $this->getCode());
    }
}
