<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\TimebuckTable;
use Cake\Utility\Security;

/**
 * Timebucks Controller
 *
 * @method \App\Model\Entity\Timebuck[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimebucksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('layout/Timebuck');
        // $this->layout = "Timebuck";
        $TimebuckTable = new TimebuckTable();
        $Timebuck = $TimebuckTable->find('all')->toArray();
        foreach ($Timebuck as $user) {
            $name = Security::decrypt(base64_decode($user['name']), Security::getSalt());
            $description = Security::decrypt(base64_decode($user['description']), Security::getSalt());
            $requirements = Security::decrypt(base64_decode($user['requirements']), Security::getSalt());
            $click_url = Security::decrypt(base64_decode($user['click_url']), Security::getSalt());
        }



        // Parse DataTables request parameters
    }

    public function getRecords()
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('json');
        $requestData = $this->request->getData();

        // Pagination and sorting options
        $length = $requestData['length'];
        $offset = $requestData['start'];
        $sortColumn = $requestData['columns'][$requestData['order'][0]['column']]['name'];
        $sortDir = $requestData['order'][0]['dir'];
        $searchQuery = $requestData['search']['value'];

        // Your query to fetch data with pagination and sorting
        $TimebuckTable = new TimebuckTable();
        // $Timebuck_all = $TimebuckTable->find('all');
        $Timebuck = $TimebuckTable->find('all')
            ->offset($offset)
            ->limit($length)
            ->order(['epc' => $sortDir])
            ->toArray();
            
        foreach ($Timebuck as $key => $buck) {
            $Timebuck[$key]['name'] = Security::decrypt(base64_decode($buck['name']), Security::getSalt());
            $Timebuck[$key]['description'] = Security::decrypt(base64_decode($buck['description']), Security::getSalt());
            $Timebuck[$key]['requirements'] = Security::decrypt(base64_decode($buck['requirements']), Security::getSalt());
            $Timebuck[$key]['click_url'] = Security::decrypt(base64_decode($buck['click_url']), Security::getSalt());
        }
        $all = [];
        if (!empty($searchQuery)) {
            foreach($Timebuck as $key => $a)
            {
                $position = strpos(strtolower($a->name), strtolower($searchQuery));

                if ($position !== false) {
                    $all[] = $Timebuck[$key];
                } else {
                    unset($Timebuck[$key]);
                }
            }
            $Timebuck = $all;
        }

        $data = [
            'draw' => intval($requestData['draw']),
            'recordsTotal' => count($Timebuck),
            'recordsFiltered' => $TimebuckTable->find('all')->count(),
            'data' => $Timebuck,
        ];

        return $this->response->withStringBody(json_encode($data));
    }

    /**
     * View method
     *
     * @param string|null $id Timebuck id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $timebuck = $this->Timebucks->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('timebuck'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $timebuck = $this->Timebucks->newEmptyEntity();
        if ($this->request->is('post')) {
            $timebuck = $this->Timebucks->patchEntity($timebuck, $this->request->getData());
            if ($this->Timebucks->save($timebuck)) {
                $this->Flash->success(__('The timebuck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The timebuck could not be saved. Please, try again.'));
        }
        $this->set(compact('timebuck'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Timebuck id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $timebuck = $this->Timebucks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $timebuck = $this->Timebucks->patchEntity($timebuck, $this->request->getData());
            if ($this->Timebucks->save($timebuck)) {
                $this->Flash->success(__('The timebuck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The timebuck could not be saved. Please, try again.'));
        }
        $this->set(compact('timebuck'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Timebuck id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $timebuck = $this->Timebucks->get($id);
        if ($this->Timebucks->delete($timebuck)) {
            $this->Flash->success(__('The timebuck has been deleted.'));
        } else {
            $this->Flash->error(__('The timebuck could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
