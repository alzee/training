<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Absence;
use DateTime;

class GenAbsenceCommand extends Command
{
    private const ABSENCE_TYPES = ['sick', 'vacation', 'personal'];
    private const NUM_RECORDS = 20;
    
    protected static $defaultName = 'app:gen-absence';
    protected static $defaultDescription = 'Generate random absence records for testing';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addOption('count', 'c', InputOption::VALUE_OPTIONAL, 'Number of records to generate', self::NUM_RECORDS)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int 
    {
        $io = new SymfonyStyle($input, $output);
        $count = $input->getOption('count');

        $startYear = date('Y');
        $startDate = new DateTime("$startYear-01-01");
        $endDate = new DateTime("$startYear-12-31");

        for ($i = 0; $i < $count; $i++) {
            $absence = new Absence();
            
            // Random date between start and end of year
            $timestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());
            $leaveAt = new DateTime();
            $leaveAt->setTimestamp($timestamp);
            
            // Random duration between 1-5 days
            $duration = mt_rand(1, 5);
            $endTimestamp = $timestamp + ($duration * 24 * 60 * 60);
            $backAt = new DateTime();
            $backAt->setTimestamp($endTimestamp);

            $absence->setLeaveAt($leaveAt);
            $absence->setBackAt($backAt);
            $absence->setNote('Generated test absence');
            $absence->setApproved(mt_rand(0, 1) === 1);

            $this->em->persist($absence);
            
            $io->writeln(sprintf('Generated absence: %s to %s (%d days)',
                $leaveAt->format('Y-m-d'),
                $backAt->format('Y-m-d'),
                $duration
            ));
        }

        $this->em->flush();
        $io->success(sprintf('Generated %d absence records.', $count));

        return Command::SUCCESS;
    }
}
