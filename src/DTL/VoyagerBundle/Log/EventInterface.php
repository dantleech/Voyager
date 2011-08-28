<?php

namespace DTL\VoyagerBundle\Log;

interface EventInterface 
{
    public function getDate();
    public function getType();
}
