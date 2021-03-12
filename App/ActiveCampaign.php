<?php

namespace App;

use App\Repositories\LoadRepository;
use App\Repositories\WorkerRepository;

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
                'salesman'=>'victoria'
            ],
            [
                'salesman'=>'pedro'
            ],
            [
                'salesman'=>'pablo'
            ],
            [
                'salesman'=>'victor'
            ],
            [
                'salesman'=>'victoria'
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
    public function meetingScheuled()
    {
		header('Content-Type: text/plain');
		header('Cache-Control: no-cache; no-store; no-transform');

		$balancer = new LoadBalancer(
			new LoadRepository()
		);

		$worker = new WorkerRepository();

		$owner = $balancer->serve();

		$worker->save($owner);

		echo $owner;
    }
    public function getNextMeeting()
    {
        header('Content-Type: application/json');

        $worker = new WorkerRepository();

        echo json_encode($worker->get());
    }

    public function createReferral()
    {
        $email = $_POST['contact']['fields']['referidos'];
        $tags = 'referral';
        $data['email'] = $email;
        $data['tags'] = $tags;
        $data['p[25]'] = 25;
        var_dump($_POST);
        $this->activeCampaign->exec('contact_add', $data, true);
    }
}
