<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RestController
{
    /**
     * Shortcut function to get the attributes from a request while running the validations
     * @param Request $request
     * @param array $attrs_or_validations
     * @param array $addtl_fields
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function getFromReq($request, $attrs_or_validations, $addtl_fields=null)
    {
        # See if a list of values is passed in, or if a validation list is passed in
        $is_validation = false;
        if(\count(array_filter(array_keys($attrs_or_validations), '\is_string')) > 0) {
            $is_validation = true;
        }

        if($is_validation) {
            $this->validate($request, $attrs_or_validations);
        }

        $fields = [];
        foreach($attrs_or_validations as $idx => $field) {
            if($is_validation) {
                $field = $idx;
            }

            if($request instanceof Request) {
                if ($request->filled($field)) {
                    $fields[$field] = $request->input($field);
                }
            } else {
                if(array_key_exists($field, $request)) {
                    $fields[$field] = $request[$field];
                }
            }
        }

        if(!empty($addtl_fields) && \is_array($addtl_fields)) {
            $fields = array_merge($fields, $addtl_fields);
        }

        return $fields;
    }

    /**
     * Run a validation
     * @param $request
     * @param $rules
     * @return bool
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function validate($request, $rules)
    {
        if($request instanceof Request) {
            $validator = Validator::make($request->all(), $rules);
        } else {
            $validator = Validator::make($request, $rules);
        }

        if (!$validator->passes()) {
            throw new BadRequestHttpException($validator->errors(), null, 400);
        }

        return true;
    }

    /**
     * Simple normalized method for forming the JSON responses
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function message($message, $count=null)
    {
        $attrs = [
            'message' => $message
        ];

        if($count !== null) {
            $attrs['count'] = $count;
        }

        return response()->json($attrs);
    }
}
