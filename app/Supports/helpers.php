<?php

if (!function_exists('responseApi')) {
    /**
     * @param $status
     * @param $error
     * @param $message
     * @param null $data
     * @return array
     * @author h.kholghi
     */
    function responseApi($status, $error, $message, $data = null): array
    {
        return [
            'status' => $status,
            'error' => $error,
            'message' => $message,
            'data' => $data,
        ];
    }
}
