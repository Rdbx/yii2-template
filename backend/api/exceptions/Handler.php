<?php


namespace api\exceptions;


use common\components\confirmPhone\RequestPhoneConfirmationFilter;
use common\exceptions\PhoneConfirmException;
use common\exceptions\ValidationException;
use Redbox\AdvanceActiveRecord\Exceptions\ValidateException;
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

        if ($ex instanceof ValidateException) {
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

