<?php

require 'Enum.class.php';

class Status extends Enum
{

    const EMPTY = 1;
    const SHIPMENT_LOADING = 2;
    const SHIPMENT_READY = 3;
    const SHIPMENT_IN_TRANSIT = 4;
    const SHIPMENT_COMPLETE = 5;
    const SHIPMENT_FORFEITED = 6;
}
