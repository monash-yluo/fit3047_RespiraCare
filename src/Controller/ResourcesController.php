<?php
declare(strict_types=1);

namespace App\Controller;

use DateTime;

/**
 * Resources Controller
 *
 * @property \App\Model\Table\ResourcesTable $Resources
 */
class ResourcesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $identity = $this->Authentication->getIdentity();
        $search = $this->request->getQuery('search');
        $query = $this->Resources->find();
        if($identity->role === 'patient') {
            $query->where(['status' => 'Active']);
        }

        if (!empty($search)) {
            $query->where(['title LIKE' => '%' . $search . '%']);
        }

        $type = $this->request->getQuery('type');
        if (!empty($type)) {
            $query->where(['Resources.type' => $type]);
        }

        $status = $this->request->getQuery('status');
        if (!empty($status)) {
            $query->where(['Resources.status' => $status]);
        } else {
            if ($identity->role !== 'admin' && $identity->role !== 'clinician') {
                $query->where(['Resources.status' => 'active']);
            }
        }

        $preset = $this->request->getQuery('date_preset');

        if ($preset === 'today') {
            $query->where(['Resources.published_date >=' => new DateTime('today')]);
        } elseif (in_array($preset, ['7', '30', '90'])) {
            $query->where(['Resources.published_date >=' => new DateTime("-{$preset} days")]);
        }

        $this->paginate = [
            'limit' => 12,
            'order' => ['created' => 'DESC'],
        ];

        $resources = $this->paginate($query);
        $this->set(compact('resources'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();

            return $this->render('/element/table/entity_tables/resources_grid');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Resource id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $resource = $this->Resources->get($id, contain: []);
        $this->set(compact('resource'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->checkRole(['admin', 'clinician']);

        $resource = $this->Resources->newEmptyEntity();
        if ($this->request->is('post')) {
            $resource = $this->Resources->patchEntity($resource, $this->request->getData());

            // Trim whitespace from content
            if (!empty($resource->content)) {
                $resource->content = trim($resource->content);
            }

            // Validate that PDF and Video types must have a URL link / 验证PDF和视频类型必须有URL链接
            if (in_array($resource->type, ['PDF', 'Video', 'External Link']) && empty($resource->url_link)) {
                $this->Flash->error(__('PDF, Video, and External Link resources must have a URL link.'));
            } elseif ($this->Resources->save($resource)) {
                $this->Flash->success(__('The resource has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('resource'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Resource id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $this->checkRole(['admin', 'clinician']);

        $resource = $this->Resources->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resource = $this->Resources->patchEntity($resource, $this->request->getData());
            
            // Trim whitespace from content
            if (!empty($resource->content)) {
                $resource->content = trim($resource->content);
            }

            // Validate that PDF and Video types must have a URL link / 验证PDF和视频类型必须有URL链接
            if (in_array($resource->type, ['PDF', 'Video', 'External Link']) && empty($resource->url_link)) {
                $this->Flash->error(__('PDF, Video, and External Link resources must have a URL link.'));
            } elseif ($this->Resources->save($resource)) {
                $this->Flash->success(__('The resource has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The resource could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('resource'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Resource id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->checkRole(['admin', 'clinician']);

        $this->request->allowMethod(['post', 'delete']);
        $resource = $this->Resources->get($id);
        if ($this->Resources->delete($resource)) {
            $this->Flash->success(__('The resource has been deleted.'));
        } else {
            $this->Flash->error(__('The resource could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
