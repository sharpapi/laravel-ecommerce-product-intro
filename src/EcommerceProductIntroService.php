<?php

declare(strict_types=1);

namespace SharpAPI\EcommerceProductIntro;

use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use SharpAPI\Core\Client\SharpApiClient;

/**
 * @api
 */
class EcommerceProductIntroService extends SharpApiClient
{
    /**
     * Initializes a new instance of the class.
     *
     * @throws InvalidArgumentException if the API key is empty.
     */
    public function __construct()
    {
        parent::__construct(config('sharpapi-ecommerce-product-intro.api_key'));
        $this->setApiBaseUrl(
            config(
                'sharpapi-ecommerce-product-intro.base_url',
                'https://sharpapi.com/api/v1'
            )
        );
        $this->setApiJobStatusPollingInterval(
            (int) config(
                'sharpapi-ecommerce-product-intro.api_job_status_polling_interval',
                5)
        );
        $this->setApiJobStatusPollingWait(
            (int) config(
                'sharpapi-ecommerce-product-intro.api_job_status_polling_wait',
                180)
        );
        $this->setUserAgent('SharpAPILaravelEcommerceProductIntro/1.0.0');
    }

    /**
     * Generates a shorter version of the product description.
     * Provide as many details and parameters of the product to get the best marketing introduction possible.
     * Comes in handy with populating product catalog data and bulk products processing.
     *
     * @throws GuzzleException
     *
     * @api
     */
    public function generateProductIntro(
        string $productData,
        ?string $language = null,
        ?int $maxLength = null,
        ?string $voiceTone = null
    ): string {
        $response = $this->makeRequest(
            'POST',
            '/ecommerce/product_intro',
            [
                'content' => $productData,
                'language' => $language,
                'max_length' => $maxLength,
                'voice_tone' => $voiceTone,
            ]);

        return $this->parseStatusUrl($response);
    }
}