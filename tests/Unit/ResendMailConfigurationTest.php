<?php

namespace Tests\Unit;

use Illuminate\Mail\Transport\ResendTransport;
use Tests\TestCase;

class ResendMailConfigurationTest extends TestCase
{
    public function test_resend_mailer_can_be_resolved(): void
    {
        config()->set('services.resend.key', 're_test_key');

        $transport = app('mail.manager')
            ->mailer('resend')
            ->getSymfonyTransport();

        $this->assertInstanceOf(ResendTransport::class, $transport);
    }
}
