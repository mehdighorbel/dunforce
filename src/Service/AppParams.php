<?php
/**
 * Created by PhpStorm.
 * User: ELLIGY
 * Date: 20/03/2020
 * Time: 19:15
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Yaml\Yaml;

class AppParams
{
    protected $em;
    protected $targetDirectory;
    protected $functions;

    public function __construct(
        EntityManagerInterface $entityManager,
        $targetDirectory,
        Functions $functions
    )
    {
        $this->em = $entityManager;
        $this->targetDirectory = $targetDirectory;
        $this->functions = $functions;
    }

    protected function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function getAllParams()
    {
        $appParams = Yaml::parseFile($this->getTargetDirectory())["organizations"];
        return $appParams;
    }

    public function getParamByName($name)
    {
        $appParams = Yaml::parseFile($this->getTargetDirectory())["organizations"];
        $paramKey = $this->functions->multi_array_search('name',$name,$appParams);
        return $paramKey !== null ? $appParams[$paramKey] : null;
    }

    public function deleteParam($name)
    {
        $appParams = Yaml::parseFile($this->getTargetDirectory())["organizations"];
        $paramKey = $this->functions->multi_array_search('name',$name,$appParams);
        if ($paramKey !== null){
            unset($appParams[$paramKey]);
            $newParams = ["organizations" => $appParams];
            $appParamsYAML = Yaml::dump($newParams,5,5);
            file_put_contents($this->getTargetDirectory(), $appParamsYAML);
        }
    }

    public function setParamByName($name, array $value)
    {
        $appParams = Yaml::parseFile($this->getTargetDirectory())["organizations"];
        $paramKey = $this->functions->multi_array_search('name',$name,$appParams);
        unset($appParams[$paramKey]);
        array_push($appParams,$value);
        $newParams = ["organizations" => $appParams];
        $appParamsYML = Yaml::dump($newParams,5,5);
        file_put_contents($this->getTargetDirectory(), $appParamsYML);
    }
}
