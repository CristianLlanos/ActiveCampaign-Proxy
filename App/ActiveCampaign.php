<?php

namespace App;

/**
 * @property Connection activeCampaign
 */
class ActiveCampaign
{
    /**
     * @var \string[][]
     */
    private $salesmen_force;
    /**
     * @var \string[][]
     */
    private $new_salesmen_force;

    public function __construct()
    {
        $this->salesmen_force=[
            [
                'salesman'=>'melissa'
            ],
            [
                'salesman'=>'pedro'
            ]
        ];
        $this->new_salesmen_force=[
            [
                'salesman'=>'pablo'
            ],
            [
                'salesman'=>'victor'
            ]
        ];
        $this->activeCampaign = new Connection();
    }

    public function createClient($request)
    {
        if (!isset($request['email'])) die('Email requerido');
        if (!isset($request['firstName'])) die('Nombre requerido');
        if (!isset($request['lastName'])) die('Apellido requerido');

        $data = [
            'email' => $request['email'],
            'first_name' => $request['firstName'],
            'last_name' => $request['lastName']
        ];

        if (isset($request['extraData'])) {
            foreach ($request['extraData'] as $key => $value) {
                $data[$key] = $value;
            }
        }

        $this->activeCampaign->exec('contact_sync', $data);
    }

    public function addTag($request)
    {
        if (!isset($request['email'])) die('Email requerido');
        $data = [
            'email' => $request['email'],
            'tags' => $request['tags']
        ];
        $this->activeCampaign->exec('contact_tag_add', $data);
    }

    public function addEvent($request)
    {
        if (!isset($request['email'])) die('Email requerido');
        $data = [
            'email' => $request['email'],
            'event_value' => $request['event_value']
        ];
        $this->activeCampaign->execEvent($request['event'], $data);
    }

    public function updateClient($request)
    {
        if (!isset($request['email'])) die('Email requerido');

        $data = [
            'email' => $request['email'],
        ];

        if (isset($request['id'])) {
            $data['id'] = $request['id'];
        }

        if (isset($request['extraData'])) {
            foreach ($request['extraData'] as $key => $value) {
                $data[$key] = $value;
            }
        }

        $this->activeCampaign->exec('contact_sync', $data);
    }

    public function updateEmailContact($request)
    {
        if (!isset($request['email'])) die('Email requerido');
        if (!isset($request['id'])) die('Contact ID requerido');

        $data = [
            'email' => $request['email'],
            'id' => $request['id']
        ];

        var_dump($data);

        $this->activeCampaign->exec('contact_edit', $data);
    }

    public function createCustomer()
    {

    }

    public function generateOrder()
    {

    }

    public function meetingScheuled()
    {
        $current_meeting = file_get_contents('next_meeting_calendar.txt', true);
        $pre=$current_meeting*1+1;
        if ($pre==2){
            $pre=0;
        }
        chmod('next_meeting_calendar.txt', '777');
        file_put_contents('next_meeting_calendar.txt', $pre, FILE_USE_INCLUDE_PATH);
        echo $this->salesmen_force[$pre*1]['salesman'];
    }
    public function getNextMeeting()
    {
        $pre= file_get_contents('next_meeting_calendar.txt', true);
        header('Content-Type: application/json');
        echo json_encode($this->salesmen_force[$pre*1]['salesman']);

    }
    public function newMeetingScheuled()
    {
        $current_meeting = file_get_contents('new_next_meeting_calendar.txt', true);
        $pre=$current_meeting*1+1;
        if ($pre==2){
            $pre=0;
        }
        chmod('new_next_meeting_calendar.txt', '777');
        file_put_contents('new_next_meeting_calendar.txt', $pre, FILE_USE_INCLUDE_PATH);
        echo $this->new_salesmen_force[$pre*1]['salesman'];
    }
    public function newGetNextMeeting()
    {
        $pre= file_get_contents('new_next_meeting_calendar.txt', true);
        header('Content-Type: application/json');
        echo json_encode($this->new_salesmen_force[$pre*1]['salesman']);

    }
}
