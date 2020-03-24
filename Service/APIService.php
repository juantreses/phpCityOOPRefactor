<?php


class APIService
{
    private $taskService;
    private $databaseService;

    public function __construct(TaskService $taskService, DatabaseService $databaseService)
    {
        $this->taskService = $taskService;
        $this->databaseService = $databaseService;
    }

    public function read()
    {

        http_response_code(200);
        return json_encode($this->taskService->queryForTasks());
    }

    public function readOne($id)
    {

        //Check if there is a task with given id in Database
        $task = $this->taskService->queryForTaskByID($id);

        if (count($task) == 0) {
            http_response_code(400);
            return json_encode(array("message" => "No task found at this ID"));
        }
        else {
            http_response_code(200);
            return json_encode($task);
        }


    }

    public function create()
    {

        $task = new Task();

        // get posted data
        $data = json_decode(file_get_contents("php://input"));

        // make sure data is not empty
        if(!empty($data->taa_datum) && !empty($data->taa_omschr)){

            // set task property values
            $task->setDatum($data->taa_datum);
            $task->setOmschr($data->taa_omschr);

            //create task
            if ($this->taskService->writeTaskToDatabase($task)){
                // set response code - 201 created
                http_response_code(201);
                return json_encode(array("message" => "Task was created."));
            } else {
                // set response code - 503 service unavailable
                http_response_code(503);
                return json_encode(array("message" => "Unable to create task."));
            }
        }
        else {
            // set response code - 400 bad request
            http_response_code(400);
            return json_encode(array("message" => "Unable to create task. Data is incomplete."));
        }
    }

    public function delete($lastUriPart) {

        $task = new Task();

        $task->setId($lastUriPart);

        if ($this->taskService->deleteTask($task)) {
            http_response_code(200);
            return json_encode(array("message" => "Task was deleted."));
        }
        else {
            http_response_code(503);
            return json_encode(array("message" => "Unable to delete task."));
        }
    }

    public function update($id)
    {


        $sql = "Update taak SET taa_status = 1 WHERE taa_id = '$id'";
        return $this->databaseService->executeSQL($sql);

    }

}