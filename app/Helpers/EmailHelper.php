<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class EmailHelper
{
    /**
     * Test SMTP Connection via Symfony Mailer (Laravel 12)
     * @return array
     */
    public static function testSmtpConnection()
    {
        try {
            $mailer = config('mail.mailer');

            // If using log driver, no need to test SMTP connection
            if ($mailer === 'log') {
                return [
                    'status' => 'SUCCESS',
                    'message' => 'Log Driver Mode - Emails will be written to storage/logs/laravel.log',
                    'config' => [
                        'mailer' => 'log',
                        'log_file' => 'storage/logs/laravel.log',
                    ],
                    'note' => 'Check log file to see email content'
                ];
            }

            $config = config('mail.mailers.smtp');

            if (!$config) {
                return [
                    'status' => 'FAILED',
                    'error' => 'SMTP configuration not found',
                ];
            }

            // Validate required fields
            $required = ['host', 'port', 'username', 'password'];
            foreach ($required as $field) {
                if (empty($config[$field])) {
                    return [
                        'status' => 'FAILED',
                        'error' => "Missing configuration: {$field}. Check your .env file.",
                    ];
                }
            }

            // Get Symfony Transport
            $transport = Mail::mailer('smtp')->getSymfonyTransport();

            // Test if transport can be accessed
            if (!$transport) {
                return [
                    'status' => 'FAILED',
                    'error' => 'Cannot access mail transport',
                ];
            }

            return [
                'status' => 'SUCCESS',
                'message' => 'SMTP Configuration OK!',
                'config' => [
                    'mailer' => config('mail.mailer'),
                    'host' => $config['host'],
                    'port' => $config['port'],
                    'encryption' => $config['encryption'] ?? 'none',
                    'username' => $config['username'],
                    'password_set' => !empty($config['password']),
                ],
                'note' => 'Actual connection will be tested when sending email'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'FAILED',
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }
    }

    /**
     * Test Email Sending
     * @param string $toEmail
     * @param string $subject
     * @param string $body
     * @return array
     */
    public static function sendTestEmail($toEmail, $subject = 'Test Email', $body = 'Test email body')
    {
        try {
            // Validate email format
            if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
                return [
                    'status' => 'FAILED',
                    'error' => 'Invalid email address format',
                ];
            }

            $mailer = config('mail.mailer');

            // Send test email
            Mail::raw($body, function ($message) use ($toEmail, $subject) {
                $message->to($toEmail)
                        ->subject($subject);
            });

            // If using log driver, provide helpful message
            if ($mailer === 'log') {
                return [
                    'status' => 'SUCCESS',
                    'message' => "Test email logged successfully!",
                    'note' => 'Email content is written to storage/logs/laravel.log',
                    'check_log' => 'Run: php artisan tail',
                    'log_file' => 'storage/logs/laravel.log',
                    'timestamp' => now(),
                ];
            }

            return [
                'status' => 'SUCCESS',
                'message' => "Test email sent to {$toEmail}",
                'timestamp' => now(),
                'note' => 'Check inbox or spam folder'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'FAILED',
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }
    }

    /**
     * Get Email Status Badge Color
     * @param string $status
     * @return string Bootstrap color class
     */
    public static function getStatusBadgeClass($status)
    {
        return match ($status) {
            'draft' => 'badge-secondary',
            'sent' => 'badge-success',
            'failed' => 'badge-danger',
            default => 'badge-light',
        };
    }

    /**
     * Get Email Status Label
     * @param string $status
     * @return string
     */
    public static function getStatusLabel($status)
    {
        return match ($status) {
            'draft' => 'Belum Dikirim',
            'sent' => 'Terkirim',
            'failed' => 'Gagal Dikirim',
            default => 'Unknown',
        };
    }

    /**
     * Validate Email Address
     * @param string $email
     * @return bool
     */
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Get Email Configuration Info
     * @return array
     */
    public static function getEmailConfig()
    {
        $config = config('mail.mailers.smtp');

        return [
            'mailer' => config('mail.mailer'),
            'from' => config('mail.from'),
            'smtp' => [
                'host' => $config['host'] ?? 'NOT SET',
                'port' => $config['port'] ?? 'NOT SET',
                'encryption' => $config['encryption'] ?? 'none',
                'username' => $config['username'] ?? 'NOT SET',
                'password_set' => !empty($config['password']),
            ]
        ];
    }
}
