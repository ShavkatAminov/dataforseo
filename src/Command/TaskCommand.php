<?php

namespace App\Command;

use App\Command\Question\TaskCreateQuestion;
use App\Entity\Task;
use App\Repository\LocationRepository;
use App\Repository\SystemRepository;
use App\Service\DataForSeo;
use App\Service\TaskService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskCommand extends Command
{
    private DataForSeo $dataForSeo;
    private SystemRepository $systemRepository;
    private LocationRepository $locationRepository;
    private TaskService $taskService;

    public function __construct(
        DataForSeo         $dataForSeo,
        SystemRepository   $systemRepository,
        LocationRepository $locationRepository,
        TaskService        $taskService,
        string             $name = null
    )
    {
        $this->dataForSeo = $dataForSeo;
        $this->systemRepository = $systemRepository;
        $this->locationRepository = $locationRepository;
        $this->taskService = $taskService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('task:create')
            ->setHelp('This command helps ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $question = new TaskCreateQuestion(
            $this->systemRepository,
            $this->locationRepository,
            $input,
            $output,
            $this->getHelper('question')
        );

        $system = $question->getSystem();

        $location = $question->getLocation($system);

        $keyword = $question->getKeyword(false);

        // Create task in dataForSeo
        $response = $this->dataForSeo->createTask($system, $location, $keyword);

        // save created tasks to db
        $tasks = $this->taskService->create($response->toArray(), $system);

        // print task ids to table
        $table = new Table($output);
        $table->setHeaders(['ID', 'System', 'Location', 'Keyword']);
        $rows = [];
        /** @var Task $task */
        foreach ($tasks as $task) {
            $rows[] = [
                $task->getTaskId(),
                $task->getSystem()->getName(),
                $task->getLocationName(),
                $task->getKeyword()
            ];
            $rows[] = new TableSeparator();
        }
        array_pop($rows);
        $table->setRows($rows);
        $table->render();

        return self::SUCCESS;
    }
}