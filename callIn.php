<?php

require __DIR__ . '/vendor/autoload.php';

/*
* start: for events listener
*/

use PAMI\Message\Event\EventMessage;
use PAMI\Message\Event\DialBeginEvent;
use PAMI\Message\Event\DialEndEvent;
use PAMI\Message\Event\NewchannelEvent;
use PAMIClient\CallAMI;

/*
* end: for events listener
*/

$callami = new CallAMI();
$pamiClient = $pamiClient->NewPAMIClient();
$pamiClient->open();

//обрабатываем NewchannelEvent события
$pamiClient->registerEventListener(
    function (EventMessage $event) use ($helper, $callami, $globalsObj) {
        // $callUniqueid = $event->getUniqueid();
        // $extNum = $event->getCallerIDNum();
        // $CallChannel = $event->getChannel();
        // $extention = $event->getExtension();

        var_dump('New NewchannelEvent call');
    },
    function (EventMessage $event) use ($globalsObj) {
        //для фильтра берем только указанные внешние номера
        return
            $event instanceof NewchannelEvent;
            //проверяем на вхождение в массив
            // && in_array($event->getExtension(), $globalsObj->extentions);
    }
);

//обрабатываем DialBeginEvent события
$pamiClient->registerEventListener(
    function (EventMessage $event) use ($helper, $globalsObj) {
        // $callUniqueid = $event->getUniqueid();
        // $intNum = $event->getDestCallerIDNum();
        // $extNum = $event->getCallerIDNum();
        // $CallChannel = $event->getChannel();

        var_dump('New incoming call');
    },
    function (EventMessage $event) use ($globalsObj) {
        //для фильтра по uniqueid
        return
            $event instanceof DialBeginEvent;
            //проверяем входит ли событие в массив с uniqueid внешних звоноков
            // && in_array($event->getUniqueid(), $globalsObj->uniqueids);
    }
);

//обрабатываем DialEndEvent события
$pamiClient->registerEventListener(
    function (EventMessage $event) use ($helper, $globalsObj) {
        // $callUniqueid = $event->getUniqueid();
        // $globalsObj->intNums[$callUniqueid] = $event->getDestCallerIDNum();
        // $extNum = $event->getCallerIDNum();

        var_dump('DialEndEvent');
        // switch ($event->getDialStatus()) {
        //     case 'ANSWER': //кто-то отвечает на звонок
        //         var_dump('incoming call ANSWER');
        //         break;
        //     case 'BUSY': //занято
        //         var_dump('incoming call BUSY');
        //         break;
        //     case 'CANCEL': //звонивший бросил трубку
        //         var_dump('incoming call CANCEL');
        //         break;
        //     default:
        //         break;
        // }
    },
    function (EventMessage $event) use ($globalsObj) {
        //для фильтра по uniqueid
        return
            $event instanceof DialEndEvent;
            //проверяем входит ли событие в массив с uniqueid внешних звонков
            // && in_array($event->getUniqueid(), $globalsObj->uniqueids);
    }
);

while (true) {
    $pamiClient->process();
    usleep($helper->getConfig('listener_timeout'));
}
$pamiClient->ClosePAMIClient($pamiClient);
