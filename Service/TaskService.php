<?php

class TaskService
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
    public function queryForTasks()
    {
        $taskArray = $this->databaseService->getData('SELECT * FROM taak');
        return $taskArray;
    }

    public function queryForTaskByID($id)
    {
        $taskArray = $this->databaseService->getData("SELECT * FROM taak WHERE taa_id = '" . $id . "'");
        return $taskArray;
    }

    public function getTaskDescriptionByDate($date)
    {
        $i = 0;
        $taskArray = $this->databaseService->getData("SELECT * FROM taak WHERE taa_datum = '". $date . "'");

        if (!$taskArray) {
            return null;
        }

        foreach ($taskArray as $task)
        {
            $tasks[$i] = $this->createTaskFromData($task);
            $i++;
        }

        return $tasks;
    }

    public function writeTaskToDatabase(Task $task)
    {
        // sanitize
        $task->setOmschr(htmlspecialchars(strip_tags($task->getOmschr())));
        $task->setDatum(htmlspecialchars(strip_tags($task->getDatum())));


        $sql = "INSERT INTO taak SET taa_datum = '" . $task->getDatum() . "', taa_omschr = '" . $task->getOmschr() . "'";

        return $this->databaseService->executeSQL($sql);
    }

    public function updateTaskInDatabase(Task $task)
    {
        // sanitize
        $task->setOmschr(htmlspecialchars(strip_tags($task->getOmschr())));
        $task->setDatum(htmlspecialchars(strip_tags($task->getDatum())));
        $task->setStatus(htmlspecialchars(strip_tags($task->getStatus())));

        $sql = "UPDATE taak SET taa_datum = '" . $task->getDatum() . "',taa_status = '1', taa_omschr = '" . $task->getOmschr() . "' WHERE taa_id = '" . $task->getId() . "'";

        return $this->databaseService->executeSQL($sql);
    }

    public function deleteTask(Task $task)
    {
        $sql = "DELETE FROM taak WHERE taa_id = '" . $task->getId() . "'";

        return $this->databaseService->executeSQL($sql);
    }
    public function updateStatus(Task $task){
        $id=$task->getID();

        $sql = "Update taak SET taa_status = 1 WHERE taa_id = 2";
        return $this->databaseService->executeSQL($sql);

    }
}