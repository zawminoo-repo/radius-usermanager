<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Group;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;

class GroupController extends BaseController
{
    public function __construct()
	{
		$this->group_model = model(Group::class);
		$this->check_model = model(RadGroupCheck::class);
		$this->reply_model = model(RadGroupReply::class);
	}
	
	//List group name.
	public function index()
    {
		$data['groups'] = $this->group_model->orderBy('group_name', 'asc')->findAll();
		
		return view('group/list', $data);
    }
	
	//Show group detail (groups, radgroupcheck and radgropreply tables).
	public function show($id)
	{
		$data['group'] = $group = $this->group_model->find($id);
		if(!$group) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	
		$data['check_attributes'] = $this->check_model->where('groupname', $group->group_name)->findAll();
		$data['reply_attributes'] = $this->reply_model->where('groupname', $group->group_name)->findAll();
		
		return view('group/detail', $data);
	}
	
	//Create new group name (groups table).
	public function create()
	{
		return view('group/add');
	}
	
	//Store new group name (groups table).
	public function store()
	{
		$rules = ['group_name' => 'required'];
		
		if($this->request->getMethod() === 'post' && $this->validate($rules))
		{
			$data = [
				'group_name' => $this->request->getPost('group_name'),
				'group_descript' => $this->request->getPost('group_descript'),
			];
			
			$this->group_model->save($data);
			session()->setFlashdata('msg', 'Data Successfully added.');
			return redirect()->route('groups');
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	//Edit group name (groups table).
	public function edit($id)
	{
		$data['group'] = $group = $this->group_model->find($id);
		if(!$group) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		
		$data['check_attributes'] = $this->check_model->where('groupname', $group->group_name)->findAll();
		$data['reply_attributes'] = $this->reply_model->where('groupname', $group->group_name)->findAll();
		
		return view('group/edit', $data);
	}
	
	//Update group name (groups table).
	public function update($id)
	{
		$rules = ['group_name' => 'required'];
		
		if($this->request->getMethod() === 'put' && $this->validate($rules))
		{
			$data = [
				'group_name' => $this->request->getPost('group_name'),
				'group_descript' => $this->request->getPost('group_descript'),
			];
			
			$this->group_model->update($id, $data);
			return redirect()->to(route_to('group_show', $id));
		}
	}
	
	//Delete Group name.
	public function delete()
	{
		$id = $this->request->getGet('id');
		$this->group_model->delete($id);
		
		session()->setFlashdata('msg', 'Data Successfully deleted');
		return redirect()->route('groups');
	}
###############################################################################
	
	//Create new radgroup check. $id is for redirect link only.
	public function createGroupCheck($id)
	{
		$data['group'] = $this->group_model->find($id);
		return view('group/add_group_check', $data);
	}
	
	//Store new radgroup check. $id is for redirect link only.
	public function storeGroupCheck($id)
	{
		$rules = [
			'check_attribute' => 'required',
			'check_op' => 'required',
			'check_value' => 'required',
		];
		
		if($this->request->getMethod() === 'post' && $this->validate($rules))
		{
			$data = [
				'groupname' => $this->request->getPost('group_name'),
				'attribute' => $this->request->getPost('check_attribute'),
				'op' => $this->request->getPost('check_op'),
				'value' => $this->request->getPost('check_value'),
			];
			
			$this->check_model->save($data);
			return redirect()->to(route_to('group_show', $id));
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	//Grid update radgroup check.
	public function updateGroupCheck()
	{
		$check_id = $this->request->getPost('check_id');
		$check_attribute = $this->request->getPost('check_attribute');
		$check_op = $this->request->getPost('check_op');
		$check_value = $this->request->getPost('check_value');
		
		$group_id = $this->request->getPost('group_id');

		for($x = 0; $x < count($check_id); $x++)
		{
			$data[] = [
				'id' => $check_id[$x],
				'attribute' => $check_attribute[$x],
				'op' => $check_op[$x],
				'value' => $check_value[$x],
			];
		}

		$this->check_model->updateBatch($data, 'id');
		return redirect()->to(route_to('group_show', $group_id));
	}
	
	//Delete group check.
	public function deleteGroupCheck()
	{
		$id = $this->request->getGet('id');
		$group_id = $this->request->getGet('group_id');
		
		$this->check_model->delete($id);
		return redirect()->to(route_to('group_show', $group_id));
	}
###############################################################################

	//Create new radgroup reply. $id is for redirect link only.
	public function createGroupReply($id)
	{
		$data['group'] = $this->group_model->find($id);
		return view('group/add_group_reply', $data);
	}
	
	//Store new radgroup reply. $id is for redirect link only.
	public function storeGroupReply($id)
	{
		$rules = [
			'reply_attribute' => 'required',
			'reply_op' => 'required',
			'reply_value' => 'required',
		];
		
		if($this->request->getMethod() === 'post' && $this->validate($rules))
		{
			$data = [
				'groupname' => $this->request->getPost('group_name'),
				'attribute' => $this->request->getPost('reply_attribute'),
				'op' => $this->request->getPost('reply_op'),
				'value' => $this->request->getPost('reply_value'),
			];
			
			$this->reply_model->save($data);
			return redirect()->to(route_to('group_show', $id));
		}
		else
		{
			session()->setFlashdata('validation', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}
	
	//Grid update radgroup reply.
	public function updateGroupReply()
	{
		$reply_id = $this->request->getPost('reply_id');
		$reply_attribute = $this->request->getPost('reply_attribute');
		$reply_op = $this->request->getPost('reply_op');
		$reply_value = $this->request->getPost('reply_value');
		
		$group_id = $this->request->getPost('group_id');

		for($x = 0; $x < count($reply_id); $x++)
		{
			$data[] = [
				'id' => $reply_id[$x],
				'attribute' => $reply_attribute[$x],
				'op' => $reply_op[$x],
				'value' => $reply_value[$x],
			];
		}

		$this->reply_model->updateBatch($data, 'id');
		return redirect()->to(route_to('group_show', $group_id));
	}
	
	//Delete group reply.
	public function deleteGroupReply()
	{
		$id = $this->request->getGet('id');
		$group_id = $this->request->getGet('group_id');
		
		$this->reply_model->delete($id);
		return redirect()->to(route_to('group_show', $group_id));
	}
}
