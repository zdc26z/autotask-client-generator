<?php

namespace Tests\Mocks;

use Anteris\Autotask\Client;
use Anteris\Autotask\HttpClient;
use Illuminate\Support\Collection;
use Faker\Factory as Faketory;
use Faker\Generator as Faker;
use Carbon\Carbon;
use Mockery;

class ClientMock extends Client
{
    protected HttpClient $client;
    protected array $classCache = [];
    private Faker $faker;

    public function __construct() 
    {
        $this->client = new HttpClientMock();
        $this->faker = Faketory::create();

        $methods = get_class_methods($this);
        foreach($methods as $method) {
            if("__construct" === $method || "mockResults" === $method || "mockValues" === $method) {
                continue;
            }
            $keyName = ucfirst($method);
            if ("ies" === substr($keyName, -3)) {
                $singular = substr($keyName, 0, -3) . 'y';
            } else if ("es" === substr($keyName, -2)) {
                switch($method) {
                    case 'tagAliases':
                    case 'taxes':
                        $singular = substr($keyName, 0, -2);
                        break;
                    default:
                    $singular = substr($keyName, 0, -1);
                    break;
                }
            } else if ("s" === $keyName[-1]) {
                $singular = substr($keyName, 0, -1);
            } else {
                $singular = $keyName;
            }

            $serviceName = $singular . 'Service';
            $qbName = $singular . 'QueryBuilder';
            $collectionName = $singular . 'Collection';

            $namespace = 'Anteris\Autotask\API\\' . $keyName . '\\';
            $serviceClass = $namespace . $serviceName;
            $qbClass = $namespace . $qbName;
            $collectionClass = $namespace . $collectionName;

            $serviceMock = Mockery::mock($serviceClass);
            $qbMock = Mockery::mock($qbClass);
            $collectionMock = Mockery::mock($collectionClass);

            $serviceMock->shouldReceive('query')->andReturn($qbMock);
            $qbMock
            ->shouldReceive('where')
            ->andReturnSelf()

            ->shouldReceive('records')
            ->andReturnSelf()

            ->shouldReceive('get')
            ->andReturn($this->mockResults($namespace, $singular));

            $this->classCache[$keyName] = $serviceMock;
        }
    }

    public static function mockValues(Faker $faker, string $entity)
    {
        $reflection = new \ReflectionClass($entity);
        $properties = $reflection->getProperties();
        $result = array();

        foreach($properties as $property) {
            if('_' === $property->name[0]) {
                continue;
            }
            $type = $property->getType();
            $required = true;
            if(!is_null($type)) {
                $type = $type->__toString();
                if('?' === $type[0]) {
                    $required = false;
                    $type = substr($type, 1);
                }

                if(stristr($type, '|')) {
                    $type = str_replace([
                        'array',
                        'null',
                        '|',
                    ], '', $type);
                }

                if($required || $faker->boolean()) {
                    switch($type) {
                        case 'bool':
                            $result[$property->name] = $faker->boolean();
                            break;
                        case 'int':
                            $result[$property->name] = $faker->randomNumber();
                            break;
                        case 'array':
                            $result[$property->name] = [];
                            break;
                        case 'float':
                            $result[$property->name] = $faker->randomFloat();
                            break;
                        case 'Carbon\Carbon':
                            $result[$property->name] = new Carbon($faker->dateTime());
                            break;
                        default:
                        var_dump($type);
                        case 'mixed':
                        case 'string':
                            $result[$property->name] = $faker->word();
                            break;
                    }
                }
            }
        }

        return $result;
    }

    private function mockResults(string $namespace, string $singular): Collection
    {
        $entity = $namespace .$singular . 'Entity';
        $collection = $namespace . $singular . 'Collection';
        $results = [];
        $count = rand(1, 10);

        for($i=0; $i<$count; $i++) {
            $result = $this->mockValues($this->faker, $entity);

            $results[$i] = new $entity(...$result);
        }

        return $collection::make($results);
    }
}
