<?php

namespace App\Repositories\Interfaces;

interface HomeSliderRepositoryInterface
{
    public function getAllSlider();

    public function addHomeSlider($data);
}

