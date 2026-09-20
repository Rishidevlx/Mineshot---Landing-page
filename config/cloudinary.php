<?php
// config/cloudinary.php
require_once __DIR__ . '/db.php';

if (!function_exists('uploadToCloudinary')) {
    /**
     * Upload an image file to Cloudinary
     * 
     * @param string $filePath Full path to temporary uploaded file or image data
     * @param string $folder Target Cloudinary folder
     * @return array [success => bool, url => string, public_id => string, error => string]
     */
    function uploadToCloudinary($filePath, $folder = 'mineshot') {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');

        if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
            return [
                'success' => false,
                'error' => 'Cloudinary credentials are not configured in .env file.'
            ];
        }

        if (!file_exists($filePath)) {
            return [
                'success' => false,
                'error' => 'Target file does not exist.'
            ];
        }

        $timestamp = time();
        $paramsToSign = [
            'folder' => $folder,
            'timestamp' => $timestamp
        ];
        ksort($paramsToSign);

        // Build string to sign: key1=val1&key2=val2...secret
        $signString = '';
        foreach ($paramsToSign as $k => $v) {
            $signString .= "{$k}={$v}&";
        }
        $signString = rtrim($signString, '&') . $apiSecret;
        $signature = sha1($signString);

        $apiUrl = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

        $postFields = [
            'file' => new CURLFile($filePath),
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder' => $folder
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || !empty($curlError)) {
            return [
                'success' => false,
                'error' => 'cURL error: ' . $curlError
            ];
        }

        $data = json_decode($response, true);
        if ($httpCode >= 200 && $httpCode < 300 && isset($data['secure_url'])) {
            return [
                'success' => true,
                'url' => $data['secure_url'],
                'public_id' => $data['public_id'],
                'format' => $data['format'] ?? '',
                'width' => $data['width'] ?? 0,
                'height' => $data['height'] ?? 0
            ];
        }

        $errMsg = $data['error']['message'] ?? 'Failed to upload to Cloudinary (HTTP ' . $httpCode . ')';
        return [
            'success' => false,
            'error' => $errMsg
        ];
    }
}

if (!function_exists('deleteFromCloudinary')) {
    /**
     * Delete an image from Cloudinary by its public_id
     * 
     * @param string $publicId Cloudinary public_id
     * @return array [success => bool, error => string]
     */
    function deleteFromCloudinary($publicId) {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');

        if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
            return [
                'success' => false,
                'error' => 'Cloudinary credentials are not configured in .env file.'
            ];
        }

        $timestamp = time();
        $paramsToSign = [
            'public_id' => $publicId,
            'timestamp' => $timestamp
        ];
        ksort($paramsToSign);

        $signString = '';
        foreach ($paramsToSign as $k => $v) {
            $signString .= "{$k}={$v}&";
        }
        $signString = rtrim($signString, '&') . $apiSecret;
        $signature = sha1($signString);

        $apiUrl = "https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy";

        $postFields = [
            'public_id' => $publicId,
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || !empty($curlError)) {
            return [
                'success' => false,
                'error' => 'cURL error: ' . $curlError
            ];
        }

        $data = json_decode($response, true);
        if ($httpCode >= 200 && $httpCode < 300 && isset($data['result']) && ($data['result'] === 'ok' || $data['result'] === 'not found')) {
            return ['success' => true];
        }

        $errMsg = $data['error']['message'] ?? 'Failed to delete from Cloudinary';
        return [
            'success' => false,
            'error' => $errMsg
        ];
    }
}
