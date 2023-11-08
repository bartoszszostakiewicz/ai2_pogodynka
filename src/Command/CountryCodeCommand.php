<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'country:code',
    description: 'Add a short description for your command',
)]
class CountryCodeCommand extends Command
{
    public function __construct(
        private WeatherUtil $weatherUtil,
        private LocationRepository $locationRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('code', InputArgument::OPTIONAL, 'Country code')
            ->addArgument('city', InputArgument::OPTIONAL, 'City name')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('code');
        $city = $input->getArgument('city');

        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $city);

        $io->writeln(sprintf('Location: %s', $city));

        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\t%s: %s",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getCelsius()
            ));
        }


        return Command::SUCCESS;
    }
}
