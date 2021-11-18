<?php

namespace App\Command\Question;

use App\Entity\System;
use App\Repository\LocationRepository;
use App\Repository\SystemRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class TaskCreateQuestion
{
    private SystemRepository $systemRepository;
    private LocationRepository $locationRepository;
    private InputInterface $input;
    private OutputInterface $output;
    private $helper;

    public function __construct(
        SystemRepository $systemRepository,
        LocationRepository $locationRepository,
        InputInterface   $input,
        OutputInterface  $output,
                         $helper
    )
    {
        $this->systemRepository = $systemRepository;
        $this->locationRepository = $locationRepository;
        $this->input = $input;
        $this->output = $output;
        $this->helper = $helper;
    }

    public function getSystem(bool $writeResult = true): ?System
    {
        $question = new ChoiceQuestion(
            'Please select search system',
            array_column($this->systemRepository->findActiveAllAsArray(), 'name'),
            0
        );

        $name = $this->helper->ask($this->input, $this->output, $question);

        if ($writeResult)
            $this->output->writeln('System: ' . $name);

        return $this->systemRepository->findOneBy(['name' => $name]);
    }

    public function getLocation(System $system, bool $writeResult = true)
    {
        $locations = array_column($this->locationRepository->findSystemLocationsAsArray($system), 'location_name');

        $question = new Question('<fg=green>Please enter location:</> ', 'United States');

        $question->setAutocompleterValues($locations);

        $location = $this->helper->ask($this->input, $this->output, $question);

        if ($writeResult)
            $this->output->writeln('Location: ' . $location);

        return $location;
    }

    public function getKeyword(bool $writeResult = true)
    {
        $question = new Question('<fg=green>Please enter keyword for searching:</> ');

        $question->setValidator(function ($answer) {
            if (strlen($answer) == 0) {
                throw new \RuntimeException(
                    'Please enter keyword for searching'
                );
            }
            return $answer;
        });

        $keyword = $this->helper->ask($this->input, $this->output, $question);

        if ($writeResult)
            $this->output->writeln('Keyword: ' . $keyword);

        return $keyword;
    }


}