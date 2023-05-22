<?php


namespace api;

abstract class ApiActiveController extends \Redbox\Core\AbstractActiveController
{
    public $serializer = [
        'class' => RestSerializer::class,
        'collectionEnvelope' => 'data',
    ];
}