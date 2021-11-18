<?php

namespace App\Service;

use App\Entity\System;
use App\Entity\Task;

class TaskService extends BaseService
{
    public function create(array $data, System $system)
    {
        $tasks = [];
        foreach ($data['tasks'] as $item){
            $task = new Task();
            $task
                ->setTaskId($item['id'])
                ->setLocationName($item['data']['location_name'])
                ->setKeyword($item['data']['keyword'])
                ->setSystem($system)
                ->setResult($item['result'])
                ->setCreatedAt();
            $this->entityManager->persist($task);
            $tasks[] = $task;
        }
        $this->entityManager->flush();

        return $tasks;
    }
}