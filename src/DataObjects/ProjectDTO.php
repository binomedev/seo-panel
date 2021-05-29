<?php


namespace Binomedev\SeoPanel\DataObjects;


use Spatie\DataTransferObject\DataTransferObject;

class ProjectDTO extends DataTransferObject
{

    public string $name;
    public string $url;
    public string $api_key;
    public string $notes;
    public \Arr $meta;

}
