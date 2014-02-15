<?php

class SubscriptionsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Session');

	public function index() {
		$this->set('subscriptions', $this->Subscription->find('all'));
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Subscription->create();
			if ($this->Subscription->save($this->request->data)) {
				$this->Session->setFlash(__('Your subscription has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to add your subscription.'));
		}
	}
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid subscription'));
		}
		
		$post = $this->Subscription->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Invalid subscription'));
		}
		
		if ($this->request->is(array('post', 'put'))) {
			$this->Subscription->id = $id;
			if ($this->Subscription->save($this->request->data)) {
				$this->Session->setFlash(__('Your subscription has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update your subscription.'));
		}
		
		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		if ($this->Subscription->delete($id)) {
			$this->Session->setFlash(
				__('The subscription with id: %s has been deleted.', h($id))
			);
			return $this->redirect(array('action' => 'index'));
		}
	}
}
