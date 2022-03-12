<?php

namespace App\Pipelines\Contracts;

interface PipelineContract
{
    /**
     * @param $data
     * @param callable $next
     * @return mixed
     */
    public function handle($data, $next);
}
