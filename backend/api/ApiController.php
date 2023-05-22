<?php


namespace api;


abstract class ApiController extends \Redbox\Core\AbstractController
{
    public $serializer = Serializer::class;
}