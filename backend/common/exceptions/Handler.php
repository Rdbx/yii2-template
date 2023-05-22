<?php


namespace common\exceptions;


use common\components\CheckPhoneCodeService;
use yii\web\ErrorHandler;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class Handler extends ErrorHandler
{
    /**
     * @var int maximum number of trace source code lines to be displayed. Defaults to 13.
     */
    public $maxTraceSourceLines = 1;

    protected function renderException($ex)
    {
        $response = \Yii::$app->getResponse();
        $request = \Yii::$app->getRequest();
        $response->format = Response::FORMAT_JSON;

        if ($request->headers->get("X-DEBUG", false) === "true"
            || $request->get("debug", false) === "true"
        ) {
            $exceptionTrace = $ex->getTrace();
            $traces = array_slice($exceptionTrace, 0,
                $this->maxTraceSourceLines);

            $debug = [
                "debug" => [
                    "exception" => [
                        "code"    => $ex->getCode(),
                        "message" => $ex->getMessage(),
                        "file"    => $ex->getFile(),
                        "line"    => $ex->getLine(),
                        "trace"   => $traces ?? null
                    ]
                ]
            ];
        }

        if ($ex instanceof PhoneConfirmException) {
            $response->statusCode = $ex->statusCode;

            if ($ex->timeout) {
                $response->headers->add(CheckPhoneCodeService::HEADER_TIMEOUT, $ex->timeout);
            }

            if ($ex->isRequiredCodeHeader) {
                $response->headers->add(CheckPhoneCodeService::HEADER_CODE_REQUIRED, "true");
            }

            if ($ex->phoneAttempt) {
                $response->headers->add(CheckPhoneCodeService::HEADER_ATTEMPT, $ex->phoneAttempt);
            }

            if ($ex->phoneAttemptLeft) {
                $response->headers->add(CheckPhoneCodeService::HEADER_ATTEMPT_LEFT, $ex->phoneAttemptLeft);
            }

            $data = array_merge([
                "errors" => [
                    "message" => $ex->getMessage()
                ],
            ], $debug ?? []);
        }

        if ($ex instanceof ValidationException) {
            $response->statusCode = $ex->statusCode;

            $data = array_merge([
                "errors" => [
                    "message"  => "Ошибка валидации",
                    "messages" => $ex->errors
                ],
            ], $debug ?? []);
        } else {
            if ($ex instanceof UnauthorizedHttpException) {
                $response->statusCode = $ex->statusCode;
                $data = array_merge([
                    "errors" => [
                        "message" => "Не авторизован"
                    ],
                ], $debug ?? []);
            } else {
                if ($ex instanceof ForbiddenHttpException) {
                    $response->statusCode = $ex->statusCode;

                    $data = array_merge([
                        "errors" => [
                            "message" => "Доступ запрещён"
                        ],
                    ], $debug ?? []);
                } else {
                    if ($ex instanceof HttpException) {
                        $response->statusCode = $ex->statusCode;
                        $data = array_merge([
                            "errors" => [
                                "message" => $ex->getMessage()
                            ],
                        ], $debug ?? []);
                    } else {
                        if ($ex instanceof \Throwable) {
                            $response->statusCode = 400;
                            $data = array_merge([
                                "errors" => [
                                    "message" => $ex->getMessage()
                                ],
                            ], $debug ?? []);
                        } else {
                            if($ex instanceof RequireConfirmPhoneException){
                                $response->statusCode = 400;
                                $data = array_merge([
                                    "errors" => [
                                        "message" => $ex->getMessage()
                                    ],
                                ], $debug ?? []);
                            }
                        }
                    }
                }
            }
        }

        if ($response->format === Response::FORMAT_JSON) {
            $response->content = json_encode($data);
        }
        if ($response->format === Response::FORMAT_RAW) {
            $response->content = $data;
        }

        $response->send();
    }
}

