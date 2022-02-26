<?php

/**
 * All Service Providers are registered here.
 * @version 1.0.0
 * @date    2022-02-26
 */

mangocube_app()->add('app-config', new MangoCube_Packages\DI\Argument\Literal\ArrayArgument(['blah', 'blah2']));



mangocube_app()->addServiceProvider(new Mangocube\serviceProviders\SomeServiceProvider);