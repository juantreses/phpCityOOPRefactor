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
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);
        return json_encode($this->taskService->queryForTasks());
    }

    public function create()
    {
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
}