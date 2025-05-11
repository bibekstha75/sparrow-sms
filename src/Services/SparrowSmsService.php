<?php

namespace Bibekshrestha\SparrowSms\Services;

use Bibekshrestha\SparrowSms\Contracts\SparrowSmsInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class SparrowSmsService implements SparrowSmsInterface
{
    protected Client $client;

    public function __construct()
    {
        $this->client = $this->initializeClient();
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function send(array $data)
    {
        $config = $this->getConfig();
        $args = [
            'token' => $config['token'],
            'from' => $config['from'],
            'to' => is_array($data['recipient_number']) ? implode(',', $data['recipient_number']) : $data['recipient_number'],
            'text' => $data['message'],
        ];

        $url = $config['url'];
        try {
            $response = $this->client->post($url, ['form_params' => $args]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $clientException) {
            $this->logError($clientException->getMessage());

            throw new Exception($clientException->getMessage());
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendBulk(array $data): array
    {
        if (!isset($data['recipient_numbers']) || !is_array($data['recipient_number'])) {
            $this->logError('Please provide an array of recipient phone numbers for bulk SMS.');
            throw new Exception('Please provide an array of recipient phone numbers for bulk SMS.');
        }

        $bulkResponse = [];
        foreach ($data['recipient_numbers'] as $phone) {
            $singleData = [
                'recipient_number' => $phone,
                'message' => $data['message'],
            ];
            $bulkResponse[] = $this->send($singleData);
        }

        return $bulkResponse;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function checkCredits()
    {
        $config = $this->getConfig();
        $args = [
            'token' => $config['token'],
        ];

        $url = $config['credit_url'];

        try {
            $response = $this->client->post($url, ['form_params' => $args]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $clientException) {
            $this->logError('Failed to check credits.' . $clientException->getMessage());

            throw new Exception($clientException->getMessage());
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    protected function initializeClient(): Client
    {
        return new Client();
    }

    /**
     * @throws Exception
     */
    protected function getConfig(): array
    {
        $config = config('sparrow-sms');

        if (empty($config)) {
            $this->logError('Sparrow SMS config not found.');

            throw new Exception('Sparrow SMS config not found.');
        }
        return $config;
    }

    protected function logError($message): void
    {
        if (config('sparrow-sms.enable_logging', false)) {
            logger()->error($message);
        }
    }
}
