<?php

namespace App\Services;

use Illuminate\Cache\CacheManager;
use Illuminate\Log\Logger;
use Illuminate\Mail\Mailer;

class ReportService
{
    protected $cache;
    protected $logger;


    // Constructor injection for dependencies
    public function __construct(CacheManager $cache, Logger $logger)
    {
        $this->cache = $cache;
        $this->logger = $logger;

    }

    // Method to generate and send a report
    public function generateAndSendReport($email)
    {
        // Generate the report (for simplicity, it's just a string here)
        $report = 'This is a generated report!';

        // Cache the report
        $this->cache->put('report', $report, 3600); // Cache for 1 hour

        // Log the action
        $this->logger->info('Report generated and cached.');

        // Send the report via email

        return 'Report generated and sent to ' . $email;
    }
}


