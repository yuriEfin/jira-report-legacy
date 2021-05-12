<?php

namespace App\Command;

use App\Dto\Issue\IssueDto;
use App\Service\Jira\Interfaces\IssueManagerInterface;
use App\Service\Jira\IssueManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class JiraSetTaskPropertyCommand extends Command
{
    protected static $defaultName = 'jira';
    private $issueManager;
    
    public function __construct(string $name = null, IssueManager $issueManager)
    {
        $this->issueManager = $issueManager;
        parent::__construct($name);
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Задачи JIRA - проставить label|version|component')
            ->setHelp('jira [-keysPath|--pathDataKeys PATHDATAKEYS] [-issue|--issueKey ISSUEKEY] [-fv|--fixVersion FIXVERSION] [-av|--affectedVersion AFFECTEDVERSION] [-s|--status STATUS] [--label LABEL] [-pr|--priority PRIORITY]')
            ->addOption('pathDataKeys', 'keysPath', InputArgument::OPTIONAL, 'issue key path file')
            ->addOption('issueKey', 'issue', InputArgument::OPTIONAL, 'issue key')
            ->addOption('fixVersion', 'fv', InputArgument::OPTIONAL, 'fixVersion')
            ->addOption('affectedVersion', 'av', InputArgument::OPTIONAL, 'affectedVersion')
            ->addOption('status', 's', InputArgument::OPTIONAL, 'status')
            ->addOption('label', null, InputArgument::OPTIONAL, 'label')
            ->addOption('summary', 'title', InputArgument::OPTIONAL, 'summary')
            ->addOption('taskPrefix', 'prefTask', InputArgument::OPTIONAL, 'taskPrefix, TRACEWAY, DOM, ORG...')
            ->addOption('priority', 'pr', InputArgument::OPTIONAL, 'priority');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $dto = new IssueDto();
        $dto->setIssueKey($input->getOption('issueKey'))
            ->setAffectedVersion($input->getOption('affectedVersion'))
            ->setPriority($input->getOption('priority'))
            ->setLabel($input->getOption('label'))
            ->setStatus($input->getOption('status'))
            ->setSummary($input->getOption('summary'))
            ->setFixVersion($input->getOption('fixVersion'))
            ->setIssueSearchPrefix($input->getOption('taskPrefix') ?? '');
    
        $response = [];
        if ($pathFile = $input->getOption('pathDataKeys')) {
            try {
                $response = $this->issueManager->updateWithFile($pathFile, $dto);
            } catch (\Exception $e) {
                $io->error($e->getMessage());
            }
        } else {
            $response = $this->issueManager->update($dto->getIssueKey(), $dto);
        }
        var_dump($response, '$response');
        
        //        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        
        return Command::SUCCESS;
    }
}
