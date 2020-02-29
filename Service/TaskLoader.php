<?php

class TaskLoader
{
    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * @param $date
     * @return City[]
     */
    public function getTasks()
    {
        $tasksData = $this->queryForTasks();

        $tasks = array();
        foreach ($tasksData as $taskData) {
            $tasks[] = $this->createTaskFromData($taskData);
        }

        return $tasks;
    }

    /**
     * @param array $taskData
     * @return Task
     */
    private function createTaskFromData(array $taskData)
    {
        $task = new Task();
        $task->setId($taskData['taa_id']);
        $task->setDatum($taskData['taa_datum']);
        $task->setOmschr($taskData['taa_omschr']);

        return $task;
    }

    /**
     * @return array
     */
    private function queryForTasks()
    {
        $taskArray = $this->databaseService->getData('SELECT * FROM taak');
        return $taskArray;
    }

    public function getTasksForAWeek($date)
    {
        $taskArray = $this->databaseService->getData("SELECT * FROM images WHERE img_id = ". $id);


        if (!$taskArray) {
            return null;
        }

        $tasks[] = $this->createTaskFromData($taskArray[0]);

        return $tasks;
    }




}