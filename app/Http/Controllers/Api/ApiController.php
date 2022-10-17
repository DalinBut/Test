<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Filterable;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function okWithData($data = null, $msg = 'Request successfully'): JsonResponse
	{
		
		return response()->json([
			'data' => $data,
			'message' => $msg,
			'success' => true
		], Response::HTTP_OK);
	}

	 /**
     * OK response with data pagination
     *
     * @param mixed $data
     * @param string $msg
     * @return JsonResponse
     */
    protected function okWithDataPagination($data = null, $msg = 'Successful request'): JsonResponse
    {
        $data = $data->response()->getData(true);
        return response()->json([
            'message' => $msg,
            'success' => true,
            'data' => $data['data'],
            'links' => $data['links'],
            'meta' => $data['meta'],
        ], Response::HTTP_OK);
    }

	/**
     * OK response with data pagination
     *
     * @param mixed $data
     * @param string $msg
     * @return JsonResponse
     */
    protected function okWithDataCollectionPagination($data = null, $msg = 'Successful request'): JsonResponse
    {
		$data = $data instanceof LengthAwarePaginator ? $data->toArray() : (is_object($data) ? (array) $data : $data);
		
        return response()->json([
            'message' => $msg,
            'success' => true,
            'data' => array_merge([], $data["data"]),
            'links' => [
				"first" => $data["first_page_url"],
				"last" => $data["last_page_url"],
				"prev" => $data["prev_page_url"],
				"next" => $data["next_page_url"]
			],
            'meta' => [
				"current_page" => $data["current_page"],
				"from" => $data["from"],
				"last_page" => $data["last_page"],
				"links" => $data["links"],
				"path" => $data["path"],
				"per_page" => $data["per_page"],
				"to" => $data["to"],
				"total" => $data["total"]
			],
        ], Response::HTTP_OK);
    }

	protected function okWithAdditionalData($data = null, $msg = 'Request successfully')
	{
		if( is_array($data->additional) && !empty($data->additional)) {
			$data->additional['message'] =  $msg;
			$data->additional['success'] =  true;
			return $data;
		}
		return ;
	}

	protected function created($data, $msg = 'Create successfully'): JsonResponse
	{
		return response()->json([
			'data' => $data,
			'message' => $msg,
			'success' => true
		], Response::HTTP_CREATED);
	}

	protected function updated($data = null, $msg = 'Update successfully'): JsonResponse
	{
		return response()->json([
			'data' => $data,
			'message' => $msg,
			'success' => true
		]);
	}

	protected function deleted($data = null, $msg = 'Delete successfully'): JsonResponse
	{
		return response()->json([
			'data' => $data,
			'message' => $msg,
			'success' => true
		], Response::HTTP_OK);
	}

	protected function deletedReturnId($model, $msg = 'Delete successfully'): JsonResponse
	{
		return response()->json([
			'data' => [
				'id' => $model->getKey(),
			],
			'message' => $msg,
			'success' => true
		], Response::HTTP_OK);
	}

	protected function restored($data = null, $msg = 'Restore successfully'): JsonResponse
	{
		return response()->json([
			'data' => $data,
			'message' => $msg,
			'success' => true
		], Response::HTTP_OK);
	}

	protected function forceDeleted($data = null, $msg = 'Force delete successfully'): JsonResponse
	{
		return response()->json([
			'data' => $data,
			'message' => $msg,
			'success' => true
		], Response::HTTP_OK);
	}

	protected function okWithDataAndHeader($header, $data, $msg = 'Request successfully'): JsonResponse
	{

		return response()->json([
			'data' => $data,
			'header' => (new Filterable)->guessIdData($header),
			'message' => $msg,
			'success' => true
		], Response::HTTP_OK);
	}

	protected function okWithMsg($msg): JsonResponse
	{
		return response()->json([
			'message' => $msg,
			'success' => true
		], Response::HTTP_OK);
	}

	protected function msgWithCode($msg, $code, $success = false): JsonResponse
	{
		return response()->json([
			'message' => $msg,
			'success' => $success
		], $code);
	}

	protected function errors($errors): JsonResponse
	{
		return response()->json([
			'message' => __('The given data was invalid.'),
			'errors' => $errors,
			'success' => false
		], Response::HTTP_UNPROCESSABLE_ENTITY);
	}

	/**
     * Response with error message
     *
     * @param string $msg
     * @return JsonResponse
     */
    protected function errorMessage($msg = 'Error', $code = null): JsonResponse
    {
        return response()->json([
            'message' => $msg,
            'success' => false,
        ], $code ?? Response::HTTP_UNPROCESSABLE_ENTITY);
    }

	protected function noContent(): JsonResponse
	{
		return response()->json([], Response::HTTP_NO_CONTENT);
	}

	protected function file($fullPath, $name = null)
	{
		return response()->download($fullPath, $name ?? basename($fullPath));
	}
}