<?php

namespace App\Http\Controllers\SuccessfulEmail;

use App\Actions\CreateSuccessfulEmailAction;
use App\Actions\DeleteSuccessfulEmailAction;
use App\Actions\UpdateSuccessfulEmailAction;
use App\Exceptions\HttpResponseAsJsonException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSuccessfulEmailRequest;
use App\Http\Requests\UpdateSuccessfulEmailRequest;
use App\Http\Resources\SuccessfulEmailResource;
use App\Repositories\SuccessfulEmailRepositoryInterface;
use App\Utils\ErrorCode;
use App\Utils\ErrorData;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SuccessfulEmailResourceController extends Controller
{
    public function index(SuccessfulEmailRepositoryInterface $repository)
    {
        try {
            $successfulEmails = $repository->get();

            return SuccessfulEmailResource::collection($successfulEmails);
        } catch (HttpResponseAsJsonException $exception) {
            return $this->httpErrorResponse($exception);
        } catch (Exception $exception) {
            return $this->serverErrorResponse($exception);
        }
    }

    public function show(
        int $id,
        SuccessfulEmailRepositoryInterface $repository
    ) {
        try {
            $successfulEmail = $repository->find($id);

            if (! $successfulEmail) {
                throw new HttpResponseAsJsonException(
                    Response::HTTP_BAD_REQUEST,
                    new ErrorData(ErrorCode::RECORD_NOT_FOUND, 'Record not found'),
                );
            }

            return new SuccessfulEmailResource($successfulEmail);
        } catch (HttpResponseAsJsonException $exception) {
            return $this->httpErrorResponse($exception);
        } catch (Exception $exception) {
            return $this->serverErrorResponse($exception);
        }

    }

    public function store(
        CreateSuccessfulEmailRequest $request,
        CreateSuccessfulEmailAction $action,
    ): SuccessfulEmailResource {
        DB::beginTransaction();
        try {

            $successfulEmail = $action->execute($request);

            DB::commit();

            return new SuccessfulEmailResource($successfulEmail);
        } catch (HttpResponseAsJsonException $exception) {
            DB::rollBack();

            return $this->httpErrorResponse($exception);
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->serverErrorResponse($exception);
        }
    }

    public function update(
        UpdateSuccessfulEmailRequest $request,
        SuccessfulEmailRepositoryInterface $repository,
        UpdateSuccessfulEmailAction $action,
    ): SuccessfulEmailResource {
        DB::beginTransaction();
        try {
            $successfulEmail = $repository->find($request->id);

            if (! $successfulEmail) {
                throw new HttpResponseAsJsonException(
                    Response::HTTP_BAD_REQUEST,
                    new ErrorData(ErrorCode::RECORD_NOT_FOUND, 'Record not found'),
                );
            }

            $successfulEmail = $action->execute($request, $successfulEmail);

            DB::commit();

            return new SuccessfulEmailResource($successfulEmail);
        } catch (HttpResponseAsJsonException $exception) {
            DB::rollBack();

            return $this->httpErrorResponse($exception);
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->serverErrorResponse($exception);
        }
    }

    public function delete(
        int $id,
        SuccessfulEmailRepositoryInterface $repository,
        DeleteSuccessfulEmailAction $action,
    ) {
        DB::beginTransaction();
        try {
            $successfulEmail = $repository->find($id);

            if (! $successfulEmail) {
                throw new HttpResponseAsJsonException(
                    Response::HTTP_BAD_REQUEST,
                    new ErrorData(ErrorCode::RECORD_NOT_FOUND, 'Record not found'),
                );
            }

            $action->execute($successfulEmail);

            DB::commit();

            return $this->successResponse(
                Response::HTTP_OK,
                'Record deleted successfully.'
            );

        } catch (HttpResponseAsJsonException $exception) {
            DB::rollBack();

            return $this->httpErrorResponse($exception);
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->serverErrorResponse($exception);
        }
    }
}
