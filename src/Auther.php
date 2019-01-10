<?php

namespace Simplicate\Rainforest;

/**
 * Based on
 *
 * @see     https://github.com/rainforestapp/auth (/lib/rainforest_auth.rb)
 *
 * @package Simplicate\Rainforest
 */
class Auther {

    /**
     * Browse to https://app.rainforestqa.com/settings/integrations and have the account owner rotate the token. Token MUST be the account owners.
     *
     * @var string
     */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $digest
     * @param string $callbackType
     * @param array  $options
     *
     * @return bool
     */
    public function verify($digest, $callbackType, $options) {
        return $digest === $this->sign($callbackType, $options);
    }

    /**
     * @param int    $runId
     * @param string $callbackType
     *
     * @return string
     */
    public function getCallbackUrl($runId, $callbackType) {
        $digest = $this->sign($callbackType, ['run_id' => $runId]);

        return "https://app.rainforestqa.com/api/1/callback/run/{$runId}/{$callbackType}/{$digest}";
    }

    /**
     * @return string
     */
    private function getKeyHash() {
        return hash('sha256', $this->apiKey);
    }

    /**
     * @param string $callbackType
     * @param array  $options
     *
     * @return string
     */
    private function sign($callbackType, $options) {
        $mergedData = $this->mergeData($callbackType, $options);

        return hash_hmac('sha1', $mergedData, $this->getKeyHash());
    }

    /**
     * @param string $callbackType
     * @param array  $options
     *
     * @return false|string
     */
    private function mergeData($callbackType, $options) {
        return json_encode([
            'callback_type' => $callbackType,
            'options'       => $options,
        ]);
    }

}
