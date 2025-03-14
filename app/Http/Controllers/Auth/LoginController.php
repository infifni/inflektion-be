<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\HttpResponseAsJsonException;
use App\Http\Controllers\Controller;
use App\Utils\ErrorCode;
use App\Utils\ErrorData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = [
                'grant_type' => 'client_credentials',
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
            ];

            $response = Http::asForm()->post(config('app.oauth_url').'/oauth/token', $data);
            $token = json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR);

            if ($response->failed()) {
                throw new HttpResponseAsJsonException(
                    Response::HTTP_UNAUTHORIZED,
                    new ErrorData(ErrorCode::UNAUTHORIZED, 'Invalid client credentials.'),
                );
            }

            return $this->successResponse(
                Response::HTTP_OK,
                'Successfully logged in.',
                [
                    'token_type' => $token->token_type,
                    'expires_in' => $token->expires_in,
                    'access_token' => $token->access_token,
                ]
            );
        } catch (HttpResponseAsJsonException $exception) {
            return $this->httpErrorResponse($exception);
        } catch (Exception|Throwable $exception) {
            return $this->internalErrorResponse($exception);
        }
    }
}
