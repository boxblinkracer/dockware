<?php

use Doctrine\DBAL\Connection;

class RegionSwitcher
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $region
     * @return void
     * @throws Exception
     */
    public function switchRegion($region)
    {
        $currency = new \CurrencyRepository($this->connection);
        $locales = new \LocaleRepository($this->connection);
        $languages = new \LanguageRepository($this->connection);
        $salesChannels = new \SalesChannelRepository($this->connection);
        $snippets = new \SnippetRepository($this->connection);

        switch (strtolower($region)) {
            case 'us':
                $localeISO = 'en-GB'; # only GB existing at the moment
                $currencyISO = 'USD';
                break;

            case 'de':
                $localeISO = 'de-DE';
                $currencyISO = 'EUR';
                break;

            default:
                throw new \Exception('Region ' . $region . ' is not supported at the moment!');
        }

        $localeId = $locales->getIdByLocale($localeISO);
        $languageId = $languages->getIdByLocale($localeId);
        $snippetSetId = $snippets->getSnippetSetIdByLocale($localeISO);
        $currencyId = $currency->getIdByIso($currencyISO);

        $currency->setDefaultCurrency($currencyISO);

        $salesChannels->updateAllLanguages($languageId, $currencyId, $snippetSetId);

    }
}